<?php

namespace CHB_Auto_Update_Settings_Manager;

// WHERE DOES THIS GO NOW?
// Call register settings function.
add_action( 'admin_init', [chb_auto_update_settings_manager()->options, 'save_plugin_settings'] );

// Create custom plugin settings menu.
add_action( 'admin_menu', [chb_auto_update_settings_manager()->options, 'plugin_create_menu'] );

/**
 * Class to for Options Settings
 */
class Options {
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
	 * Save Plugin Settings
	 *
	 * @since 2.0.0
	 *
	 * @return  void
	 */
	public function save_plugin_settings() {
	 	if ( isset( $_POST['ausm_action'] ) ) {

			// Delete the option cache when we update
			wp_cache_delete ( 'alloptions', 'options' );

			// Refactor to loop through options array?

			// ausm_core_status
			if ( get_option( 'ausm_core_status' ) !== false && 'update_core' === $_POST['ausm_action'] ) {
				// We have one so update it
				update_option( 'ausm_core_status', $_POST['ausm_core_status'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_core_status', $_POST['ausm_core_status'] );

			}

			// ausm_core_option
			if ( get_option( 'ausm_core_option' ) !== false && 'update_core' === $_POST['ausm_action'] ) {
				// We have one so update it
				update_option( 'ausm_core_option', $_POST['ausm_core_option'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_core_option', $_POST['ausm_core_option'] );

			}

			// ausm_plugin_status
			if ( get_option( 'ausm_plugin_status' ) !== false && 'update_plugin' === $_POST['ausm_action'] ) {
				// We have one so update it
				update_option( 'ausm_plugin_status', $_POST['ausm_plugin_status'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_plugin_status', $_POST['ausm_plugin_status'] );

			}

			// ausm_plugin_option
			if ( ( get_option( 'ausm_plugin_option' ) !== false && 'update_plugin' === $_POST['ausm_action'] ) || ( null === $_POST['ausm_plugin_option'] && 'update_plugin' === $_POST['ausm_action'] ) ) {
				// We have one so update it
				update_option( 'ausm_plugin_option', $_POST['ausm_plugin_option'] );
			} else {
				// Don't have it, lets add it
				add_option( 'ausm_plugin_option', $_POST['ausm_plugin_option'] );
			}

			// ausm_theme_status
			if ( get_option( 'ausm_theme_status' ) !== false && 'update_theme' === $_POST['ausm_action'] ) {
				// We have one so update it
				update_option( 'ausm_theme_status', $_POST['ausm_theme_status'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_theme_status', $_POST['ausm_theme_status'] );

			}

			// ausm_theme_option
			if ( ( get_option( 'ausm_theme_option' ) !== false && 'update_theme' === $_POST['ausm_action'] ) || ( null === $_POST['ausm_theme_option'] && 'update_theme' === $_POST['ausm_action'] ) ) {
				// We have one so update it
				update_option( 'ausm_theme_option', $_POST['ausm_theme_option'] );
			} else {
				// Don't have it, lets add it
				add_option( 'ausm_theme_option', $_POST['ausm_theme_option'] );
			}


			// ausm_translation_status
			if ( get_option( 'ausm_translation_status' ) !== false && 'update_translation' === $_POST['ausm_action'] ) {
				// We have one so update it
				update_option( 'ausm_translation_status', $_POST['ausm_translation_status'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_translation_status', $_POST['ausm_translation_status'] );

			}

			// ausm_translation_option
			if ( ( get_option( 'ausm_translation_option' ) !== false && 'update_translation' === $_POST['ausm_action'] ) || ( null === $_POST['ausm_translation_option'] && 'update_translation' === $_POST['ausm_action'] ) ) {
				// We have one so update it
				update_option( 'ausm_translation_option', $_POST['ausm_translation_option'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_translation_option', $_POST['ausm_translation_option'] );

			}

			// ausm_translation_status
			if ( get_option( 'ausm_email_status' ) !== false && 'update_email' === $_POST['ausm_action'] ) {
				// We have one so update it
				update_option( 'ausm_email_status', $_POST['ausm_email_status'] );

			} else {
				// Don't have it, lets add it
				add_option( 'ausm_email_status', $_POST['ausm_email_status'] );

			}

		}
	}

	/**
	 * Create Sub Munu under WordPress Settings Menu
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function plugin_create_menu() {
		add_submenu_page( 'options-general.php', 'Auto Update Settings Manager', 'Auto Update Settings Manager', 'administrator', __FILE__, [$this, 'plugin_settings_page'] );
	}


	public function plugin_settings_page() {
		?>

		<h2>WordPress Auto Update Options</h2>

		<?php
			$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'info';
		?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=ausm-plugin%2Fsrc%2FOptions&tab=info" class="nav-tab <?php echo $active_tab === 'info' ? 'nav-tab-active' : ''; ?>">Auto Update Information</a>
			<a href="?page=ausm-plugin%2Fsrc%2FOptions&tab=core_settings" class="nav-tab <?php echo $active_tab === 'core_settings' ? 'nav-tab-active' : ''; ?>">Core Settings</a>
			<a href="?page=ausm-plugin%2Fsrc%2FOptions&tab=plugin_settings" class="nav-tab <?php echo $active_tab === 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Plugin Settings</a>
			<a href="?page=ausm-plugin%2Fsrc%2FOptions&tab=theme_settings" class="nav-tab <?php echo $active_tab === 'theme_settings' ? 'nav-tab-active' : ''; ?>">Theme Settings</a>
			<a href="?page=ausm-plugin%2Fsrc%2FOptions&tab=translation_settings" class="nav-tab <?php echo $active_tab === 'translation_settings' ? 'nav-tab-active' : ''; ?>">Translation Settings</a>
			<a href="?page=ausm-plugin%2Fsrc%2FOptions&tab=email_settings" class="nav-tab <?php echo $active_tab === 'email_settings' ? 'nav-tab-active' : ''; ?>">Email Settings</a>
		</h2>

		<div class="wrap">
			<div class="card">

			<!-- <form method='post' action='options.php'> -->
				<form method="post" action=''>

				<?php
				$nonce = wp_create_nonce( 'ausm_update_nonce');
				?>
				<input type='hidden' id='ausm_update_nonce' name='ausm_update_nonce' value='<?php echo $nonce; ?>' />
				<?php //settings_fields( 'ausm-plugin-settings' ); ?>
				<?php // do_settings_sections( 'ausm-plugin-settings' ); ?>

				<?php
				if ( 'info' === $active_tab ) {
				?>

					<h3>Thanks for using WordPress Auto Update Settings</h3>

					<p>This is a simple plugin that gives you fine tuned control over how automatic updates work within WordPress. You can turn on/off these settings for <strong>Core</strong>, <strong>Plugins</strong>, <strong>Themes</strong>, and <strong>Translations</strong>.</p>

					<p>In addition to on/off you can also select some of the advanced options related to updating like what kind of core updates you want to run. You can also exclude any plugin, theme or translation. This is useful when you've made modifications you don't want overridden or if a plugin or theme update breaks your site</p>

					<p>If you have suggestions or want to contribute to this plugin check out <a href=https://github.com/chrispian/wp-auto-update-options">our github repo</a> for this plugin. Pull requests welcome.</p>


					<?php
				}
				?>

				<?php
					if ( 'core_settings' === $active_tab ) {
				?>

						<input type='hidden' name='ausm_action' value='update_core' />


						<h3>Enable Automatic Updates for WordPress Core Files:</h3>

						<?php
						$ausm_core_status              = esc_attr( get_option( 'ausm_core_status' ) );
						$ausm_core_status_selected_yes = '';
						$ausm_core_status_selected_no  = '';

						if ( 'Yes' === $ausm_core_status ) {
							$ausm_core_status_selected_yes = 'selected';
						}
						if ( 'No' === $ausm_core_status ) {
							$ausm_core_status_selected_no = 'selected';
						}

						?>

						<select name="ausm_core_status">
							<option value="Yes" <?php echo $ausm_core_status_selected_yes; ?> />
							Yes</option>
							<option value="No" <?php echo $ausm_core_status_selected_no; ?> />
							No</option>
						</select>

						<h3>WordPress Update Type:</h3>
						<?php
						$ausm_core_option                = esc_attr( get_option( 'ausm_core_option' ) );
						$ausm_core_option_selected_all   = '';
						$ausm_core_option_selected_major = '';
						$ausm_core_option_selected_minor = '';

						if ( 'All' === $ausm_core_option ) {
							$ausm_core_option_selected_all = 'selected';
						}
						if ( 'Major' === $ausm_core_option ) {
							$ausm_core_option_selected_major = 'selected';
						}
						if ( 'Minor' === $ausm_core_option ) {
							$ausm_core_option_selected_minor = 'selected';
						}

						?>


						<div>
							WordPress describes each update type as follows:
							<ul>
								<li><strong>Development Updates</strong> = Core development updates, known as
									the "bleeding edge".</li>
								<li>
								<li><strong>Major</strong> = Major core release updates</li>
								<li><strong>Minor</strong> = Minor core updates, such as maintenance and
									security releases</li>
							</ul>
							<p>Auto Updates are safe and in most casues you should be using Minor or Major Updates.
							Use Development Updates only if you know and understand the risks - remember, this
								is bleeding edge code and may break your site.</p>

						</div>

						<select name="ausm_core_option">
							<option value="ALL" <?php echo $ausm_core_option_selected_all; ?> />
							ALL (Development, Major, and Major Updates)</option>
							<option value="Major" <?php echo $ausm_core_option_selected_major; ?> />
							Major Updates (Includes Minor Updates, NO Development Updates)</option>
							<option value="Minor" <?php echo $ausm_core_option_selected_minor; ?> />
							Minor Updates Only (No Development or Major Updates)</option>
							</select>


						<?php
					}
				?>


				<?php
					if ( 'plugin_settings' === $active_tab ) {
				?>


						<input type='hidden' name='ausm_action' value='update_plugin' />


						<h3>Enable Automatic Updates for Plugins:</h3>

						<?php
						$ausm_plugin_status              = esc_attr( get_option( 'ausm_plugin_status' ) );
						$ausm_plugin_status_selected_yes = '';
						$ausm_plugin_status_selected_no  = '';

						if ( 'Yes' === $ausm_plugin_status ) {
							$ausm_plugin_status_selected_yes = 'selected';
						}
						if ( 'No' === $ausm_plugin_status ) {
							$ausm_plugin_status_selected_no = 'selected';
						}

						?>
						<select name="ausm_plugin_status">
							<option value="Yes" <?php echo $ausm_plugin_status_selected_yes; ?> />
							Yes</option>
							<option value="No" <?php echo $ausm_plugin_status_selected_no; ?> />
							No</option>
						</select>

						<h3>Exclude Plugins:</h3>
						<?php
						$installed_plugins = get_plugins();
						$excluded_plugins  = get_option( 'ausm_plugin_option' );
						$checkbox_checked = '';

						foreach ( $installed_plugins as $key => $plugin ) {
							if ( $excluded_plugins ) {
								if ( in_array( $plugin['TextDomain'], $excluded_plugins, true ) ) {
									$checkbox_checked = 'checked';
								} else {
									$checkbox_checked = '';
								}
							}
							echo '<input type="checkbox" name="ausm_plugin_option[]" value="' . esc_attr( $plugin['TextDomain'] ) . '"' . esc_attr( $checkbox_checked ) . ' />' . esc_attr( $plugin['Name'] ) . "<br />\n";
						}

											?>


				<?php
					}

				if ( 'theme_settings' === $active_tab ) {
				?>

					<input type='hidden' name='ausm_action' value='update_theme' />

					<h3>Enable Automatic Updates for Themes:</h3>

					<?php
					$ausm_theme_status              = esc_attr( get_option( 'ausm_theme_status' ) );
					$ausm_theme_status_selected_yes = '';
					$ausm_theme_status_selected_no  = '';

					if ( 'Yes' === $ausm_theme_status ) {
						$ausm_theme_status_selected_yes = 'selected';
					}
					if ( 'No' === $ausm_theme_status ) {
						$ausm_theme_status_selected_no = 'selected';
					}

					?>

					<select name="ausm_theme_status">
						<option value="Yes" <?php echo $ausm_theme_status_selected_yes; ?> />Yes</option>
						<option value="No" <?php echo $ausm_theme_status_selected_no; ?> />No</option>
					</select>


					<h3>Exclude Themes:</h3>

					<?php


					$installed_themes = wp_get_themes();
					$excluded_themes  = get_option( 'ausm_theme_option' );
					$checkbox_checked = '';

					foreach ( $installed_themes as $key => $theme ) {
						if ( $excluded_themes ) {
							if ( in_array( $theme['Name'], $excluded_themes, true ) ) {
								$checkbox_checked = 'checked';
							} else {
								$checkbox_checked = '';
							}
						}

						echo '<input type="checkbox" name="ausm_theme_option[]" value="' . esc_attr( $theme['Name'] ) . '" ' . esc_attr( $checkbox_checked ) . ' />' . esc_attr( $theme['Name'] ) . "<br />\n";
					}


						?>



					<?php
				}

				if ( 'translation_settings' === $active_tab ) {
				?>


					<input type='hidden' name='ausm_action' value='update_translation' />

					<h3>Enable Automatic Updates for Translations:</h3>

					<?php
					$ausm_translation_status              = esc_attr( get_option( 'ausm_translation_status' ) );
					$ausm_translation_status_selected_yes = '';
					$ausm_translation_status_selected_no  = '';

					if ( 'Yes' === $ausm_translation_status ) {
						$ausm_translation_status_selected_yes = 'selected';
					}
					if ( 'No' === $ausm_translation_status ) {
						$ausm_translation_status_selected_no = 'selected';
					}

					?>

					<select name="ausm_translation_status">
						<option value="Yes" <?php echo $ausm_translation_status_selected_yes; ?> />Yes</option>
						<option value="No" <?php echo $ausm_translation_status_selected_no; ?> />No</option>
					</select>

				<h3>Exclude Translations:</h3>

					<?php

					$translations = get_available_languages();

					$excluded_translations = get_option( 'ausm_translation_option' );
					$checkbox_checked      = '';

					if ( is_array( $translations ) ) {
						foreach ( $translations as $key => $translation ) {
							if ( $excluded_translations ) {
								if ( in_array( $translation, $excluded_translations, true ) ) {
									$checkbox_checked = 'checked';
								} else {
									$checkbox_checked = '';
								}
							}

							echo '<input type="checkbox" name="ausm_translation_option[]" value="' . esc_attr( $translation ) . '" ' . esc_attr( $checkbox_checked ) . ' />' . esc_attr( $translation ) . "<br />\n";
						}
					}
								?>


					<?php
				}
						if ( 'email_settings' === $active_tab ) {
					?>

					<input type='hidden' name='ausm_action' value='update_email' />

					<h3>Send Emails For Updates:</h3>

					<?php
					$ausm_email_status              = esc_attr( get_option( 'ausm_email_status' ) );
					$ausm_email_status_selected_yes = '';
					$ausm_email_status_selected_no  = '';

					if ( 'Yes' === $ausm_email_status ) {
						$ausm_email_status_selected_yes = 'selected';
					}

					if ( 'No' === $ausm_email_status ) {
						$ausm_email_status_selected_no = 'selected';
					}

					?>

					<select name="ausm_email_status">
						<option value="Yes" <?php echo $ausm_email_status_selected_yes; ?> /> Yes</option>
						<option value="No" <?php echo $ausm_email_status_selected_no; ?> /> No</option>
					</select>


					<?php
				}
				?>


				<?php
					if ( 'info' != $active_tab ) {
						submit_button();
					}
				?>

			</form>
			</div>
		</div>
		<?php
	}




}
