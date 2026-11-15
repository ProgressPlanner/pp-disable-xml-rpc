<?php
/** Minimal bootstrap regression checks; run each scenario in a separate process. */

$scenario = isset( $argv[1] ) ? $argv[1] : '';
if ( ! in_array( $scenario, array( 'direct', 'xmlrpc', 'normal', 'false' ), true ) ) {
	fwrite( STDERR, "Expected scenario: direct, xmlrpc, normal, or false.\n" );
	exit( 1 );
}

$completed = false;
$filters   = array();

// Turn PHP notices and warnings into failures, including direct-access errors.
set_error_handler( function ( $severity, $message ) {
	throw new ErrorException( $message, 0, $severity );
} );

register_shutdown_function( function () use ( $scenario, &$completed, &$filters ) {
	$blocked = in_array( $scenario, array( 'direct', 'xmlrpc' ), true );
	$valid   = null === error_get_last() && $completed === ! $blocked;
	$valid   = $valid && '' === ob_get_clean();
	$valid   = $valid && http_response_code() === ( 'xmlrpc' === $scenario ? 403 : 200 );
	$valid   = $valid && $filters === ( $blocked ? array() : array( 'xmlrpc_enabled' => '__return_false' ) );
	fwrite( $valid ? STDOUT : STDERR, ( $valid ? 'PASS: ' : 'FAIL: ' ) . $scenario . "\n" );
	exit( $valid ? 0 : 1 );
} );

function add_filter( $hook, $callback ) {
	$GLOBALS['filters'][ $hook ] = $callback;
}

function status_header( $status ) {
	http_response_code( $status );
}

http_response_code( 200 );
ob_start();
if ( 'direct' !== $scenario ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
if ( in_array( $scenario, array( 'xmlrpc', 'false' ), true ) ) {
	define( 'XMLRPC_REQUEST', 'xmlrpc' === $scenario );
}

require dirname( __DIR__ ) . '/pp-disable-xml-rpc.php';
$completed = true;
