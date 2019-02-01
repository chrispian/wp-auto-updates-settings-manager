<?php

namespace CHB_Auto_Update_Settings_Manager;

/**
 * Class for the core functions of the plugin
 */
class Core {
	/**
	 * Parent plugin class
	 *
	 * @var class
	 * @since  2.0.0
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @since 2.0.0
	 *
	 * @param  CHB_Auto_Update_Settings_Manager $plugin Main plugin class.
	 * @return  void
	 */
	public function __construct( $plugin ) {
		// Parent plugin.
		$this->plugin = $plugin;
	}



	/**
	 * Set return to tell WP to auto update plugins or not
	 *
	 * @param $update, $item
	 * @return bool
	 */
	public function update_plugins( $update, $item ) {

		$excluded_plugins = get_option( 'ausm_plugin_option' );
		if ( $excluded_plugins ) {
			if ( in_array( $item->slug, $excluded_plugins, true ) ) {
				return false; // Never update a plugin in this array.
			} else {
				return true; // Otherwise, update it!
			}
		}
	}

	/**
	 * Set return to tell WP to auto update themes or not
	 *
	 * @param $update, $item
	 * @return bool
	 */
	public function update_themes( $update, $item ) {

		$excluded_themes = get_option( 'ausm_theme_option' );
		if ( $excluded_themes ) {
			if ( in_array( $item->slug, $excluded_themes, true ) ) {
				return false; // Never update a theme in this array.
			} else {
				return true; // Otherwise, update it!
			}
		}
	}

	/**
	 * Set return to tell WP to auto update translations or not
	 *
	 * @param $update, $item
	 * @return bool
	 */
	public function update_translations( $update, $item ) {

		$excluded_translations = get_option( 'ausm_translation_option' );
		if ( $excluded_translations ) {
			if ( in_array( $item->slug, $excluded_translations, true ) ) {
				return false; // Never update a theme in this array.
			} else {
				return true; // Otherwise, update it!
			}
		}
	}

}
