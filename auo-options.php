<?php
/**
 *
 * Options screens for AUO Plugin.
 *
 * @link              http://www.chrispian.com
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

	// Register Email Settings.
	register_setting( 'auo-plugin-settings', 'auo_email_status', 'string' );

}

/**
 * Render the settings page in WordPress admin
 */
function auo_plugin_settings_page() {
	?>
	<div class="wrap">
		<h1>Auto Update Options</h1>

		<?php

		// Do we need this? Or is there a better way?
		if ( 'FOUND' === $wp_config_status ) {
			echo 'FTP Credentials Found!!';
		} else {
			echo 'FTP Credentials not present! - Turn this into a proper WordPress Notice and explain what to do.';
		}

		?>

		<form method="post" action="options.php">

			<?php settings_fields( 'auo-plugin-settings' ); ?>
			<?php do_settings_sections( 'auo-plugin-settings' ); ?>

			<table class="form-table">

				<tr valign="top">
					<th scope="row">Enable Automatic Updates for WordPress Core Files:</th>
					<td>

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
							<option value="Yes" <?php echo $auo_core_status_selected_yes; ?> />Yes</option>
							<option value="No" <?php echo $auo_core_status_selected_no; ?> />No</option>
						</select>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">WordPress Update Type:</th>
					<td>

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
								<li><strong>Development Updates</strong> = Core development updates, known as the "bleeding edge"<li>
								<li><strong>Major</strong> = Major core release updates<li>
								<li><strong>Minor</strong> = Minor core updates, such as maintenance and security releases<li>
							</ul>
							Auto Updates are safe and in most casues you should be using Minor or Major Updates. Use Development Updates only if you know and understand the risks - remember, this is bleeding edge code and may break your site.

						</div>

						<select name="auo_core_option">
							<option value="ALL" <?php echo $auo_core_option_selected_all; ?> />ALL (Development, Major, and Major Updates)</option>
							<option value="Major" <?php echo $auo_core_option_selected_major; ?> />Major Updates (Includes Minor Updates, NO Development Updates)</option>
							<option value="Minor" <?php echo $auo_core_option_selected_minor; ?> />Minor Updates Only (No Development or Major Updates)</option>
						</select>
					</td>
				</tr>

			</table>

			<table class="form-table">

				<tr valign="top">
					<th scope="row">Enable Automatic Updates for Plugins:</th>
					<td>

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
							<option value="Yes" <?php echo $auo_plugin_status_selected_yes; ?> />Yes</option>
							<option value="No" <?php echo $auo_plugin_status_selected_no; ?> />No</option>
						</select>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">Exclude Plugins:</th>
					<td>
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

					</td>
				</tr>


			</table>

			<table class="form-table">

				<tr valign="top">
					<th scope="row">Enable Automatic Updates for Themes:</th>
					<td>


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
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">Exclude Themes:</th>
					<td>
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

					</td>
				</tr>

			</table>


			<table class="form-table">

				<tr valign="top">
					<th scope="row">Enable Automatic Updates for Translations:</th>
					<td>

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
					</td>
				</tr>

			</table>

			<table class="form-table">

				<tr valign="top">
					<th scope="row">Send Emails For Updates:</th>
					<td>

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
							<option value="Yes" <?php echo $auo_email_status_selected_yes; ?> />Yes</option>
							<option value="No" <?php echo $auo_email_status_selected_no; ?> />No</option>
						</select>
					</td>
				</tr>


			</table>

			<?php submit_button(); ?>

		</form>
	</div>
<?php } ?>
