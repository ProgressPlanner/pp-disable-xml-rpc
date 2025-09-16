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

/**
 * Send XML-RPC fault response.
 */
if ( ! function_exists( 'pp_send_xmlrpc_fault' ) ) {
	function pp_send_xmlrpc_fault() {
		header( 'Content-Type: text/xml; charset=UTF-8' );
		header( 'HTTP/1.1 405 Method Not Allowed' );

		$error_message = \esc_xml( __( 'XML-RPC services are disabled on this site.', 'pp-disable-xml-rpc' ) );

		echo <<<XML
	<?xml version="1.0" encoding="UTF-8"?>
	<methodResponse>
	<fault>
		<value>
		<struct>
			<member>
			<name>faultCode</name>
			<value><int>405</int></value>
			</member>
			<member>
			<name>faultString</name>
			<value><string>{$error_message}</string></value>
			</member>
		</struct>
		</value>
	</fault>
	</methodResponse>
	XML;
		exit;
	}
}

// Disable XML-RPC using the 'xmlrpc_enabled' filter.
add_filter( 'xmlrpc_enabled', '__return_false' );

// Add an empty class to bypass Core.
class pp_wp_xmlrpc_server {
	public function serve_request() {
		pp_send_xmlrpc_fault();
	}
}
add_filter( 'wp_xmlrpc_server_class', function() {
  return 'pp_wp_xmlrpc_server';
} );

// Bail early if XMLRPC_REQUEST is defined.
add_action( 'init', function() {
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		pp_send_xmlrpc_fault();
	}
} );