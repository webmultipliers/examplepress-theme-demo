<?php
/**
 * Plugin Name: ExamplePress Demo
 * Description: Disposable demo companion plugin showing the routing contract, namespace handoff, and template block pattern. Install via the ExamplePress settings page, inspect the source, then scaffold your own.
 * Version: 1.0.2
 * Requires at least: 6.9
 * Requires PHP: 8.4
 * Author: ExamplePress
 * Theme: examplepress-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use ExamplePress\MU\Infrastructure\RouteRegistry;

// ── Route Origin Registration ────────────────────────────────────
// Register which routes this plugin handles and under what namespace.
// Multiple companion plugins can coexist — each declares only the
// routes it owns. The router evaluates conditions and picks the first
// matching origin per request.

if ( class_exists( RouteRegistry::class ) ) {
	$__ep_config   = json_decode( file_get_contents( __DIR__ . '/examplepress.json' ), true ) ?: [];
	$__ep_priority = (int) ( $__ep_config['routing']['priority'] ?? 10 );

	RouteRegistry::register( 'examplepress-demo', [
		'front'  => fn() => is_front_page() || is_home(),
		'single' => fn() => is_singular(),
		'404'    => fn() => is_404(),
	], $__ep_priority );

	unset( $__ep_config, $__ep_priority );
}

// ── Route Data Enrichment ─────────────────────────────────────────

add_filter( 'examplepress_route_data', function ( $data, $slug, $block_name ) {
	$data['demo'] = true;

	if ( in_array( $slug, [ 'single' ], true ) ) {
		$data['post'] = get_queried_object();
	}

	return $data;
}, 10, 3 );

// ── Blockstudio Init ──────────────────────────────────────────────

add_action( 'init', function () {
	if ( ! class_exists( 'Blockstudio\\Build' ) ) {
		return;
	}

	Blockstudio\Build::init( [
		'dir' => plugin_dir_path( __FILE__ ) . 'app',
	] );
} );
