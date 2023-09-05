/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import moment from 'moment';
import { getQueryArg } from '@wordpress/url';

const Save = ( props ) => {
	const {
		attributes: { address, height, zoom, language },
	} = props;
	const blockProps = useBlockProps.save();
	return <div { ...blockProps }>
		<iframe width="100%" height={height} src={`https://maps.google.com/maps?width=100%&height=600&hl=${language}&q=${encodeURIComponent( address )}&t=&z=${zoom}&ie=UTF8&iwloc=B&output=embed`}></iframe>	
	</div>;
};
export default Save;
