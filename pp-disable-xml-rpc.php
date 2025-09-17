<?php
/**
 * A utility plugin to disable XML-RPC
 *
 * @package Progress_Planner_Disable_XMLRPC
 *
 * Plugin name:       Disable XML-RPC by Progress Planner
 * Plugin URI:        https://progressplanner.com
 * Description:       A utility plugin to disable XML-RPC.
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Version:           1.6.1
 * Author:            Team Emilia Projects
 * Author URI:        https://prpl.fyi/about
 * License:           MIT
 * License URI:       https://mit-license.org
 * Text Domain:       pp-disable-xml-rpc
 */

// Disable XML-RPC using the 'xmlrpc_enabled' filter.
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Die to prevent XMLRPC requests.
 */
function pp_disable_xml_rpc_die() {
	wp_die( 
		__( 'XML-RPC services are disabled on this site.', 'pp-disable-xml-rpc' ),
		__( 'XML-RPC Disabled', 'pp-disable-xml-rpc' ), 
		array( 'response' => 403 )
	);
}

// Add an empty class to bypass Core.
class pp_wp_xmlrpc_server {
	public function serve_request() {
		pp_disable_xml_rpc_die();
	}
}
add_filter( 'wp_xmlrpc_server_class', function() {
	return 'pp_wp_xmlrpc_server';
} );

// Bail early if XMLRPC_REQUEST is defined.
add_action( 'init', function() {
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		pp_disable_xml_rpc_die();
	}
} );