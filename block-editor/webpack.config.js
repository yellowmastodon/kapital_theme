const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		'custom-editor-scripts/index': './block-editor/src/custom-editor-scripts/'
	},

};