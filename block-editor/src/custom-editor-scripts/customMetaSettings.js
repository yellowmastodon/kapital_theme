import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { ToggleControl } from '@wordpress/components';
import { useSelect, select } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { Flex } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { update } from '@wordpress/icons';


export function customMetaSettings() {

	registerPlugin('kapital-post-render-panel', {

		render: function () {
			const postType = useSelect(
				(select) => select('core/editor').getCurrentPostType(), []
			);
			let postTypes;
			if (typeof postTypesWithControlledRendering !== 'undefined') {
				postTypes = postTypesWithControlledRendering;
			} else {
				postTypes = [];
			}


			if (postTypes.includes(postType)) {

				const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
				let custom_render_meta = meta['_kapital_post_render_settings'];
				let default_render_meta = {
					show_featured_image: true,
					show_breadcrumbs: true,
					show_title: true,
					show_author: true,
					show_categories: true,
					show_views: true,
					show_date: true,
					show_ads: true,
					show_support: true,
					show_footer: true,
					show_filters: false,
					show_footer_newsletter: true,
					show_share_button: true,
					show_event_location: false,
				};
				let postRecommendationLabel;
				if (postType === 'podcast'){
					postRecommendationLabel = __('Automaticky vložiť odporúčania ďalších podcastov', 'kapital');
				} else if (postType === 'event'){
					postRecommendationLabel = __('Automaticky vložiť odporúčania ďalších eventov', 'kapital');
				} else {
					postRecommendationLabel = __('Automaticky vložiť odporúčania ďalších článkov', 'kapital');
				}

				//hide featured image in podcast by default
				if (postType === 'podcast') {
					default_render_meta.show_featured_image = false;
					default_render_meta.show_author = false;
				}
				if (postType === 'page') {
					default_render_meta.show_featured_image = false;
					default_render_meta.show_author = false;
					default_render_meta.show_views = false;
					default_render_meta.show_date = false;
					default_render_meta.show_categories = false;
					default_render_meta.show_share_button = false;
				}
				if (postType === 'event'){
					default_render_meta.show_ads = false;
					default_render_meta.show_event_location = true;
				}

				if (typeof meta['_kapital_post_render_settings'] === 'object' && !Array.isArray(meta['_kapital_post_render_settings']) && meta['_kapital_post_render_settings'] !== null) {
					custom_render_meta = { ...default_render_meta, ...custom_render_meta };
				} else {
					custom_render_meta = default_render_meta;
				}

				const updateMetaValue = (value, prop) => {
					custom_render_meta = {
						show_featured_image: true,
						show_breadcrumbs: true,
						show_title: true,
						show_author: true,
						show_categories: true,
						show_views: true,
						show_date: true,
						show_ads: true,
						show_support: true,
						show_footer: true,
						show_footer_newsletter: true,
						show_share_button: true,
						show_event_location: false,
						...custom_render_meta
					}
					custom_render_meta[`${prop}`] = value;
					setMeta({ ...meta, _kapital_post_render_settings: custom_render_meta });
				};
				return (
					<PluginDocumentSettingPanel
						name="kapital-post-render-panel"
						title="Nastavenie zobrazovania"
						className="some-css-class"
						icon="visibility"
					>
						<Flex
							direction={"column"}
							gap={4}>
							{postType === 'page' &&
								<ToggleControl
									__nextHasNoMarginBottom
									label={__('Zobrazovať filtre', 'kapital')}
									checked={custom_render_meta.show_filters}
									help={__('Pri stránkach sa ako filtre zobrazia dcérske stránky.', 'kapital')}
									onChange={() => updateMetaValue(!custom_render_meta.show_filters, 'show_filters')}
								/>
							}
							<ToggleControl
								__nextHasNoMarginBottom
								label={__('Zobrazovať ilustračný obrázok', 'kapital')}
								checked={custom_render_meta.show_featured_image}
								help={__('V archívoch článkov je ilustračný obrázok vždy viditeľný.', 'kapital')}
								onChange={() => updateMetaValue(!custom_render_meta.show_featured_image, 'show_featured_image')}
							/>
							<ToggleControl
								__nextHasNoMarginBottom
								label={__('Zobrazovať breadcrumb navigáciu', 'kapital')}
								checked={custom_render_meta.show_breadcrumbs}
								onChange={() => updateMetaValue(!custom_render_meta.show_breadcrumbs, 'show_breadcrumbs')}
							/>
							<ToggleControl
								__nextHasNoMarginBottom
								label={__('Zobrazovať názov', 'kapital')}
								checked={custom_render_meta.show_title}
								help={__('V archívoch článkov je názov vždy viditeľný.')}
								onChange={() => updateMetaValue(!custom_render_meta.show_title, 'show_title')}

							/>
							{(postType !== 'page' && postType !== 'podcast' && postType !== 'event') &&
								<ToggleControl
									__nextHasNoMarginBottom
									label={__('Zobrazovať autorstvo', 'kapital')}
									checked={custom_render_meta.show_author}
									onChange={() => updateMetaValue(!custom_render_meta.show_author, 'show_author')}
								/>
							}
							{(postType !== 'page' && postType !== 'event') &&
									<ToggleControl
										__nextHasNoMarginBottom
										label={__('Zobrazovať kategórie článku', 'kapital')}
										checked={custom_render_meta.show_categories}
										onChange={() => updateMetaValue(!custom_render_meta.show_categories, 'show_categories')}
										help={__('Zobrazenie čísla, série, rubriky, atď. nad názvom článku', 'kapital')}
									/>
							}
							<ToggleControl
								__nextHasNoMarginBottom
								label={__('Zobraziť tlačidlo "Zdieľať"', 'kapital')}
								checked={custom_render_meta.show_share_button}
								onChange={() => updateMetaValue(!custom_render_meta.show_share_button, 'show_share_button')}
							/>
							<ToggleControl
								__nextHasNoMarginBottom
								label={__('Zobrazovať počet zhliadnutí', 'kapital')}
								checked={custom_render_meta.show_views}
								onChange={() => updateMetaValue(!custom_render_meta.show_views, 'show_views')}

							/>
							<ToggleControl
								__nextHasNoMarginBottom
								label={postType === 'event' ? __('Zobrazovať dátum podujatia', 'kapital') : __('Zobrazovať dátum publikovania', 'kapital')}
								checked={custom_render_meta.show_date}
								onChange={() => updateMetaValue(!custom_render_meta.show_date, 'show_date')}

							/>
							{postType !== 'page' &&
								<>
									<ToggleControl
										__nextHasNoMarginBottom
										label={__('Automaticky vložiť podporu', 'kapital')}
										checked={custom_render_meta.show_support}
										onChange={() => updateMetaValue(!custom_render_meta.show_support, 'show_support')}
										help={__('Netýka sa manuálne vložených blokov podpory.', 'kapital')}
									/>
									<ToggleControl
										__nextHasNoMarginBottom
										label={__('Automaticky vložiť inzerciu', 'kapital')}
										checked={custom_render_meta.show_ads}
										help={__('Netýka sa manuálne vložených blokov reklamy.', 'kapital')} s
										onChange={() => updateMetaValue(!custom_render_meta.show_ads, 'show_ads')}

									/>
									<ToggleControl
										__nextHasNoMarginBottom
										label={ postRecommendationLabel }
										checked={custom_render_meta.show_footer}
										onChange={() => updateMetaValue(!custom_render_meta.show_footer, 'show_footer')}
									/>
								</>
							}

							<ToggleControl
								__nextHasNoMarginBottom
								label={__('Zobraziť prihlasovanie do newsletteru v päte', 'kapital')}
								checked={custom_render_meta.show_footer_newsletter}
								onChange={() => updateMetaValue(!custom_render_meta.show_footer_newsletter, 'show_footer_newsletter')}
							/>
						</Flex>
					</PluginDocumentSettingPanel>
				)
			} else {
				return;
			}
		}
	});
};
