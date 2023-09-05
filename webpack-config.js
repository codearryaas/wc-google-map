const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const baseDIR = process.cwd();

module.exports = ( ) => {
	return {
		...defaultConfig,

		entry: {
			'admin/settings/index': path.resolve( baseDIR, 'src/admin/settings/index.js' ),
		},

		output: {
			filename: '[name].js',
			path: path.resolve( baseDIR, 'dist/' ),
		} };
};
