<?php
/**
 * Plugin Name: WooCommerce Example Package
 * Plugin URI: https://github.com/woocommerce/woocommerce-example-package
 * Description: Just an example package to be used as a feature plugin.
 * Author: Automattic
 * Author URI: https://github.com/woocommerce/woocommerce-example-package
 * Version: 1.0.0
 * Requires PHP: 5.6
 * License: GPLv3
 *
 * @package Automattic/WooCommerce/ExamplePackage
 * @internal This file is only used when running this package as a feature plugin.
 */

defined( 'ABSPATH' ) || exit;

if ( version_compare( PHP_VERSION, '5.6.0', '<' ) ) {
	return;
}

/**
 * Autoload packages.
 *
 * The package autoloader includes version information which prevents classes in this feature plugin
 * conflicting with WooCommerce core.
 *
 * We want to fail gracefully if `composer install` has not been executed yet, so we are checking for the autoloader.
 * If the autoloader is not present, let's log the failure and display a nice admin notice.
 */
$autoloader = __DIR__ . '/vendor/autoload_packages.php';
if ( is_readable( $autoloader ) ) {
	require $autoloader;
} else {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log(  // phpcs:ignore
			sprintf(
				/* translators: 1: composer command. 2: plugin directory */
				esc_html__( 'Your installation of the WooCommerce REST API feature plugin is incomplete. Please run %1$s within the %2$s directory.', 'woocommerce-example-package' ),
				'`composer install`',
				'`' . esc_html( str_replace( ABSPATH, '', __DIR__ ) ) . '`'
			)
		);
	}
	/**
	 * Outputs an admin notice if composer install has not been ran.
	 */
	add_action(
		'admin_notices',
		function() {
			?>
			<div class="notice notice-error">
				<p>
					<?php
					printf(
						/* translators: 1: composer command. 2: plugin directory */
						esc_html__( 'Your installation of the WooCommerce REST API feature plugin is incomplete. Please run %1$s within the %2$s directory.', 'woocommerce-example-package' ),
						'<code>composer install</code>',
						'<code>' . esc_html( str_replace( ABSPATH, '', __DIR__ ) ) . '</code>'
					);
					?>
				</p>
			</div>
			<?php
		}
	);
	return;
}

add_action( 'plugins_loaded', array( '\Automattic\WooCommerce\ExamplePackage\Package', 'init' ) );
