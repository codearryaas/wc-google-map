/**
 * WordPress dependencies
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl, SelectControl } from '@wordpress/components'; 

import languages from './languages.js';

const Edit = ( props ) => {

	const {
		attributes: { address, height, zoom, language },
		setAttributes,
	} = props;

	const blockProps = useBlockProps();

	return (
		<div { ...blockProps } style={{ width: '100%'}}>
			<InspectorControls>
				<PanelBody title="Map Settings" initialOpen={ true }>
					<TextControl
						label="Address"
						value={ address }
						onChange={ ( value ) =>
							setAttributes( { address: value } )
						}
						__nextHasNoMarginBottom
					/>
					<TextControl
						label="Height"
						type='number'
						value={ height }
						onChange={ ( value ) =>
							setAttributes( { height: parseInt( value ) } )
						}
						__nextHasNoMarginBottom
					/>
					<TextControl
						label="Zoom"
						type='number'
						value={ zoom }
						onChange={ ( value ) =>
							setAttributes( { zoom: parseInt( value ) } )
						}
						__nextHasNoMarginBottom
					/>
					<SelectControl
						label={ __( 'Language' ) }
						value={ language }
						onChange={ ( value ) => setAttributes( { language: value } ) }
						options={ languages }
					/>
				</PanelBody>
			</InspectorControls>

			<iframe width="100%" height={height} src={`https://maps.google.com/maps?width=100%&height=600&hl=${language}&q=${encodeURIComponent( address )}&t=&z=${zoom}&ie=UTF8&iwloc=B&output=embed`}></iframe>

		</div>
	);
};
export default Edit;
