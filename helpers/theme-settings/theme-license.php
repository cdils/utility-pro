<?php
/**
* Social Settings
*
* This file registers the Social settings to the Theme Settings, to be used in the nav bar.
*
* @package Client Name
* @author Bill Erickson <bill@billerickson.net>
* @copyright Copyright (c) 2011, Bill Erickson
* @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/

add_filter( 'genesis_theme_settings_defaults', 'utility_pro_license_defaults' );
/**
 * Register Defaults
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 * @param array $defaults
 * @return array modified defaults
 *
 */
function utility_pro_license_defaults( $defaults ) {

	$defaults['utility_pro_theme_license_key'] = '';
	$defaults['utility_pro_theme_license_status'] = '';
	return $defaults;

}

add_action( 'genesis_settings_sanitizer_init', 'utility_pro_register_license_sanitization_filters' );
/**
 * Sanitization
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 */
function utility_pro_register_license_sanitization_filters() {
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD,
		array(
			'utility_pro_theme_license_key',
			'utility_pro_theme_license_status',
		)
	);
}

add_action('genesis_theme_settings_metaboxes', 'utility_pro_register_settings_metaxbox');
/**
 * Register Metabox
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 * @param string $_genesis_theme_settings_pagehook
 */
function utility_pro_register_settings_metaxbox( $_genesis_theme_settings_pagehook ) {
	add_meta_box( 'utility-pro-license-settings', __( 'Utility Pro Theme License', 'utility-pro' ), 'utility_pro_license_settings_box', $_genesis_theme_settings_pagehook, 'main', 'high');
}

/**
 * Create Metabox
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 */
function utility_pro_license_settings_box() {

	$license 	= get_option( 'utility_pro_theme_license_key' );
	$status 	= get_option( 'utility_pro_theme_license_status' );

	?>
	<label class="description" for="utility_pro_theme_license_key"><?php _e( 'Enter your license key' , 'utility-pro' ); ?></label><br />
	<input id="utility_pro_theme_license_key" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[utility_pro_theme_license_key]" type="text" class="regular-text" value="<?php echo esc_attr( genesis_get_option('utility_pro_theme_license_key') ); ?>" />
	<?php
}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {

		$license = trim( get_option( $this->theme_slug . '_license_key' ) );
		$strings = $this->strings;

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name )
		);

		$license_data = $this->get_api_response( $api_params );

		// If response doesn't include license data, return
		if ( !isset( $license_data->license ) ) {
			$message = $strings['license-unknown'];
			return $message;
		}

		// Get expire date
		$expires = false;
		if ( isset( $license_data->expires ) ) {
			$expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
			$renew_link = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . $strings['renew'] . '</a>';
		}

		// Get site counts
		$site_count = $license_data->site_count;
		$license_limit = $license_data->license_limit;

		// If unlimited
		if ( 0 == $license_limit ) {
			$license_limit = $strings['unlimited'];
		}

		if ( $license_data->license == 'valid' ) {
			$message = $strings['license-key-is-active'] . ' ';
			if ( $expires ) {
				$message .= sprintf( $strings['expires%s'], $expires ) . ' ';
			}
			if ( $site_count && $license_limit ) {
				$message .= sprintf( $strings['%1$s/%2$-sites'], $site_count, $license_limit );
			}
		} else if ( $license_data->license == 'expired' ) {
			if ( $expires ) {
				$message = sprintf( $strings['license-key-expired-%s'], $expires );
			} else {
				$message = $strings['license-key-expired'];
			}
			if ( $renew_link ) {
				$message .= ' ' . $renew_link;
			}
		} else if ( $license_data->license == 'invalid' ) {
			$message = $strings['license-keys-do-not-match'];
		} else if ( $license_data->license == 'inactive' ) {
			$message = $strings['license-is-inactive'];
		} else if ( $license_data->license == 'disabled' ) {
			$message = $strings['license-key-is-disabled'];
		} else if ( $license_data->license == 'site_inactive' ) {
			// Site is inactive
			$message = $strings['site-is-inactive'];
		} else {
			$message = $strings['license-status-unknown'];
		}

		return $message;
	}


/***********************************************
* Illustrates how to activate a license key.
***********************************************/

function edd_sample_theme_activate_license() {

	if( isset( $_POST['edd_theme_license_activate'] ) ) {
	 	if( ! check_admin_referer( 'edd_sample_nonce', 'edd_sample_nonce' ) )
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'edd_sample_theme_license_key' ) );

		$api_params = array(
			'edd_action' => 'activate_license',
			'license' => $license,
			'item_name' => urlencode( EDD_SL_THEME_NAME )
		);

		$response = wp_remote_get( add_query_arg( $api_params, EDD_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		update_option( 'edd_sample_theme_license_key_status', $license_data->license );

	}
}
add_action('admin_init', 'edd_sample_theme_activate_license');


/***********************************************
* Illustrates how to check if a license is valid
***********************************************/

function edd_sample_theme_check_license() {

	global $wp_version;

	$license = trim( get_option( 'edd_sample_theme_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( EDD_SL_THEME_NAME )
	);

	$response = wp_remote_get( add_query_arg( $api_params, EDD_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}
