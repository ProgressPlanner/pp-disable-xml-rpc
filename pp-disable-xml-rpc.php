<?php
/**
 * A utility plugin to disable XML-RPC
 *
 * @package Progress_Planner_Disable_XMLRPC
 *
 * Plugin name:       Disable XML-RPC by Progress Planner
 * Plugin URI:        https://progressplanner.com
 * Description:       Disable WordPress XML-RPC completely with a lightweight, no-settings hardening plugin.
 * Requires at least: 6.7
 * Tested up to:      7.1
 * Requires PHP:      7.4
 * Version:           1.6.1
 * Author:            Team Emilia Projects
 * Author URI:        https://prpl.fyi/about
 * License:           MIT
 * License URI:       https://mit-license.org
 * Text Domain:       pp-disable-xml-rpc
 */

defined( 'ABSPATH' ) || exit;

// Stop XML-RPC during plugin loading, before the remaining WordPress bootstrap.
// The XML-RPC wp_die() handler cannot send this response before its server exists.
if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
	status_header( 403 );
	exit;
}

// Disable XML-RPC using the 'xmlrpc_enabled' filter.
add_filter( 'xmlrpc_enabled', '__return_false' );
