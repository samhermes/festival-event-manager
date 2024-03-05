const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const { resolve } = require( 'path' );

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		'slotfills': resolve(
			process.cwd(),
			'src/js/slotfills',
			'index.js'
		),
	}
};