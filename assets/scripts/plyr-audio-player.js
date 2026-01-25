//init plyr audio player, dependency injection handled by includes/tts/class-tts-loader.php

const plyrAudio = document.querySelectorAll('.plyr-audio');
let plyrAudioPlayers = [];

const player_i18n = {
    en:
    {
        restart: 'Restart',
        rewind: 'Rewind {seektime} secs',
        play: 'Play',
        pause: 'Pause',
        fastForward: 'Forward {seektime} secs',
        seek: 'Seek',
        played: 'Played',
        buffered: 'Buffered',
        currentTime: 'Current time',
        duration: 'Duration',
        volume: 'Volume',
        mute: 'Mute',
        unmute: 'Unmute',
        enableCaptions: 'Enable captions',
        disableCaptions: 'Disable captions',
        enterFullscreen: 'Enter fullscreen',
        exitFullscreen: 'Exit fullscreen',
        frameTitle: 'Player for {title}',
        captions: 'Captions',
        settings: 'Settings',
        speed: 'Speed',
        normal: 'Normal',
        quality: 'Quality',
        loop: 'Loop',
        start: 'Start',
        end: 'End',
        all: 'All',
        reset: 'Reset',
        disabled: 'Disabled',
        advertisement: 'Ad',
    },
    sk: {
        restart: 'Reštart',
        rewind: 'Späť o {seektime}s',
        play: 'Prehrať',
        pause: 'Pozastaviť',
        fastForward: 'Dopredu o {seektime}s',
        seek: 'Posun',
        played: 'Prehrané',
        buffered: 'Načítané',
        currentTime: 'Aktuálny čas',
        duration: 'Trvanie',
        volume: 'Hlasitosť',
        mute: 'Stlmiť',
        unmute: 'Zapnúť zvuk',
        enableCaptions: 'Zapnúť titulky',
        disableCaptions: 'Vypnúť titulky',
        enterFullscreen: 'Celá obrazovka',
        exitFullscreen: 'Ukončiť celú obrazovku',
        frameTitle: 'Prehrávač pre {title}',
        captions: 'Titulky',
        settings: 'Nastavenia',
        speed: 'Rýchlosť',
        normal: 'Normálna',
        quality: 'Kvalita',
        loop: 'Opakovanie',
        start: 'Začiatok',
        end: 'Koniec',
        all: 'Všetko',
        reset: 'Obnoviť',
        disabled: 'Vypnuté',
        advertisement: 'Reklama',
    }
}

if (plyrAudio.length > 0) {
    plyrAudio.forEach((element) => {
        const lang = element.getAttribute('data-lang');

        plyrAudioPlayers.push(new Plyr(element,
            {
                controls: `
                <div class="plyr__controls">
                        <button type="button" class="plyr__control plyr__controls__item plyr__rewind" data-plyr="rewind" aria-label="${player_i18n[lang].rewind}">
                            <svg role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 24"><path d="M14.83,0c-3.05,0-5.96,1.11-8.2,3.13-1.65,1.48-2.83,3.33-3.46,5.41l-1.32-1.98c-.31-.46-.92-.59-1.39-.28-.23.15-.38.37-.44.63-.05.26,0,.53.15.76l2.76,4.14c.16.24.41.4.69.44.28.04.57-.03.8-.2l3.99-3.01c.22-.16.35-.4.39-.66.04-.27-.03-.53-.2-.75-.33-.43-.97-.52-1.41-.19l-2.06,1.56c1.29-4.13,5.17-7,9.69-7,5.6,0,10.16,4.48,10.16,10s-4.56,10-10.16,10c-3.33,0-6.45-1.61-8.36-4.32-.32-.45-.95-.56-1.4-.25-.45.31-.57.94-.25,1.39,2.28,3.24,6.02,5.17,10.01,5.17,6.71,0,12.17-5.38,12.17-12S21.54,0,14.83,0Z"/><path d="M12.62,8.15v7.85h-1.29v-6.31l-1.92.65v-1.07l3.06-1.12h.16ZM20.44,11.43v1.28c0,.61-.06,1.14-.18,1.57-.12.43-.29.78-.52,1.05-.23.27-.5.47-.81.59-.31.13-.66.19-1.05.19-.31,0-.59-.04-.86-.12-.26-.08-.5-.2-.71-.37-.21-.17-.39-.39-.54-.65-.15-.27-.26-.59-.34-.96-.08-.37-.12-.8-.12-1.29v-1.28c0-.62.06-1.14.18-1.56.12-.43.3-.77.52-1.04.23-.27.49-.46.81-.59.32-.12.67-.18,1.05-.18.31,0,.6.04.86.12.27.08.5.2.71.36.21.16.39.38.54.64.15.26.26.58.34.95.08.37.12.8.12,1.29ZM19.15,12.9v-1.65c0-.31-.02-.59-.05-.82-.04-.24-.09-.44-.16-.61-.07-.17-.15-.3-.26-.41-.1-.11-.22-.18-.35-.23-.13-.05-.28-.08-.45-.08-.2,0-.38.04-.54.12-.16.08-.29.2-.4.37-.11.17-.19.39-.25.67-.05.27-.08.6-.08.99v1.65c0,.32.02.59.05.83.04.24.09.45.16.62.07.17.16.31.26.42.1.11.22.19.35.24.14.05.28.08.45.08.2,0,.38-.04.54-.12.16-.08.29-.2.4-.38.11-.18.19-.4.24-.68.05-.28.08-.61.08-1Z"/></svg>
                            <span class="plyr__tooltip" role="tooltip">${player_i18n[lang].rewind}</span>
                        </button>
                        <button type="button" class="plyr__control plyr__controls__item" aria-label="${player_i18n[lang].play}" data-plyr="play">
                            <svg class="icon--not-pressed" role="presentation" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7.46,3.25c-.73-.46-1.68.06-1.68.92v15.66c0,.86.95,1.38,1.68.92l12.31-7.83c.67-.43.67-1.41,0-1.84L7.46,3.25Z"/></svg>
                            <svg class="icon--pressed" "role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><rect x="13.91" y="3.65" width="4.82" height="16.69" rx="1.39" ry="1.39"/><rect x="5.28" y="3.65" width="4.82" height="16.69" rx="1.39" ry="1.39"/></svg>
                            <span class="label--pressed plyr__tooltip" role="tooltip">${player_i18n[lang].pause}</span>
                            <span class="label--not-pressed plyr__tooltip" role="tooltip">${player_i18n[lang].play}</span>
                        </button>
                        <button type="button" class="plyr__controls__item plyr__control plyr__fast-forward" data-plyr="fast-forward" aria-label="${player_i18n[lang].fastForward}">
                            <svg role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 24" fill="currentColor"><path d="M26.98,6.91c-.05-.26-.21-.49-.44-.63-.47-.31-1.08-.18-1.39.28l-1.32,1.98c-.63-2.08-1.82-3.93-3.46-5.41C18.13,1.11,15.22,0,12.18,0,5.46,0,0,5.38,0,12s5.46,12,12.17,12c3.99,0,7.73-1.93,10.01-5.17.31-.45.2-1.08-.26-1.39-.45-.31-1.07-.2-1.4.25-1.9,2.7-5.02,4.31-8.36,4.31-5.6,0-10.16-4.49-10.16-10S6.57,2,12.18,2c4.52,0,8.4,2.87,9.69,7l-2.06-1.56c-.44-.33-1.07-.25-1.41.19-.17.21-.24.48-.2.75.04.27.18.5.39.66l3.99,3.01c.23.17.52.24.8.2.28-.05.54-.21.69-.44l2.76-4.14c.15-.23.2-.5.15-.76Z"/><path d="M9.62,8.15v7.85h-1.29v-6.31l-1.92.65v-1.07l3.06-1.12h.16ZM17.44,11.43v1.28c0,.61-.06,1.14-.18,1.57-.12.43-.29.78-.52,1.05-.23.27-.5.47-.81.59-.31.13-.66.19-1.05.19-.31,0-.59-.04-.86-.12-.26-.08-.5-.2-.71-.37-.21-.17-.39-.39-.54-.65-.15-.27-.26-.59-.34-.96-.08-.37-.12-.8-.12-1.29v-1.28c0-.62.06-1.14.18-1.56.12-.43.3-.77.52-1.04.23-.27.49-.46.81-.59.32-.12.67-.18,1.05-.18.31,0,.6.04.86.12.26.08.5.2.71.36.21.16.39.38.54.64.15.26.26.58.34.95.08.37.12.8.12,1.29ZM16.15,12.9v-1.65c0-.31-.02-.59-.05-.82-.04-.24-.09-.44-.16-.61-.07-.17-.15-.3-.26-.41-.1-.11-.22-.18-.35-.23-.13-.05-.28-.08-.45-.08-.2,0-.38.04-.54.12-.16.08-.29.2-.4.37-.11.17-.19.39-.25.67-.05.27-.08.6-.08.99v1.65c0,.32.02.59.05.83.04.24.09.45.16.62.07.17.16.31.26.42.1.11.22.19.35.24.14.05.28.08.45.08.2,0,.38-.04.54-.12.16-.08.29-.2.4-.38.11-.18.19-.4.24-.68.05-.28.08-.61.08-1Z"/></svg>
                            <span class="plyr__tooltip" role="tooltip">${player_i18n[lang].fastForward}</span>
                        </button>
                        <div class="plyr__time plyr__time--current plyr__controls__item" aria-label="${player_i18n[lang].currentTime}">00:00</div>
                        <div class="plyr__controls__item plyr__progress__container plyr__controls__item ">
                            <div class="plyr__progress">
                                <input data-plyr="seek" type="range" min="0" max="100" step="0.01" value="0" aria-label="aria-label="${player_i18n[lang].seek}">
                                <progress class="plyr__progress__buffer" min="0" max="100" value="0">% buffered</progress>
                                <span role="tooltip" class="plyr__tooltip">00:00</span>
                            </div>
                        </div>
                        <div class="plyr__time plyr__time--duration plyr__controls__item" aria-label="Duration">00:00</div>
                        <button type="button" class="plyr__control plyr__mute plyr__controls__item" aria-label="${player_i18n[lang].play}" data-plyr="mute">
                            <svg class="icon--not-pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="3.75 9.25 3.75 14.75 7.42 14.75 12 19.33 12 4.67 7.42 9.25 3.75 9.25"/><path d="M16.12,12c0-1.62-.94-3.02-2.29-3.69v7.38c1.36-.67,2.29-2.06,2.29-3.68Z"/><path d="M13.83,3.96v1.89c2.65.79,4.58,3.24,4.58,6.15s-1.93,5.36-4.58,6.15v1.89c3.68-.83,6.42-4.12,6.42-8.04s-2.74-7.21-6.42-8.04Z"/></svg>
                            <svg class="icon--pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="3.75 9.25 3.75 14.75 7.42 14.75 12 19.33 12 4.67 7.42 9.25 3.75 9.25"/><polygon points="20.26 10.2 19.06 9 16.92 11.13 14.79 9 13.59 10.2 15.72 12.34 13.59 14.47 14.79 15.67 16.92 13.54 19.06 15.67 20.26 14.47 18.12 12.34 20.26 10.2"/></svg>
                            <span class="label--pressed plyr__tooltip" role="tooltip">${player_i18n[lang].unmute}</span>
                            <span class="label--not-pressed plyr__tooltip" role="tooltip">${player_i18n[lang].mute}</span>
                        </button>
                        <div class="plyr__volume plyr__controls__item">
                            <input data-plyr="volume" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" aria-label="${player_i18n[lang].volume}">
                        </div>

                </div>
                `,
                i18n: player_i18n[lang]
            }
        )); // push() instead of plyrAudioPlayers[]
    });
}