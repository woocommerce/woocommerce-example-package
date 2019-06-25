<?php
/**
 * Returns information about the package and handles init.
 *
 * @package Automattic/WooCommerce/ExamplePackage
 */

namespace Automattic\WooCommerce\ExamplePackage;

defined( 'ABSPATH' ) || exit;

/**
 * Main package class.
 */
class Package {

	/**
	 * Version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Init the package.
	 */
	public static function init() {
		\Automattic\WooCommerce\ExamplePackage\ExampleClass::init();
	}

	/**
	 * Return the version of the package.
	 *
	 * @return string
	 */
	public static function get_version() {
		return self::VERSION;
	}

	/**
	 * Return the path to the package.
	 *
	 * @return string
	 */
	public static function get_path() {
		return dirname( __DIR__ );
	}
}
