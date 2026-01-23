//functions
import { registerPlugin } from '@wordpress/plugins';
import { useSelect, useDispatch } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { useState, useEffect, useRef } from '@wordpress/element';
import { PluginDocumentSettingPanel, store as editorStore } from '@wordpress/editor';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';

//components
import { Button, Flex, FlexItem} from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';

/**
 * Register plugin
 */
export function ButtonTTS() {
    registerPlugin('kptl-tts-render-panel', {
        render: renderButtonTTS,
    });
}

/**
 * Main panel component
 */
function renderButtonTTS() {

    //mimic states defined in /includes/tts/class-tts-meta.php
    const STATUS_LABELS = [
        __("Nespustené", 'kapital'),                //STATUS_NOT_STARTED = 0;
        __("Chyba: Timeout", 'kapital'),            //STATUS_TIMEOUT = 1;
        __("Chyba: ElevenLabs API", 'kapital'),     //STATUS_API_ERROR = 2;
        __("Prebieha konverzia", 'kapital'),        //STATUS_PROCESSING = 3;
        __("Úspešné", 'kapital'),                   //STATUS_COMPLETED = 4;
        __("Manuálne nahrané audio", 'kapital'),    //STATUS_MANUAL_UPLOAD = 5;
    ];

    const POLLING_RATE = 10000; // ms

    const postType = useSelect((select) => select('core/editor').getCurrentPostType(), []);
    const postId = useSelect((select) => select('core/editor').getCurrentPostId(), []);

    //track "post saving" so the polling loop does not start when during save
    const { isSaving, isAutosaving } = useSelect((select) => ({
        isSaving: select(editorStore).isSavingPost(),
        isAutosaving: select(editorStore).isAutosavingPost(),
    }));

    const { savePost } = useDispatch('core/editor');

    const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
    const fetchedCreditsRef = useRef(false);

    const [status, setStatus] = useState(meta?._kptl_tts_status ?? 0);
    const [audioID, setAudioID] = useState(meta?._kptl_tts_audio_id ?? 0);

    //sync state and audioID when meta changes
    useEffect(() => {
        setStatus(meta?._kptl_tts_status ?? 0);
        setAudioID(meta?._kptl_tts_audio_id ?? 0);
    }, [meta]);

    //separate UI state for immediate feedback, not only derived by status
    const [isProcessingUI, setIsProcessingUI] = useState(status === 3);

    //sync isProcessingUI with status
    useEffect(() => {
        setIsProcessingUI(status === 3);
    }, [status]);

    const [credits, setCredits] = useState(null);
    const [loadingCredits, setLoadingCredits] = useState(false);

    const audioURL = useSelect((select) => {
        if (!audioID) return null;
        const media = select('core').getMedia(audioID);
        return media?.source_url || null;
    }, [audioID]);

    // Fetch credits on mount and when status changes to completion states
    useEffect(() => {
        if (postType !== 'post') return;

        const shouldFetch = !fetchedCreditsRef.current || [1, 2, 4].includes(status);

        if (!shouldFetch) return;

        fetchedCreditsRef.current = true;

        setLoadingCredits(true);

        apiFetch({ path: 'tts/v1/credits', method: 'GET' })
            .then((response) => {
                if (response?.success) {
                    setCredits(response.data.toLocaleString('sk-SK'));
                } else {
                    setCredits(__('Chyba'));
                }
            })
            .catch(() => setCredits(__('Chyba')))
            .finally(() => setLoadingCredits(false));

    }, [isProcessingUI, status]);

    // Poll for meta updates when processing
    useEffect(() => {
        if (!isProcessingUI || isSaving || isAutosaving) return;

        const interval = setInterval(() => {
            apiFetch({
                path: 'tts/v1/refresh-meta',
                method: 'POST',
                data: { post_id: postId },
            }).then((response) => {
                if (response?.success) {
                    setMeta({ ...meta, ...response.data });

                    // Stop UI processing state immediately when backend says done
                    if (response.data._kptl_tts_status !== 3) {
                        setIsProcessingUI(false);
                    }
                }
            });
        }, POLLING_RATE);

        return () => clearInterval(interval);
    }, [isProcessingUI, isSaving, isAutosaving]);

    const setManualMedia = (newAudioID) => {
        if (!newAudioID || newAudioID === audioID) return;
        setMeta({
            ...meta,
            _kptl_tts_audio_id: newAudioID,
            _kptl_tts_status: 5
        });
    };

    const detachAudio = () => {
        setMeta({
            ...meta,
            _kptl_tts_audio_id: 0,
            _kptl_tts_status: 0,
        });
    };

    const handleRunTTS = async () => {
        if (!postId || isProcessingUI) return;

        // Immediate UI feedback
        setIsProcessingUI(true);

        try {
            await savePost();
            await apiFetch({
                path: '/tts/v1/start',
                method: 'POST',
                data: { post_id: postId },
            });
        } catch (error) {
            console.error('TTS error:', error);
            setIsProcessingUI(false);
        }
    };

    if (postType !== 'post') {
        return null;
    }

    return (
        <PluginDocumentSettingPanel
            name="kptl-tts-render-panel"
            title={__("Text to speech")}
            icon="microphone"
        >
            <Flex direction="column" gap={3} style={{ width: '100%' }}>
                <FlexItem>
                    <strong>{__("Status:")}</strong> {isProcessingUI ? STATUS_LABELS[3] : STATUS_LABELS[status]}
                </FlexItem>

                <FlexItem>
                    <strong>{__("Zostávajúci kredit:")}</strong>{' '}
                    {loadingCredits ? __('Načítavam...', 'kapital') : (credits ?? '—')}
                </FlexItem>

                <Button
                    style={{ flexGrow: 1, textAlign: 'center', display: 'inline-block' }}
                    variant="secondary"
                    onClick={handleRunTTS}
                    isBusy={isProcessingUI}
                    disabled={isProcessingUI}
                >
                    {isProcessingUI
                        ? __('Prebieha...', 'kapital')
                        : status === 4
                            ? __('Generovať znova', 'kapital')
                            : __('Generovať audio', 'kapital')
                    }
                </Button>

                {!isProcessingUI && (
                    <>
                        <FlexItem>
                            <strong>{__('Audio:', 'kapital')}</strong>
                        </FlexItem>
                        <FlexItem>
                            <Flex direction="row" gap="2" wrap={true}>
                                {audioID !== 0 && audioURL && (
                                    <audio style={{ width: "100%" }} controls src={audioURL}>
                                        {__('Váš prehliadač nepodporuje audio.', 'kapital')}
                                    </audio>
                                )}

                                <MediaUploadCheck>
                                    <MediaUpload
                                        onSelect={(newMedia) => setManualMedia(newMedia?.id)}
                                        allowedTypes={['audio']}
                                        value={audioID}
                                        render={({ open }) => (
                                            <Button
                                                style={{ flexGrow: 1, textAlign: 'center', display: 'inline-block' }}
                                                variant="secondary"
                                                onClick={open}
                                            >
                                                {audioID === 0
                                                    ? __('Manuálne nahrať', 'kapital')
                                                    : __('Nahradiť')
                                                }
                                            </Button>
                                        )}
                                    />
                                </MediaUploadCheck>

                                {audioID !== 0 && (
                                    <Button
                                        style={{ flexGrow: 1, textAlign: 'center', display: 'inline-block' }}
                                        variant="secondary"
                                        isDestructive={true}
                                        onClick={detachAudio}
                                    >
                                        {__('Odpojiť audio', 'kapital')}
                                    </Button>
                                )}
                            </Flex>
                        </FlexItem>
                    </>
                )}
            </Flex>
        </PluginDocumentSettingPanel>
    );
}