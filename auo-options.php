<?php
/**
 *
 * Options screens for AUO Plugin.
 *
 * @link              https://github.com/chrispian/wp-auto-update-options
 * @since             1.0.0
 * @package           Auo_Plugin
 *
 */

// Call register settings function.
add_action( 'admin_init', 'register_auo_plugin_settings' );


// Create custom plugin settings menu.
add_action( 'admin_menu', 'auo_plugin_create_menu' );

/**
 * Add Sub Menu item to Settings Tab in WordPress Admin.
 */
function auo_plugin_create_menu() {
	add_submenu_page( 'options-general.php', 'Auto Update Settings', 'Auto Update Settings', 'administrator', __FILE__, 'auo_plugin_settings_page' );
}

/**
 * Register settings options for AUO Plugin.
 */
function register_auo_plugin_settings() {

	// Register Core Settings.
	register_setting( 'auo-plugin-settings', 'auo_core_status', 'string' );
	register_setting( 'auo-plugin-settings', 'auo_core_option', 'string' );

	// Register Plugin Settings.
	register_setting( 'auo-plugin-settings', 'auo_plugin_status', 'string' );
	register_setting( 'auo-plugin-settings', 'auo_plugin_option', 'string' );

	// Register Theme Settings.
	register_setting( 'auo-plugin-settings', 'auo_theme_status', 'string' );
	register_setting( 'auo-plugin-settings', 'auo_theme_option', 'string' );

	// Register Translation Settings.
	register_setting( 'auo-plugin-settings', 'auo_translation_status', 'string' );
	register_setting( 'auo-plugin-settings', 'auo_translation_option', 'string' );

	// Register Email Settings.
	register_setting( 'auo-plugin-settings', 'auo_email_status', 'string' );

}

/**
 * Render the settings page in WordPress admin
 */
function auo_plugin_settings_page() {
	?>

	<h2>WordPress Auto Update Options</h2>

	<?php
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'info';
	?>

	<h2 class="nav-tab-wrapper">
		<a href="?page=auo-plugin%2Fauo-options&tab=info" class="nav-tab <?php echo $active_tab === 'info' ? 'nav-tab-active' : ''; ?>">Auto Update Information</a>
		<a href="?page=auo-plugin%2Fauo-options&tab=core_settings" class="nav-tab <?php echo $active_tab === 'core_settings' ? 'nav-tab-active' : ''; ?>">Core Settings</a>
		<a href="?page=auo-plugin%2Fauo-options&tab=plugin_settings" class="nav-tab <?php echo $active_tab === 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Plugin Settings</a>
		<a href="?page=auo-plugin%2Fauo-options&tab=theme_settings" class="nav-tab <?php echo $active_tab === 'theme_settings' ? 'nav-tab-active' : ''; ?>">Theme Settings</a>
		<a href="?page=auo-plugin%2Fauo-options&tab=translation_settings" class="nav-tab <?php echo $active_tab === 'translation_settings' ? 'nav-tab-active' : ''; ?>">Translation Settings</a>
		<a href="?page=auo-plugin%2Fauo-options&tab=email_settings" class="nav-tab <?php echo $active_tab === 'email_settings' ? 'nav-tab-active' : ''; ?>">Email Settings</a>
	</h2>

	<div class="wrap">
		<div class="card">

		<?php

		/*
		* Not sure if this is needed. Will come back to this.
		if ( 'FOUND' === $wp_config_status ) {
			echo 'FTP Credentials Found!!';
		} else {
			echo 'FTP Credentials not present! - Turn this into a proper WordPress Notice and explain what to do.';
		}
		*/

		?>

		<form method="post" action="options.php">
			<?php settings_fields( 'auo-plugin-settings' ); ?>
			<?php do_settings_sections( 'auo-plugin-settings' ); ?>

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


					<h3>Enable Automatic Updates for WordPress Core Files:</h3>

					<?php
					$auo_core_status              = esc_attr( get_option( 'auo_core_status' ) );
					$auo_core_status_selected_yes = '';
					$auo_core_status_selected_no  = '';

					if ( 'Yes' === $auo_core_status ) {
						$auo_core_status_selected_yes = 'selected';
					}
					if ( 'No' === $auo_core_status ) {
						$auo_core_status_selected_no = 'selected';
					}

					?>

					<select name="auo_core_status">
						<option value="Yes" <?php echo $auo_core_status_selected_yes; ?> />
						Yes</option>
						<option value="No" <?php echo $auo_core_status_selected_no; ?> />
						No</option>
					</select>

					<h3>WordPress Update Type:</h3>
					<?php
					$auo_core_option                = esc_attr( get_option( 'auo_core_option' ) );
					$auo_core_option_selected_all   = '';
					$auo_core_option_selected_major = '';
					$auo_core_option_selected_minor = '';

					if ( 'All' === $auo_core_option ) {
						$auo_core_option_selected_all = 'selected';
					}
					if ( 'Major' === $auo_core_option ) {
						$auo_core_option_selected_major = 'selected';
					}
					if ( 'Minor' === $auo_core_option ) {
						$auo_core_option_selected_minor = 'selected';
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

					<select name="auo_core_option">
						<option value="ALL" <?php echo $auo_core_option_selected_all; ?> />
						ALL (Development, Major, and Major Updates)</option>
						<option value="Major" <?php echo $auo_core_option_selected_major; ?> />
						Major Updates (Includes Minor Updates, NO Development Updates)</option>
						<option value="Minor" <?php echo $auo_core_option_selected_minor; ?> />
						Minor Updates Only (No Development or Major Updates)</option>
						</select>


					<?php
				}
			?>


			<?php
				if ( 'plugin_settings' === $active_tab ) {
			?>

					<h3>Enable Automatic Updates for Plugins:</h3>

					<?php
					$auo_plugin_status              = esc_attr( get_option( 'auo_plugin_status' ) );
					$auo_plugin_status_selected_yes = '';
					$auo_plugin_status_selected_no  = '';

					if ( 'Yes' === $auo_plugin_status ) {
						$auo_plugin_status_selected_yes = 'selected';
					}
					if ( 'No' === $auo_plugin_status ) {
						$auo_plugin_status_selected_no = 'selected';
					}

					?>
					<select name="auo_plugin_status">
						<option value="Yes" <?php echo $auo_plugin_status_selected_yes; ?> />
						Yes</option>
						<option value="No" <?php echo $auo_plugin_status_selected_no; ?> />
						No</option>
					</select>

					<h3>Exclude Plugins:</h3>
					<?php
					$installed_plugins = get_plugins();
					$excluded_plugins  = get_option( 'auo_plugin_option' );

					foreach ( $installed_plugins as $key => $plugin ) {
						if ( $excluded_plugins ) {
							if ( in_array( $plugin['TextDomain'], $excluded_plugins, true ) ) {
								$checkbox_checked = 'checked';
							} else {
								$checkbox_checked = '';
							}
						}
						echo '<input type="checkbox" name="auo_plugin_option[]" value="' . esc_attr( $plugin['TextDomain'] ) . '"' . esc_attr( $checkbox_checked ) . ' />' . esc_attr( $plugin['Name'] ) . "<br />\n";
					}

										?>


			<?php
				}

			if ( 'theme_settings' === $active_tab ) {
			?>

				<h3>Enable Automatic Updates for Themes:</h3>

				<?php
				$auo_theme_status              = esc_attr( get_option( 'auo_theme_status' ) );
				$auo_theme_status_selected_yes = '';
				$auo_theme_status_selected_no  = '';

				if ( 'Yes' === $auo_theme_status ) {
					$auo_theme_status_selected_yes = 'selected';
				}
				if ( 'No' === $auo_theme_status ) {
					$auo_theme_status_selected_no = 'selected';
				}

				?>

				<select name="auo_theme_status">
					<option value="Yes" <?php echo $auo_theme_status_selected_yes; ?> />Yes</option>
					<option value="No" <?php echo $auo_theme_status_selected_no; ?> />No</option>
				</select>


				<h3>Exclude Themes:</h3>

				<?php


				$installed_themes = wp_get_themes();
				$excluded_themes  = get_option( 'auo_theme_option' );
				$checkbox_checked = '';

				foreach ( $installed_themes as $key => $theme ) {
					if ( $excluded_themes ) {
						if ( in_array( $theme['Name'], $excluded_themes, true ) ) {
							$checkbox_checked = 'checked';
						} else {
							$checkbox_checked = '';
						}
					}

					echo '<input type="checkbox" name="auo_theme_option[]" value="' . esc_attr( $theme['Name'] ) . '" ' . esc_attr( $checkbox_checked ) . ' />' . esc_attr( $theme['Name'] ) . "<br />\n";
				}


					?>



				<?php
			}

			if ( 'translation_settings' === $active_tab ) {
			?>

				<h3>Enable Automatic Updates for Translations:</h3>

				<?php
				$auo_translation_status              = esc_attr( get_option( 'auo_translation_status' ) );
				$auo_translation_status_selected_yes = '';
				$auo_translation_status_selected_no  = '';

				if ( 'Yes' === $auo_translation_status ) {
					$auo_translation_status_selected_yes = 'selected';
				}
				if ( 'No' === $auo_translation_status ) {
					$auo_translation_status_selected_no = 'selected';
				}

				?>

				<select name="auo_translation_status">
					<option value="Yes" <?php echo $auo_translation_status_selected_yes; ?> />Yes</option>
					<option value="No" <?php echo $auo_translation_status_selected_no; ?> />No</option>
				</select>

			<h3>Exclude Translations:</h3>

				<?php

				$translations = get_available_languages();

				$excluded_translations = get_option( 'auo_translation_option' );
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

						echo '<input type="checkbox" name="auo_translation_option[]" value="' . esc_attr( $translation ) . '" ' . esc_attr( $checkbox_checked ) . ' />' . esc_attr( $translation ) . "<br />\n";
					}
				}
							?>


				<?php
			}
					if ( 'email_settings' === $active_tab ) {
				?>

				<h3>Send Emails For Updates:</h3>

				<?php
				$auo_email_status              = esc_attr( get_option( 'auo_email_status' ) );
				$auo_email_status_selected_yes = '';
				$auo_email_status_selected_no  = '';

				if ( 'Yes' === $auo_email_status ) {
					$auo_email_status_selected_yes = 'selected';
				}
				if ( 'No' === $auo_email_status ) {
					$auo_email_status_selected_no = 'selected';
				}

				?>

				<select name="auo_email_status">
					<option value="Yes" <?php echo $auo_email_status_selected_yes; ?> />
					Yes</option>
					<option value="No" <?php echo $auo_email_status_selected_no; ?> />
					No</option>
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
<?php } ?>
