import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { ToggleControl } from '@wordpress/components';
import { useSelect, select } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { Flex } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { update } from '@wordpress/icons';


export function customMetaSettings() {
		registerPlugin( 'kapital-post-render-panel', {
			
			render: function(){
				const postType = useSelect(
					(select) => select('core/editor').getCurrentPostType(), []
				);
				const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
				let custom_render_meta = meta[ '_kapital_post_render_settings'];
				if (typeof meta[ '_kapital_post_render_settings'] === 'object' && !Array.isArray(meta[ '_kapital_post_render_settings']) && meta[ '_kapital_post_render_settings'] !== null){
					custom_render_meta = meta[ '_kapital_post_render_settings' ]

				} else {
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
					}
					//hide featured image in podcast by default
					if (postType === 'podcast'){
						custom_render_meta.show_featured_image = false;
					}
					if (postType === 'page'){
						custom_render_meta.show_featured_image = false;
						custom_render_meta.show_author = false;
						custom_render_meta.show_views = false;
						custom_render_meta.show_date = false;
						custom_render_meta.show_categories = false;
					}
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
						...custom_render_meta
					}
					custom_render_meta[ `${prop}` ] = value;
					setMeta({ ...meta, _kapital_post_render_settings: custom_render_meta });
				};
				return (
					<PluginDocumentSettingPanel
						name="kapital-post-render-panel"
						title="Nastavenie zobrazovania článku"
						className="some-css-class"
						icon="visibility"
					>
					<Flex
						direction={"column"}
						gap={4}>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať ilustračný obrázok', 'kapital')}
							  checked={ custom_render_meta.show_featured_image }
							  help={__('V archívoch článkov je ilustračný obrázok vždy viditeľný.', 'kapital')}
							  onChange={()=> updateMetaValue(!custom_render_meta.show_featured_image, 'show_featured_image')}
					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať breadcrumb navigáciu', 'kapital')}
							  checked={ custom_render_meta.show_breadcrumbs }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_breadcrumbs, 'show_breadcrumbs')}
					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať názov', 'kapital')}
							  checked={ custom_render_meta.show_title }
							  help={__('V archívoch článkov je názov vždy viditeľný.')}
							  onChange={()=> updateMetaValue(!custom_render_meta.show_title, 'show_title')}

					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať autora', 'kapital')}
							  checked={ custom_render_meta.show_author }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_author, 'show_author')}

					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať kategórie článku', 'kapital')}
							  checked={ custom_render_meta.show_categories }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_categories, 'show_categories')}
							  help={__('Zobrazenie čísla, série, rubriky, atď. nad názvom článku', 'kapital')}
					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať počet zhliadnutí', 'kapital')}
							  checked={ custom_render_meta.show_views }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_views, 'show_views')}

					/>	
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Zobrazovať dátum publikovania', 'kapital')}
							  checked={ custom_render_meta.show_date }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_date, 'show_date')}

					/>							
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Automaticky vložiť inzerciu', 'kapital')}
							  checked={ custom_render_meta.show_ads }
							  help={__('Netýka sa manuálne vložených blokov reklamy.', 'kapital')}s
							  onChange={()=> updateMetaValue(!custom_render_meta.show_ads, 'show_ads')}

					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Automaticky vložiť podporu', 'kapital')}
							  checked={ custom_render_meta.show_support }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_support, 'show_support')}
							  help={__('Netýka sa manuálne vložených blokov podpory.', 'kapital')}


					/>
					<ToggleControl
							  __nextHasNoMarginBottom
							  label={__('Automaticky vložiť odporúčania ďalších článkov', 'kapital')}
							  checked={ custom_render_meta.show_footer }
							  onChange={()=> updateMetaValue(!custom_render_meta.show_footer, 'show_footer')}
					/>
					</Flex>
					</PluginDocumentSettingPanel>
				)
				
			}
		} );
	};
	