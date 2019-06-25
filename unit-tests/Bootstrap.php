<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Automattic/WooCommerce/ExamplePackage
 */
namespace Automattic\WooCommerce\ExamplePackage\UnitTests;

class Bootstrap {
	/**
	 * Directory path to WP core tests.
	 *
	 * @var string
	 */
	protected static $wp_tests_dir;

	/**
	 * Tests directory.
	 *
	 * @var string
	 */
	protected static $tests_dir;

	/**
	 * WC Core unit tests directory.
	 *
	 * @var string
	 */
	protected static $wc_tests_dir;

	/**
	 * This plugin directory.
	 *
	 * @var string
	 */
	protected static $plugin_dir;

	/**
	 * Plugins directory.
	 *
	 * @var string
	 */
	protected static $plugins_dir;

	/**
	 * Init unit testing library.
	 */
	public static function init() {
		self::$wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
		self::$tests_dir    = __DIR__;
		self::$plugin_dir   = dirname( self::$tests_dir );

		if ( file_exists( dirname( self::$plugin_dir ) . '/woocommerce/woocommerce.php' ) ) {
			// From plugin directory.
			self::$plugins_dir = dirname( self::$plugin_dir );
		} else {
			// Travis.
			self::$plugins_dir = getenv( 'WP_CORE_DIR' ) . '/wp-content/plugins';
		}

		self::$wc_tests_dir = self::$plugins_dir . '/woocommerce/tests';

		self::setup_hooks();
		self::load_framework();
	}

	/**
	 * Setup hooks.
	 */
	protected static function setup_hooks() {
		// Give access to tests_add_filter() function.
		require_once self::$wp_tests_dir . '/includes/functions.php';

		\tests_add_filter( 'muplugins_loaded', function() {
			require_once self::$plugins_dir . '/woocommerce/woocommerce.php';
			require_once self::$plugin_dir . '/woocommerce-example-package.php';
		} );

		\tests_add_filter( 'setup_theme', function() {
			echo \esc_html( 'Installing WooCommerce...' . PHP_EOL );

			define( 'WP_UNINSTALL_PLUGIN', true );
			define( 'WC_REMOVE_ALL_DATA', true );
			include self::$plugins_dir . '/woocommerce/uninstall.php';

			\WC_Install::install();

			$GLOBALS['wp_roles'] = null; // WPCS: override ok.
			\wp_roles();
		} );
	}

	/**
	 * Load the testing framework.
	 */
	protected static function load_framework() {
		// Start up the WP testing environment.
		require_once self::$wp_tests_dir . '/includes/bootstrap.php';

		// WooCommerce Core Testing Framework.
		require_once self::$wc_tests_dir . '/framework/class-wc-unit-test-factory.php';
		require_once self::$wc_tests_dir . '/framework/vendor/class-wp-test-spy-rest-server.php';
		require_once self::$wc_tests_dir . '/includes/wp-http-testcase.php';
		require_once self::$wc_tests_dir . '/framework/class-wc-unit-test-case.php';
		require_once self::$wc_tests_dir . '/framework/class-wc-rest-unit-test-case.php';
	}
}

Bootstrap::init();
