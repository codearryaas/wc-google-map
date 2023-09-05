/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Button, Notice, ToggleControl } from '@wordpress/components'; 
import domReady from '@wordpress/dom-ready';
import { createRoot, render, useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

/**
 * Internal dependencies.
 */
import './styles/main.scss';

const App = () => {
        const [ noticeData, setNoticeData] = useState({
                show: false,
                message: '',
        });
        const [ settings, setSettings] = useState({});
        const enableGoogleMapBlock = settings?.enableGoogleMapBlock && settings.enableGoogleMapBlock;

        useEffect( ()=>{
                apiFetch( { path: '/wc-google-map/v1/settings/' } ).then( ( response ) => {
                        setSettings( response );
                } );
        }, [] );

        const updateSettings = () => {
                apiFetch( { path: '/wc-google-map/v1/settings/', method: 'post', data : settings } ).then( ( response ) => {
                        setNoticeData({
                                show: true,
                                message: 'Settings has been saved.'
                        })
                } );
        }

        return <>
                <h1>Google Map Settings</h1>
               {noticeData?.show && noticeData.show && <Notice status="success" onRemove={()=>{
                        setNoticeData({
                                show: false,
                                message: ''
                        })
               }}>
                        {noticeData.message }
                </Notice>}

                <table className="form-table" role="presentation">
                        <tbody>
                                <tr>
                                        <th scope="row">
                                                <label>Enable Google Map Block </label>
                                        </th>
                                        <td>
                                                <ToggleControl checked={ !! enableGoogleMapBlock } onChange={()=>{
                                                        setSettings({
                                                                ...settings,
                                                                enableGoogleMapBlock: ! enableGoogleMapBlock,
                                                        });
                                                }}  />
                                        </td>
                                </tr>
                        </tbody>
                </table>
                <p className="submit">
                        <Button variant="primary" type="submit" onClick={()=>{
                                updateSettings( settings );
                        }}>Save Changes</Button>
                </p>
        </>
}

domReady( function() {
	const domElement = document.getElementById( `google-map-settings-app` );

	if ( createRoot ) {
		createRoot( domElement ).render( <App /> );
	} else {
		render( <App />, domElement );
	}
} );
