<?php
/**
 * Minimal bootstrap regression checks; run each scenario in a separate process.
 *
 * @package Progress_Planner_Disable_XMLRPC
 */

// CLI-only fixture: WordPress filesystem and escaping helpers are unavailable.
// phpcs:disable WordPress.WP.AlternativeFunctions.file_system_operations_fwrite

$scenario = isset( $argv[1] ) ? $argv[1] : '';
if ( ! in_array( $scenario, array( 'direct', 'xmlrpc', 'normal', 'false' ), true ) ) {
	fwrite( STDERR, "Expected scenario: direct, xmlrpc, normal, or false.\n" );
	exit( 1 );
}

$completed = false;
$filters   = array();

// Turn PHP notices and warnings into failures, including direct-access errors.
// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_set_error_handler -- Fail on warnings in the test process.
set_error_handler(
	function ( $severity, $message ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- CLI exception, not HTML output.
		throw new ErrorException( $message, 0, $severity );
	}
);

register_shutdown_function(
	function () use ( $scenario, &$completed, &$filters ) {
		$blocked = in_array( $scenario, array( 'direct', 'xmlrpc' ), true );
		$output  = ob_get_clean();
		$valid   = null === error_get_last() && ( $blocked ? ! $completed : $completed );
		$valid   = $valid && '' === $output;
		$valid   = $valid && http_response_code() === ( 'xmlrpc' === $scenario ? 403 : 200 );
		$valid   = $valid && ( $blocked ? array() : array( 'xmlrpc_enabled' => '__return_false' ) ) === $filters;
		fwrite( $valid ? STDOUT : STDERR, ( $valid ? 'PASS: ' : 'FAIL: ' ) . $scenario . "\n" );
		exit( $valid ? 0 : 1 );
	}
);

/**
 * Record filter registration without bootstrapping WordPress.
 *
 * @param string $hook     Filter name.
 * @param string $callback Callback name.
 */
function add_filter( $hook, $callback ) {
	$GLOBALS['filters'][ $hook ] = $callback;
}

/**
 * Set a response code without bootstrapping WordPress.
 *
 * @param int $status HTTP response code.
 */
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
