<?php
/**
 *
 *  Plugin to manage WordPress Auto Update Settings
 *
 * @link              https://github.com/chrispian/wp-auto-update-options
 * @since             1.0.0
 * @package           Auo_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Auto Update Options
 * Plugin URI:        https://github.com/chrispian/wp-auto-update-options
 * Description:       Adds options for Auto Updating WordPress Core, Plugins, Themes & Translations.
 * Version:           1.0.0
 * Author:            Chrispian H. Burks
 * Author URI:        http://www.chrispian.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       auo-plugin
 * Domain Path:       /languages
 *
 * Todo:
 *
 * - Make sure this plugin meets all WP standards, including for translations, etc.
 * - Make sure this works with Multi-Site, BuddyPress, WooCommerce, etc.
 * - Update for compatibility with Gutenberg
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die( 'Direct Access Not Permitted.' );

require_once 'auo-options.php';

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * Checks to make sure FTP credentials are found - do we even need this check?
 *
 * @return string
 */
function check_wp_config() {

	// One would probably be fine but all 3 MUST be present for this to work.
	if ( defined( 'FTP_HOST' ) && defined( 'FTP_USER' ) && defined( 'FTP_PASS' ) ) {
		return 'FOUND';
	} else {
		return 'NA';
	}
}

/**
 * Set return to tell WP to auto update plugins or not
 *
 * @param $item
 * @return bool
 */
function auo_update_plugins( $update, $item ) {

	$excluded_plugins = get_option( 'auo_plugin_option' );
	if ( in_array( $item->slug, $excluded_plugins, true ) ) {
		return false; // Never update a plugin in this array.
	} else {
		return true; // Otherwise, update it!
	}
}

/**
 * Set return to tell WP to auto update themes or not
 *
 * @param $item
 * @return bool
 */
function auo_update_themes( $update, $item ) {

	$excluded_themes = get_option( 'auo_theme_option' );
	if ( in_array( $item->slug, $excluded_themes, true ) ) {
		return false; // Never update a theme in this array.
	} else {
		return true; // Otherwise, update it!
	}
}

/**
 * Set return to tell WP to auto update translations or not
 *
 * @param $item
 * @return bool
 */
function auo_update_translations( $update, $item ) {

	$excluded_translations = get_option( 'auo_translation_option' );
	if ( in_array( $item->slug, $excluded_translations, true ) ) {
		return false; // Never update a theme in this array.
	} else {
		return true; // Otherwise, update it!
	}
}

// Grab some vars we'll need to decide what to do.
$wp_config_status         = check_wp_config();
$auo_update_plugin_status = get_option( 'auo_plugin_status' );
$aou_update_theme_status  = get_option( 'auo_plugin_status' );
$auo_core_status          = get_option( 'auo_core_status' );
$auo_core_option          = get_option( 'auo_core_option' );
$auo_translation_status   = get_option( 'auo_translation_status' );
$auo_translation_option   = get_option( 'auo_translation_option' );
$auo_email_status         = get_option( 'auo_email_status' );

// Run only if wp-config is properly configured and auto update plugin option is true.
if ( 'FOUND' === $wp_config_status && 'Yes' === $auo_update_plugin_status ) {
	add_filter( 'auto_update_plugin', 'auo_update_plugins', 10, 2 ); // Auto Updates plugins, excluding those in the array.
}

// Run only if wp-config is properly configured and auto update theme option is true.
if ( 'FOUND' === $wp_config_status && true === $aou_update_theme_status ) {
	add_filter( 'auto_update_theme', 'auo_update_themes', 10, 2 ); // Auto Updates plugins, excluding those in the array.
}

// Run only if wp-config is properly configured and auto update core option is true.
if ( 'FOUND' === $wp_config_status && true === $auo_core_status ) {

	if ( 'ALL' === $auo_core_option ) {
		add_filter( 'allow_dev_auto_core_updates', '__return_true' ); // Enable development, major & minor updates.
	}
	if ( 'Major' === $auo_core_option ) {
		add_filter( 'allow_minor_auto_core_updates', '__return_true' ); // Enable major & minor updates.
	}
	if ( 'Minor' === $auo_core_option ) {
		add_filter( 'allow_minor_auto_core_updates', '__return_true' ); // Enable minor updates.
	}
}

// Run only if wp-config is properly configured and auto update translations option is true.
if ( 'FOUND' === $wp_config_status && 'Yes' === $auo_translation_status ) {
	add_filter( 'auto_update_translation', 'auo_update_translations', 10, 2 ); // Auto Updates translations, excluding those in the array.
}

// Run only if wp-config is properly configured and send update emails option is true.
if ( 'FOUND' === $wp_config_status && 'Yes' === $auo_email_status ) {
	add_filter( 'auto_core_update_send_email', '__return_true' );
}
