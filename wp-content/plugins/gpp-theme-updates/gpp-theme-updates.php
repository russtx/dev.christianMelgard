<?php
/*
Plugin Name: GPP Theme Updates
Description: Updates your Graph Paper Press themes automatically
Plugin URI: http://graphpaperpress.com/plugins/gpp-theme-updates/
Version: 2.0
License: GPL
Author: Graph Paper Press
Author URI: http://graphpaperpress.com
*/

add_filter( 'site_transient_update_themes', 'gpp_theme_updates_check' );

function gpp_theme_updates_check( $value ) {
	global $wp_version;	
	
	// get all the installed sites
	$installed_themes = wp_get_themes();
	
	$themes = array();
	$checked = array();	
		
	// filter GPP themes from all the installed themes and store it in an array 
	foreach ( $installed_themes as $theme ) {	
		$checked[ $theme->get_stylesheet() ] = $theme->get( 'Version' );
		if( $theme->get( 'Author' ) == "Graph Paper Press" ) {
			$themes[ $theme->get_stylesheet() ] = $theme->get( 'Version' );				
		}
	} 
	
	$options = array(
		'timeout' => 10,
		'body'			=> array( 'themes' => serialize( $themes ) ),
		'user-agent'	=> 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
	);
	
	// post the local data to the remote server to check the available updates
	$raw_response = wp_remote_post( 'http://demo.graphpaperpress.com/wp-content/api/', $options );	

	if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) )
		return false;	

	$response = maybe_unserialize( wp_remote_retrieve_body( $raw_response ) );	
	if(!is_object($value)){	
		$value = new stdClass;
	}
	if ( is_array( $response ) )
		$value->response = array_merge( (array)$value->response, $response );
	
	return $value; 
}	
?>