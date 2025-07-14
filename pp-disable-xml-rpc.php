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

add_filter( 'xmlrpc_enabled', '__return_false' );
