<?php
/**
 *
 *  Plugin to manage WordPress Auto Update Settings
 *
 * @link              http://www.chrispian.com
 * @since             1.0.0
 * @package           Ausm_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Auto Update Settings Manager
 * Plugin URI:        http://www.chrispian.com
 * Description:       Adds options for Auto Updating WordPress Core, Plugins, Themes & Translations.
 * Version:           2.0.3
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
 */

namespace CHB_Auto_Update_Settings_Manager;

require_once ( dirname(__FILE__) . '/vendor/autoload.php' );

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die( 'Direct Access Not Permitted.' );

/**
 * Main initiation class
 *
 * @since  2.0.0
 * @var  string $version  Plugin version
 * @var  string $basename Plugin basename
 * @var  string $url      Plugin URL
 * @var  string $path     Plugin Path
 */
class CHB_Auto_Update_Settings_Manager {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  2.0.0
	 */
	const VERSION = '2.0.3';

	/**
	 * URL of plugin directory
	 *
	 * @var string
	 * @since  2.0.0
	 */
	protected $url = '';

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  2.0.0
	 */
	protected $path = '';

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  2.0.0
	 */
	protected $basename = '';

	/**
	 * Options instance.
	 * @var string
	 */
	protected $options = '';

	/**
	 * Helpers instance.
	 * @var string
	 */
	protected $helpers = '';

	/**
	 * Core instance.
	 * @var string
	 */
	protected $core = '';

	/**
	 * Singleton instance of plugin
	 *
	 * @var CHB_Auto_Update_Settings_Manager
	 * @since  2.0.0
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  2.0.0
	 * @return CHB_Auto_Update_Settings_Manager A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin
	 *
	 * @since  2.0.0
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );

		$this->plugin_classes();
		$this->hooks();
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since 2.0.0
	 * @return  null
	 */
	public function plugin_classes() {
		$this->options = new Options( $this ) ;
		$this->helpers = new Helpers( $this );
		$this->core    = new Core( $this );
	}

	/**
	 * Add hooks and filters
	 *
	 * @since 2.0.0
	 * @return null
	 */
	public function hooks() {
		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );

		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Activate the plugin
	 *
	 * @since  2.0.0
	 * @return null
	 */
	function _activate() {}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 *
	 * @since  2.0.0
	 * @return null
	 */
	function _deactivate() {}

	/**
	 * Init hooks
	 *
	 * @since  2.0.0
	 * @return null
	 */
	public function init() {

	}

	/**
	 * Check that all plugin requirements are met
	 *
	 * @since  2.0.0
	 * @return boolean
	 */
	public static function meets_requirements() {

		// We have met all requirements
		return true;
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  2.0.0
	 * @return boolean result of meets_requirements
	 */
	public function check_requirements() {
		if ( ! $this->meets_requirements() ) {

			// Add a dashboard notice
			add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

			// Deactivate our plugin
			deactivate_plugins( $this->basename );

			return false;
		}

		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met
	 *
	 * @since  2.0.0
	 * @return null
	 */
	public function requirements_not_met_notice() {
		// Output our error
		echo '<div id="message" class="error">';
		echo '<p>' . sprintf( __( 'Requirements have not been met so this plugin has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'ausm-plugin' ), admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  2.0.0
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
			case 'options':
			case 'helpers':
			case 'core':
				return $this->$field;
			default:
				throw new Exception( 'Invalid '. __CLASS__ .' property: ' . $field );
		}
	}

	/**
	 * Include a file from the includes directory
	 *
	 * @since  2.0.0
	 * @param  string  $filename Name of the file to be included
	 * @return bool    Result of include call.
	 */
	public static function include_file( $filename ) {
		$file = self::dir( 'includes/'. $filename .'.php' );
		if ( file_exists( $file ) ) {
			return include_once( $file );
		}
		return false;
	}

	/**
	 * This plugin's directory
	 *
	 * @since  2.0.0
	 * @param  string $path (optional) appended path
	 * @return string       Directory and path
	 */
	public static function dir( $path = '' ) {
		static $dir;
		$dir = $dir ? $dir : trailingslashit( dirname( __FILE__ ) );
		return $dir . $path;
	}

	/**
	 * This plugin's url
	 *
	 * @since  2.0.0
	 * @param  string $path (optional) appended path
	 * @return string       URL and path
	 */
	public static function url( $path = '' ) {
		static $url;
		$url = $url ? $url : trailingslashit( plugin_dir_url( __FILE__ ) );
		return $url . $path;
	}
}

/**
 * Grab the CHB_Auto_Update_Settings_Manager Object and return it.
 * Wrapper for CHB_Auto_Update_Settings_Manager::get_instance()
 *
 * @since  2.0.0
 * @return CHB_Auto_Update_Settings_Manager Singleton instance of plugin class.
 */
function chb_auto_update_settings_manager() {
	return CHB_Auto_Update_Settings_Manager::get_instance();
}

// Kick it off
chb_auto_update_settings_manager();

// Do the things

// Grab some vars we'll need to decide what to do.
$ausm_update_plugin_status = get_option( 'ausm_plugin_status' );
$aou_update_theme_status   = get_option( 'ausm_theme_status' );
$ausm_update_core_status   = get_option( 'ausm_core_status' );
$ausm_update_core_option   = get_option( 'ausm_core_option' );
$ausm_translation_status   = get_option( 'ausm_translation_status' );
$ausm_translation_option   = get_option( 'ausm_translation_option' );
$ausm_email_status         = get_option( 'ausm_email_status' );

// Update Plugins?
if ( 'Yes' === $ausm_update_plugin_status ) {
	add_filter( 'auto_update_plugin', [ chb_auto_update_settings_manager()->core, 'update_plugins' ], 10, 2 ); // Auto Updates plugins, excluding those in the array.
}

// Update Themes?
if ( 'Yes' === $aou_update_theme_status ) {
	add_filter( 'auto_update_theme', [ chb_auto_update_settings_manager()->core, 'update_themes' ], 10, 2 ); // Auto Updates plugins, excluding those in the array.
}

// Update Core?
if ( 'Yes' === $ausm_update_core_status ) {
	if ( 'ALL' === $ausm_update_core_option ) {
		add_filter( 'allow_dev_auto_core_updates', '__return_true' ); // Enable development, major & minor updates.
	}
	if ( 'Major' === $ausm_update_core_option || 'ALL' === $ausm_update_core_option ) {
		add_filter( 'allow_major_auto_core_updates', '__return_true' ); // Enable major & minor updates.
	}
	if ( 'Minor' === $ausm_update_core_option || 'ALL' === $ausm_update_core_option ) {
		add_filter( 'allow_minor_auto_core_updates', '__return_true' ); // Enable minor updates.
	}
}


// Update Translations?
if ( 'Yes' === $ausm_translation_status ) {
	add_filter( 'auto_update_translation', [ chb_auto_update_settings_manager()->core, 'update_translations' ], 10, 2 ); // Auto Updates translations, excluding those in the array.
}

// Send Emails about updates?
if ( 'Yes' === $ausm_email_status ) {
	add_filter( 'auto_core_update_send_email', '__return_true' );
}

