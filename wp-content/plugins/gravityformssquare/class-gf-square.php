<?php
/**
 * Gravity Forms Square Add-On.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2009 - 2018, Rocketgenius
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}


// Include the payment add-on framework.
GFForms::include_payment_addon_framework();

/**
 * Gravity Forms Square Add-On.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */
class GF_Square extends GFPaymentAddOn {

	/**
	 * Contains an instance of this class, if available.
	 *
	 * @since 1.0.0
	 * @var object $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;

	/**
	 * Defines the version of the Square Add-On.
	 *
	 * @since 1.0.0
	 * @var string $_version Contains the version, defined from square.php
	 */
	protected $_version = GF_SQUARE_VERSION;

	/**
	 * Defines the minimum Gravity Forms version required.
	 *
	 * @since 1.0.0
	 * @var string $_min_gravityforms_version The minimum version required.
	 */
	protected $_min_gravityforms_version = GF_SQUARE_MIN_GF_VERSION;

	/**
	 * Defines the plugin slug.
	 *
	 * @since 1.0.0
	 * @var string $_slug The slug used for this plugin.
	 */
	protected $_slug = 'gravityformssquare';

	/**
	 * Defines the main plugin file.
	 *
	 * @since 1.0.0
	 * @var string $_path The path to the main plugin file, relative to the plugins folder.
	 */
	protected $_path = 'gravityformssquare/square.php';

	/**
	 * Defines the full path to this class file.
	 *
	 * @since 1.0.0
	 * @var string $_full_path The full path.
	 */
	protected $_full_path = __FILE__;

	/**
	 * Defines the URL where this Add-On can be found.
	 *
	 * @since 1.0.0
	 * @var string $_url The URL of the Add-On.
	 */
	protected $_url = 'http://www.gravityforms.com';

	/**
	 * Defines the title of this Add-On.
	 *
	 * @since 1.0.0
	 * @var string $_title The title of the Add-On.
	 */
	protected $_title = 'Gravity Forms Square Add-On';

	/**
	 * Defines the short title of the Add-On.
	 *
	 * @since 1.0.0
	 * @var string $_short_title The short title.
	 */
	protected $_short_title = 'Square';

	/**
	 * Defines if Add-On should use Gravity Forms servers for update data.
	 *
	 * @since 1.0.0
	 * @var bool $_enable_rg_autoupgrade true
	 */
	protected $_enable_rg_autoupgrade = true;

	/**
	 * Square requires monetary amounts to be formatted as the smallest unit for the currency being used e.g. cents.
	 *
	 * @since 1.0.0
	 * @var bool $_requires_smallest_unit true
	 */
	protected $_requires_smallest_unit = true;

	/**
	 * Defines the capability needed to access the Add-On settings page.
	 *
	 * @since 1.0.0
	 * @var    string $_capabilities_settings_page The capability needed to access the Add-On settings page.
	 */
	protected $_capabilities_settings_page = 'gravityforms_square';

	/**
	 * Defines the capability needed to access the Add-On form settings page.
	 *
	 * @since 1.0.0
	 * @var    string $_capabilities_form_settings The capability needed to access the Add-On form settings page.
	 */
	protected $_capabilities_form_settings = 'gravityforms_square';

	/**
	 * Defines the capability needed to uninstall the Add-On.
	 *
	 * @since 1.0.0
	 * @var    string $_capabilities_uninstall The capability needed to uninstall the Add-On.
	 */
	protected $_capabilities_uninstall = 'gravityforms_square_uninstall';

	/**
	 * Defines the capabilities needed for the Square Add-On
	 *
	 * @since 1.0.0
	 * @var    array $_capabilities The capabilities needed for the Add-On
	 */
	protected $_capabilities = array( 'gravityforms_square', 'gravityforms_square_uninstall' );

	/**
	 * Contains an instance of the Square API library, if available.
	 *
	 * @since 1.0.0
	 * @var    GF_Square_API $api Contains an instance of the Square API library wrapper.
	 */
	protected $api = null;

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @since 1.0.0
	 *
	 * @return object GF_Square
	 */
	public static function get_instance() {

		if ( null === self::$_instance ) {
			self::$_instance = new GF_Square();
		}

		return self::$_instance;

	}

	/**
	 * Prevent the class from being cloned
	 *
	 * @since 1.0.0
	 */
	private function __clone() {
		/** Do nothing */
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function scripts() {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		$square_script_url = $this->is_sandbox() ? 'https://js.squareupsandbox.com/v2/paymentform' : 'https://js.squareup.com/v2/paymentform';
		$scripts           = array(
			// Square Payment Form script.
			array(
				'handle'    => 'gforms_square_payment_form',
				'src'       => $square_script_url,
				'deps'      => array(),
				'in_footer' => false,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
				),
			),
			// Front end script.
			array(
				'handle'    => 'gforms_square_frontend',
				'src'       => $this->get_base_url() . "/js/frontend{$min}.js",
				'version'   => $this->_version,
				'deps'      => array( 'jquery', 'gform_json', 'gform_gravityforms', 'gforms_square_payment_form' ),
				'in_footer' => false,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
				),
				'strings'   => array(
					'no_active_frontend_feed' => wp_strip_all_tags( __( 'The credit card field will initiate once the payment condition is met.', 'gravityformssquare' ) ),
					'requires_name'           => wp_strip_all_tags( __( 'Please enter a full name.', 'gravityformssquare' ) ),
					'cardNumber'              => wp_strip_all_tags( __( 'Invalid Credit Card number.', 'gravityformssquare' ) ),
					'cvv'                     => wp_strip_all_tags( __( 'Invalid CVV number.', 'gravityformssquare' ) ),
					'expirationDate'          => wp_strip_all_tags( __( 'Invalid expiration date.', 'gravityformssquare' ) ),
					'postalCode'              => wp_strip_all_tags( __( 'Invalid postal code.', 'gravityformssquare' ) ),
					'MISSING_CARD_DATA'       => wp_strip_all_tags( __( 'Please fill in all credit card details.', 'gravityformssquare' ) ),
					'UNSUPPORTED_CARD_BRAND'  => wp_strip_all_tags( __( 'Card is not supported.', 'gravityformssquare' ) ),
					'INVALID_APPLICATION_ID'  => wp_strip_all_tags( __( 'An error occured while processing your request, please try again later.', 'gravityformssquare' ) ),
					'MISSING_APPLICATION_ID'  => wp_strip_all_tags( __( 'An error occured while processing your request, please try again later.', 'gravityformssquare' ) ),
					'TOO_MANY_REQUESTS'       => wp_strip_all_tags( __( 'An error occured while processing your request, please try again later.', 'gravityformssquare' ) ),
					'UNAUTHORIZED'            => wp_strip_all_tags( __( 'An error occured while processing your request, please try again later.', 'gravityformssquare' ) ),
					'sca'                     => wp_strip_all_tags( __( 'SCA Verification failed, please try again!', 'gravityformssquare' ) ),
				),
			),
			// Plugin settings script ( admin pages ).
			array(
				'handle'  => 'gform_square_pluginsettings',
				'deps'    => array( 'jquery' ),
				'src'     => $this->get_base_url() . "/js/plugin_settings{$min}.js",
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings', 'entry_view' ),
						'tab'        => $this->_slug,
					),
				),
				'strings' => array(
					'refund'       => wp_strip_all_tags( __( 'Are you sure you want to refund this payment?', 'gravityformssquare' ) ),
					'disconnect'   => array(
						'site'    => wp_strip_all_tags( __( 'Are you sure you want to disconnect from Square for this website?', 'gravitformssquare' ) ),
						'account' => wp_strip_all_tags( __( 'Are you sure you want to disconnect all Gravity Forms sites connected to this Square account?', 'gravitformssquare' ) ),
					),
					'settings_url' => admin_url( 'admin.php?page=gf_settings&subview=' . $this->get_slug() ),
					'deauth_nonce' => wp_create_nonce( 'gf_square_deauth' ),
					'mode'         => $this->get_mode(),
					'ajaxurl'      => admin_url( 'admin-ajax.php' ),
				),
			),
		);

		return array_merge( parent::scripts(), $scripts );

	}

	/**
	 * Register needed styles.
	 *
	 * @since 1.0.0
	 *
	 * @return array $styles
	 */
	public function styles() {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		$styles = array(
			array(
				'handle'    => 'gforms_square_frontend',
				'src'       => $this->get_base_url() . "/css/frontend{$min}.css",
				'version'   => $this->_version,
				'in_footer' => false,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
				),
			),
			array(
				'handle'  => 'gform_square_pluginsettings',
				'src'     => $this->get_base_url() . "/css/plugin_settings{$min}.css",
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings' ),
						'tab'        => $this->_slug,
					),
				),
			),
		);

		return array_merge( parent::styles(), $styles );

	}

	// --------------------------------------------------------------------------------------------------------- //
	// ------------------------- Plugin initialization  -------------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Try to initialize API and load the Square credit card field.
	 *
	 * @since 1.0.0
	 */
	public function pre_init() {
		parent::pre_init();

		// $this->initialize_api();

		 require_once 'includes/class-gf-field-square-creditcard.php';
	}

	/**
	 * Initialize Square API wrapper.
	 *
	 * Initializes Square API client if credentials exist and are valid
	 * Renews token if it has been more than 6 days since last renewal.
	 *
	 * @since 1.0.0
	 *
	 * @param null $auth_data Auth data to be used instead of the stored data in settings.
	 * @param null $custom_mode Mode to be used instead of the default mode stored in settings.
	 * @param bool $force_reinit Force initializing the api even if it was initialized before.
	 *
	 * @return bool
	 */
	public function initialize_api( $auth_data = null, $custom_mode = null, $force_reinit = false ) {

		// If the API is already initialized, return true.
		if ( ! is_null( $this->api ) && ! $force_reinit ) {
			return true;
		}

		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;

		// If auth data is not provided and it is not stored, we can't initialize the api.
		if ( ! is_array( $auth_data ) && false === $this->auth_data_exists( $mode ) ) {
			return false;
		}

		// If Square API class does not exist, load Square API library and API wrapper.
		if ( ! class_exists( 'GF_Square_API' ) ) {
			require_once 'includes/autoload.php';
			require_once 'includes/class-gf-square-api.php';
		}

		// If we are going to use stored auth tokens, maybe they should be refreshed.
		if ( ! is_array( $auth_data ) ) {
			$this->maybe_renew_token( $mode );
		}

		// Load auth data and instantiate an api wrapper.
		$tokens = is_array( $auth_data ) ? $auth_data : $this->get_auth_data( $mode );
		if ( is_array( $tokens ) && ! empty( $tokens['access_token'] ) ) {
			$this->api = new GF_Square_API( $tokens, $mode );
		} else {
			$this->log_debug( __METHOD__ . '() : Empty auth data; ' . $tokens );
			return false;
		}

		// Check if token is revoked by trying to fetch locations.
		if ( false === $this->api->fetch_locations() ) {
			$this->log_debug( __METHOD__ . '() : Token Revoked; ' . $this->api->get_last_exception()->getMessage() );
			$this->api = null;

			return false;
		}

		return true;
	}

	/**
	 * Checks if auth data exist.
	 *
	 * @since 1.0.0
	 *
	 * @param string $mode live or sandbox.
	 *
	 * @return bool
	 */
	public function auth_data_exists( $mode = null ) {
		$mode         = is_null( $mode ) ? $this->get_mode() : $mode;
		$auth_setting = $this->get_plugin_setting( 'auth_data' );

		if ( ! is_array( $auth_setting ) || empty( $auth_setting ) ) {
			return false;
		}

		return ! empty( $auth_setting[ $mode ] );
	}

	/**
	 * Get authorization data.
	 *
	 * Retrieves saved auth array that contains access token and refresh token.
	 *
	 * @since 1.0.0
	 *
	 * @param null $custom_mode If we should get auth data for a specific mode other than the default one.
	 *
	 * @return array|null
	 */
	public function get_auth_data( $custom_mode = null ) {
		// decide which auth data do we need, sandbox, live and later feed level modes.
		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		// Get the authentication setting.
		$auth_setting = $this->get_plugin_setting( 'auth_data' );
		// If the authentication token is not set, return null.
		if ( rgblank( $auth_setting ) ) {
			return null;
		}
		$encrypted_auth_data = empty( $auth_setting[ $mode ] ) ? null : $auth_setting[ $mode ];
		if ( is_null( $encrypted_auth_data ) ) {
			return null;
		}

		// Decrypt data.
		$decrypted_auth_data = GFCommon::openssl_decrypt( $encrypted_auth_data, $this->get_encryption_key() );
		$auth_data           = @unserialize( base64_decode( $decrypted_auth_data ) );

		return $auth_data;
	}

	/**
	 * Checks if token should be renewed and tries to renew it.
	 *
	 * @param string $mode live or sandbox.
	 *
	 * @return bool
	 */
	public function maybe_renew_token( $mode ) {

		$auth_data = $this->get_auth_data( $mode );
		if ( ! is_array( $auth_data ) || empty( $auth_data['refresh_token'] ) || empty( $auth_data['date_created'] ) ) {
			$this->log_error( __METHOD__ . '() : empty or corrupt auth data for ' . $mode . ' mode; ' );
			return false;
		}

		if ( time() > ( $auth_data['date_created'] + 3600 * 24 * 6 ) ) {
			$new_auth_data = $this->renew_token( $auth_data['refresh_token'], $mode );
			$token_updated = $this->update_auth_tokens( $new_auth_data, $mode );
			if ( is_wp_error( $token_updated ) ) {
				$this->log_error( __METHOD__ . '(): Failed to renew token; ' . $token_updated->get_error_message() );
			} else {
				$this->log_debug( __METHOD__ . '(): Token renewed for ' . $mode . ' mode' );
				return true;
			}
		}

		return false;
	}

	/**
	 * Renews access token.
	 *
	 * @since 1.0.0
	 *
	 * @param string $refresh_token Refresh token.
	 * @param string $mode live or sandbox.
	 *
	 * @return bool|string
	 */
	public function renew_token( $refresh_token, $mode ) {

		$custom_app = $this->get_plugin_setting( 'custom_app_' . $mode ) === '1';
		if ( ! $custom_app ) {
			// Call the refresh endpoint on Gravity API.
			$args     = array(
				'body' => array(
					'refresh_token' => $refresh_token,
					'mode'          => $mode,
				),
			);
			$response = wp_remote_post(
				$this->get_gravity_api_url( '/auth/square/refresh' ),
				$args
			);

			// Check if the request was successful.
			$response_code = wp_remote_retrieve_response_code( $response );
			if ( $response_code === 200 ) {
				$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
				if ( ! empty( $response_body['auth_payload'] ) ) {
					return $response_body['auth_payload'];
				} else {
					$this->log_error( __METHOD__ . '(): Missing auth_payload; ' . $response );
					return false;
				}
			} else {
				// Log that token could not be renewed.
				$details = wp_remote_retrieve_body( $response );
				$this->log_error( __METHOD__ . '(): Unable to refresh token; ' . $details );
				return false;
			}
		} else {
			$tokens = $this->get_custom_app_tokens( $refresh_token, 'refresh_token', $mode );
			return $tokens;
		}

	}

	/**
	 * Stores auth tokens when we get auth payload from Square.
	 *
	 * @since 1.0.0
	 *
	 * @param string $auth_payload Encoded authorization data.
	 *
	 * @param string $custom_mode live or sandbox.
	 *
	 * @return bool|WP_Error
	 */
	public function update_auth_tokens( $auth_payload, $custom_mode = null ) {

		$settings = $this->get_plugin_settings();
		if ( ! is_array( $settings ) ) {
			$settings = array();
		}
		// Make sure payload contains the required data.
		if ( empty( $auth_payload['access_token'] ) || empty( $auth_payload['refresh_token'] ) || empty( $auth_payload['merchant_id'] ) ) {
			return new WP_Error( '1', esc_html__( 'Missing authentication data.', 'gravityformssquare' ) );
		}

		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		// Try initializing the api and defaulting to a location.
		if ( $this->initialize_api( $auth_payload, $mode, true ) ) {
			$active_locations = $this->api->get_active_locations();
			if ( is_array( $active_locations ) && ! empty( $active_locations ) ) {
				$default_location = $active_locations[0]['value'];
			} else {
				// If not active location that matches the GF currency found, don't update tokens.
				$this->api = null;
				return new WP_Error( '3', esc_html__( 'Gravity Forms currency doesn\'t match your Square account currency.', 'gravityformssquare' ) );
			}
		} else {
			// can't initialize auth_data with new tokens !
			return new WP_Error( '4', esc_html__( 'Invalid authentication data.', 'gravityformssquare' ) );
		}

		// Add creation date so we can decide when to renew.
		$auth_payload['date_created'] = time();

		// Encrypt.
		$encrypted_data = GFCommon::openssl_encrypt( base64_encode( serialize( $auth_payload ) ), $this->get_encryption_key() );
		if ( ! empty( $settings['auth_data'] ) ) {
			$auth_data = $settings['auth_data'];
		} else {
			$auth_data = array();
		}
		$auth_data[ $mode ] = $encrypted_data;

		$settings['auth_data'] = $auth_data;
		// If no location selected, set default location.
		if ( empty( $settings[ 'location_' . $mode ] ) ) {
			$settings[ 'location_' . $mode ] = $default_location;
		}
		// Save plugin settings.
		$this->update_plugin_settings( $settings );

		if ( $this->get_plugin_setting( 'custom_app_' . $mode ) === '1' ) {
			$this->log_debug( __METHOD__ . '(): Connected using custom app.' );
		} else {
			$this->log_debug( __METHOD__ . '(): Connected using gravityforms app.' );
		}

		return true;
	}

	/**
	 * Add AJAX callbacks.
	 *
	 * @since 1.0.0
	 */
	public function init_ajax() {
		parent::init_ajax();

		// Add AJAX callback for de-authorizing with Square.
		add_action( 'wp_ajax_gfsquare_deauthorize', array( $this, 'ajax_deauthorize' ) );
	}

	/**
	 * Revoke token and remove them from Settings.
	 *
	 * @since 1.0.0
	 */
	public function ajax_deauthorize() {
		check_ajax_referer( 'gf_square_deauth', 'nonce' );
		$scope = sanitize_text_field( wp_unslash( empty( $_POST['scope'] ) ? '' : $_POST['scope'] ) );
		$mode  = $this->get_mode();
		// If user is not authorized, exit.
		if ( ! GFCommon::current_user_can_any( $this->_capabilities_settings_page ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Access denied.', 'gravityformssquare' ) ) );
		}

		// If API instance is not initialized, return error.
		if ( ! $this->initialize_api() ) {
			$this->log_error( __METHOD__ . '(): Unable to de-authorize because API is not initialized.' );

			wp_send_json_error();
		}

		if ( $scope === 'account' ) {
			// Call API to revoke access token.
			$custom_app  = $this->get_plugin_setting( 'custom_app_' . $mode ) === '1';
			$merchant_id = $this->api->get_merchant_id();
			if ( ! $custom_app ) {
				$response = wp_remote_get(
					add_query_arg(
						array(
							'merchant_id' => $merchant_id,
							'mode'        => $mode,
						),
						$this->get_gravity_api_url( '/auth/square/deauthorize' )
					)
				);
			} else {
				// Get base OAuth URL.
				$auth_url      = $this->get_square_host_url() . '/oauth2/revoke';
				$client_id     = $this->get_plugin_setting( 'custom_app_id_' . $mode );
				$client_secret = $this->get_plugin_setting( 'custom_app_secret_' . $mode );
				// Prepare OAuth URL parameters.
				$args = array(
					'headers'    => array(
						'Authorization' => 'Client ' . $client_secret,
					),
					'user-agent' => 'Gravity Forms',
					'body'       => array(
						'client_id'   => $client_id,
						'merchant_id' => $merchant_id,
					),
				);
				// Execute request.
				$response = wp_remote_post( $auth_url, $this->add_square_headers( $args ) );
			}

			$response_code = wp_remote_retrieve_response_code( $response );

			if ( $response_code === 200 ) {
				// Log that we revoked the access token.
				$this->log_debug( __METHOD__ . '(): Square access token revoked.' );
			} else {
				// Log that token cannot be revoked.
				$this->log_error( __METHOD__ . '(): Unable to revoke token at Square.' );
				wp_send_json_error( array( 'message' => esc_html__( 'Unable to revoke token at Square.', 'gravityformssquare' ) ) );
				wp_die();
			}
		}

		// Remove access token from settings.
		$settings     = $this->get_plugin_settings();
		$auth_setting = $settings['auth_data'];
		// If the authentication token is not set, nothing to do.
		if ( rgblank( $auth_setting ) ) {
			wp_send_json_success();
		}
		if ( ! empty( $auth_setting[ $mode ] ) ) {
			unset( $auth_setting[ $mode ] );
		}
		$settings['auth_data'] = $auth_setting;

		// Delete location setting.
		if ( ! empty( $settings[ 'location_' . $mode ] ) ) {
			unset( $settings[ 'location_' . $mode ] );
		}

		$this->update_plugin_settings( $settings );

		// Return success response.
		wp_send_json_success();
	}

	/**
	 * Fires hourly to update payment statuses and check if token should be renewed.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function check_status() {

		// Check access token status for each mode.
		$modes = array( 'live', 'sandbox' );
		foreach ( $modes as $mode ) {
			$this->maybe_renew_token( $mode );
		}

		// Get last time cron ran.
		$settings    = $this->get_plugin_settings();
		$last_update = ! empty( $settings['last_cron_time'] ) ? $settings['last_cron_time'] : null;
		// Update last run time.
		$time                       = new DateTime();
		$settings['last_cron_time'] = $time->format( \DateTime::RFC3339 );
		// Update refund statuses.
		$this->sync_refunds( $last_update );
		$this->update_plugin_settings( $settings );

	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Settings --------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Update auth tokens if required.
	 *
	 * @since 1.0.0
	 */
	public function maybe_update_auth_tokens() {

		if ( rgget( 'subview' ) !== $this->get_slug() ) {
			return;
		}

		$tokens_updated = null;
		$code           = sanitize_text_field( rgget( 'code' ) );
		$mode           = sanitize_text_field( rgget( 'mode' ) );
		$custom_app     = $this->get_plugin_setting( 'custom_app_' . $mode ) === '1';
		if ( ! empty( $code ) && ! $this->is_save_postback() ) {
			$state = sanitize_text_field( rgget( 'state' ) );
			if ( false === wp_verify_nonce( $state, 'gf_square_auth' ) ) {
				$tokens_updated = false;
			} else {
				if ( ! $custom_app ) {
					$tokens = $this->get_tokens( $code, $mode );
				} else {
					$tokens = $this->get_custom_app_tokens( $code, 'authorization_code', $mode );
				}
				$tokens_updated = $this->update_auth_tokens( $tokens, $mode );
				if ( false !== $tokens_updated && ! is_wp_error( $tokens_updated ) ) {
					wp_redirect( remove_query_arg( array( 'code', 'mode', 'state' ) ) );
				}
			}
		}

		// If error is provided or couldn't update tokens, Add error message.
		if ( false === $tokens_updated || is_wp_error( $tokens_updated ) || rgget( 'auth_error' ) ) {
			GFCommon::add_error_message( esc_html__( 'Unable to connect your Square account.', 'gravityformssquare' ) );
			// If we have a specific reason why we couldn't update, show it.
			if ( is_wp_error( $tokens_updated ) ) {
				GFCommon::add_error_message( $tokens_updated->get_error_message() );
			}
		}
	}

	/**
	 * Setup plugin settings fields.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {
		$fields = array(
			array(
				'title'  => esc_html__( 'Account Settings', 'gravityformssquare' ),
				'fields' => array(
					array(
						'label'         => esc_html__( 'Mode', 'gravityformssquare' ),
						'name'          => 'mode',
						'type'          => 'radio',
						'horizontal'    => true,
						'default_value' => 'live',
						'class'         => 'square_mode',
						'choices'       => array(
							array(
								'label' => esc_html__( 'Live', 'gravityformssquare' ),
								'value' => 'live',
							),
							array(
								'label' => esc_html__( 'Sandbox', 'gravityformssquare' ),
								'value' => 'sandbox',
							),
						),
					),
					array(
						'name' => 'auth_button',
						'type' => 'auth_button',
					),
					array(
						'name' => 'auth_data',
						'type' => 'hidden',
					),
					array(
						'name' => 'custom_app_live',
						'type' => 'hidden',
					),
					array(
						'name' => 'custom_app_sandbox',
						'type' => 'hidden',
					),
					array(
						'name' => 'last_cron_time',
						'type' => 'hidden',
					),
					array(
						'name'          => 'sca_testing_check',
						'type'          => 'checkbox',
						'hidden'        => ! $this->initialize_api() || $this->get_mode() != 'sandbox' || GFCommon::get_currency() != 'GBP',
						'default_value' => 1,
						'choices'       => array(
							array(
								'label'         => esc_html__( 'Force SCA testing', 'gravityformssquare' ),
								'name'          => 'sca_testing',
								'default_value' => 1,

							),
						),
					),
					array(
						'name'  => 'errors',
						'label' => '',
						'type'  => 'errors',
					),
				),
			),
		);

		$location_field = array(
			'name'                => 'location_' . $this->get_mode(),
			'label'               => esc_html__( 'Business Location', 'gravityformssquare' ),
			'validation_callback' => array( $this, 'validate_location_currency' ),
		);

		if ( $this->square_api_ready() ) {
			// If we can initialize api, set location field type to select.
			$location_field['type']    = 'select';
			$location_field['choices'] = $this->get_location_choices();
			// Add custom app settings hidden fields
			// In case custom app is used, we still need these settings for deauth and refresh.
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_id_' . $this->get_mode(),
				'type' => 'hidden',
			);
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_secret_' . $this->get_mode(),
				'type' => 'hidden',
			);

		} else {
			// API is not initialized yet, hide location.
			$location_field['type'] = 'hidden';
		}

		$fields[0]['fields'][] = $location_field;

		// Decide which location selector to output as hidden.
		// To keep the other mode location stored so when user switches mode user doesn't have to select it again.
		if ( $this->get_mode() == 'sandbox' ) {
			$fields[0]['fields'][] = array(
				'name' => 'location_live',
				'type' => 'hidden',
			);
		} else {
			$fields[0]['fields'][] = array(
				'name' => 'location_sandbox',
				'type' => 'hidden',
			);
		}

		// Decide which custom app settings to output as hidden.
		// To keep the other mode custom app settings stored so when user switches mode user doesn't have to enter it again.
		if ( $this->get_mode() == 'sandbox' ) {
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_id_live',
				'type' => 'hidden',
			);
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_secret_live',
				'type' => 'hidden',
			);
		} else {
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_id_sandbox',
				'type' => 'hidden',
			);
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_secret_sandbox',
				'type' => 'hidden',
			);
		}

		return $fields;
	}

	/**
	 * Generates location field choices.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_location_choices() {

		$locations = array();

		// Make sure api is initialized first.
		if ( $this->initialize_api() ) {
			// Get active locations from API.
			$locations = $this->api->get_active_locations();
		}

		return $locations;
	}

	/**
	 * Generates Auth button settings field.
	 *
	 * @since 1.0.0
	 * @param array $field Field properties.
	 *
	 * @param bool  $echo Display field contents. Defaults to true.
	 *
	 * @return string
	 */
	public function settings_auth_button( $field, $echo = true ) {
		$html = '';
		// If we could initialize api, means we are connected, so show disconnect UI.
		if ( $this->initialize_api() ) {
			$merchant = $this->api->get_merchant_name();
			if ( is_wp_error( $merchant ) ) {
				$this->log_error( __METHOD__ . '(): Unable to retrieve merchant name; ' . $merchant->get_error_message() );
			} else {
				if ( $this->get_setting( 'custom_app_' . $this->get_mode() ) === '1' ) {
					$html = '<p>' . esc_html__( 'Connected to Square using custom app as: ', 'gravityformssquare' ) . '<strong>' . $merchant . '</strong></p>';
				} else {
					$html = '<p>' . esc_html__( 'Connected to Square as: ', 'gravityformssquare' ) . '<strong>' . $merchant . '</strong></p>';
				}
			}

			$button_text = $this->is_sandbox() ? esc_html__( 'Disconnect your sandbox Square account.', 'gravityformssquare' ) : esc_html__( 'Disconnect your live Square account.', 'gravityformssquare' );
			$html       .= sprintf(
				' <a href="#" class="button deauth_button">%1$s</a>',
				$button_text
			);

			$html .= '<div id="deauth_scope" class="alert_red" style="margin-top: 20px;padding:20px; padding-top:5px;">';
			$html .= '<p><label for="deauth_scope0"><input type="radio" name="deauth_scope" value="site" id="deauth_scope0" checked="checked">' . esc_html__( 'Disconnect this site only', 'gravityformssquare' ) . '</label></p>';
			$html .= '<p><label for="deauth_scope1"><input type="radio" name="deauth_scope" value="account" id="deauth_scope1">' . esc_html__( 'Disconnect all Gravity Forms sites connected to this Square account', 'gravityformssquare' ) . '</label></p>';
			$html .= '<p>' . sprintf( ' <a href="#" class="button deauth_button" id="gform_square_deauth_button">%1$s</a>', esc_html__( 'Disconnect', 'gravityformssquare' ) ) . '</p>';
			$html .= '</div>';
		} elseif ( $this->api == null ) {
			$mode = $this->get_mode();
			// If SSL is available, or localhost is being used, display OAuth settings.
			$host_whitelist = array(
				'127.0.0.1',
				'::1',
			);
			$host_url       = empty( $_SERVER['REMOTE_ADDR'] ) ? null : $_SERVER['REMOTE_ADDR'];
			if ( GFCommon::is_ssl() || in_array( $host_url, $host_whitelist ) ) {
				if ( $this->get_setting( 'custom_app_' . $mode ) !== '1' ) {
					// Create Gravity API Square OAuth endpoint URL.
					$settings_url = urlencode( admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug ) );
					$state        = wp_create_nonce( 'gf_square_auth' );
					$auth_url     = add_query_arg(
						array(
							'redirect_to' => $settings_url,
							'state'       => $state,
							'mode'        => $this->get_mode(),
						),
						$this->get_gravity_api_url( '/auth/square' )
					);
					// Connect button markup.
					$button_text    = $this->is_sandbox() ? esc_html__( 'Click here to connect your sandbox Square account', 'gravityformssquare' ) : esc_attr__( 'Click here to connect your live Square account', 'gravityformssquare' );
					$connect_button = sprintf(
						'<a href="%2$s" class="button square-connect" id="gform_square_auth_button" title="%s"></a>',
						$button_text,
						$auth_url
					);

					$custom_app_link = '';
					if ( $this->show_custom_app_settings() ) {
						$custom_app_link = sprintf(
							'<p>&nbsp;</p><p class="gform_square_custom_app_link">%s</p>',
							/* translators: 1: Open link tag 2: Close link tag */
							sprintf( esc_html__( '%1$sI want to use a custom Square app.%2$s', 'gravityformssquare' ), '<a href="#" id="gform_square_enable_custom_app">', '</a>' )
						);
					}

					/* translators: 1. Open link tag 2. Close link tag */
					$learn_more_message = '<p>' . sprintf( esc_html__( '%1$sLearn more%2$s about connecting with Square.', 'gravityformssquare' ), '<a target="_blank" href=" https://docs.gravityforms.com/">', '</a>' ) . '</p>';
					$html               = $connect_button . $learn_more_message . $custom_app_link;
				} else {
					$app_id     = $this->get_setting( 'custom_app_id_' . $mode );
					$app_secret = $this->get_setting( 'custom_app_secret_' . $mode );

					ob_start();
					$this->single_setting_row(
						array(
							'name'     => '',
							'type'     => 'text',
							'label'    => esc_html__( 'OAuth Redirect URI', 'gravityformssquare' ),
							'class'    => 'large',
							'value'    => admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug . '&mode=' . $mode ),
							'readonly' => true,
							'onclick'  => 'this.select();',
						)
					);
					// Display custom app ID.
					$this->single_setting_row(
						array(
							'name'  => 'custom_app_id_' . $mode,
							'type'  => 'text',
							'label' => esc_html__( 'App ID', 'gravityformssquare' ),
							'class' => 'medium',
							// 'feedback_callback' => array( $this, 'is_valid_app_key_secret' ),
						)
					);

					// Display custom app secret.
					$this->single_setting_row(
						array(
							'name'  => 'custom_app_secret_' . $mode,
							'type'  => 'text',
							'label' => esc_html__( 'App Secret', 'gravityformssquare' ),
							'class' => 'medium',
							// 'feedback_callback' => array( $this, 'is_valid_app_key_secret' ),
						)
					);
					$html .= ob_get_clean();
					$html .= '<tr><td></td><td>';
					// Display custom app OAuth button if App ID & Secret exit.
					if ( ! empty( $app_id ) && ! empty( $app_secret ) ) {
						$auth_url = $this->get_square_auth_url( $app_id, $app_secret );
						// Connect button markup.
						$button_text = $this->is_sandbox() ? esc_html__( 'Click here to connect your sandbox Square account', 'gravityformssquare' ) : esc_attr__( 'Click here to connect your live Square account', 'gravityformssquare' );
						$html       .= sprintf(
							'<a href="%2$s" class="button square-connect" id="gform_square_auth_button" title="%s"></a>',
							$button_text,
							$auth_url
						);
					}

					$html .= '<p>&nbsp;</p><p>&nbsp;</p>' . sprintf(
						'<p class="gform_square_custom_app_link">%s</p>',
						/* translators: 1: Open link tag 2: Close link tag */
							sprintf( esc_html__( '%1$sI do not want to use a custom app.%2$s', 'gravityformssquare' ), '<a href="#" id="gform_square_disable_custom_app">', '</a>' )
					);

					$html .= '</td></tr>';
				}
			} else {
				// Show SSL required warning.
				$html  = '<div class="alert_red" id="settings_error">';
				$html .= '<h4>' . esc_html__( 'SSL Certificate Required', 'gravityformssquare' ) . '</h4>';
				/* translators: 1: Open link tag 2: Close link tag */
				$html .= sprintf( esc_html__( 'Make sure you have an SSL certificate installed and enabled, then %1$sclick here to continue%2$s.', 'gravityformssquare' ), '<a href="' . admin_url( 'admin.php?page=gf_settings&subview=gravityformssquare', 'https' ) . '">', '</a>' );
				$html .= '</div>';
			}
		}

		if ( $echo ) {
			echo $html;
		}

		return $html;

	}

	/**
	 * Check if custom app settings should be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function show_custom_app_settings() {

		/**
		 * Allow custom app link to be displayed.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $show_settings Defaults to false, return true to show custom app settings.
		 */
		$show_settings = apply_filters( 'gform_square_show_custom_app_settings', false );

		return $show_settings;
	}

	/**
	 * Generates Errors section on settings page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field Field properties.
	 *
	 * @param bool  $echo Display field contents. Defaults to true.
	 *
	 * @return string
	 */
	public function settings_errors( $field, $echo = true ) {
		// Define variable to avoid notice.
		$html = null;
		if ( ! $this->initialize_api() ) {
			$html = '';
		} else {
			// Show any settings error messages if not a save postback.
			if ( ! $this->square_currency_matches_gf() ) {
				// Show business location required warning.
				$html .= '<div class="alert_red" id="settings_error" >';
				$html .= '<h4>' . esc_html__( 'Currency Mismatch', 'gravityformssquare' ) . '</h4>';
				// Translators: 1. Square Currency, 2. Gravity Forms Currency.
				$html .= '<p>' . sprintf( esc_html__( 'The selected Square business location currency is %1$s while Gravity Forms currency is %2$s, both currencies should match so you can receive payments to this location, please change your Gravity Forms currency setting.', 'gravityformssquare' ), $this->get_selected_location_currency(), GFCommon::get_currency() ) . '</p>';
				$html .= '</div>';
			}
		}

		if ( $echo ) {
			echo $html;
		}

		return $html;
	}

	/**
	 * Business location field validation.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $field The field object.
	 * @param string $field_setting The field value.
	 *
	 * @return void
	 */
	public function validate_location_currency( $field, $field_setting ) {
		/*
		if ( ! is_null( $this->api ) && strtoupper( $this->api->get_location_currency( $field_setting ) ) !== strtoupper( GFCommon::get_currency() ) ) {
			$this->set_field_error( array( 'name' => $field['name'] ), esc_html__( 'Please select a location with a currency that matches Gravity Forms currency', 'gravityformssquare' ) );
		}*/
	}

	/**
	 * Define feed settings fields.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function feed_settings_fields() {
		$default_settings = parent::feed_settings_fields();

		// Remove Subscription.
		$transaction_type = parent::get_field( 'transactionType', $default_settings );
		$choices          = $transaction_type['choices'];
		foreach ( $choices as $key => $choice ) {
			if ( $choice['value'] === 'subscription' ) {
				unset( $choices[ $key ] );
			}
		}
		$transaction_type['choices'] = $choices;
		$default_settings            = $this->replace_field( 'transactionType', $transaction_type, $default_settings );

		return $default_settings;
	}

	/**
	 * Prepare fields for field mapping in feed settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array $fields
	 */
	public function billing_info_fields() {
		$fields = array(
			array(
				'name'       => 'email',
				'label'      => __( 'Email address', 'gravityformssquare' ),
				'field_type' => array( 'email' ),
			),
			array(
				'name'       => 'first_name',
				'label'      => __( 'First Name', 'gravityformssquare' ),
				'field_type' => array( 'name', 'text' ),
			),
			array(
				'name'       => 'last_name',
				'label'      => __( 'Last Name', 'gravityformssquare' ),
				'field_type' => array( 'name', 'text' ),
			),
			array(
				'name'       => 'address_line1',
				'label'      => __( 'Address', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_line2',
				'label'      => __( 'Address 2', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_city',
				'label'      => __( 'City', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_state',
				'label'      => __( 'State', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_zip',
				'label'      => __( 'Zip', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_country',
				'label'      => __( 'Country', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
		);

		return $fields;

	}

	/**
	 * Get post payment actions config.
	 *
	 * @since 3.1
	 *
	 * @param string $feed_slug The feed slug.
	 *
	 * @return array
	 */
	public function get_post_payment_actions_config( $feed_slug ) {
		return array(
			'position' => 'before',
			'setting'  => 'conditionalLogic',
		);
	}

	/**
	 *  Remove feed options field.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function option_choices() {
		return array();
	}

	/**
	 * Set feed creation control.
	 *
	 * @since  1.0.0
	 *
	 * @return bool
	 */
	public function can_create_feed() {
		return $this->square_api_ready() && $this->has_square_card_field();
	}

	/**
	 * Get Square Card field for form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form Form object. Defaults to null.
	 *
	 * @return boolean
	 */
	public function has_square_card_field( $form = null ) {
		// Get form.
		if ( is_null( $form ) ) {
			$form = $this->get_current_form();
		}

		return $this->get_square_card_field( $form ) !== false;
	}

	/**
	 * Gets Square credit card field object.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form The Form Object.
	 *
	 * @return bool|GF_Field_Square_CreditCard The Square card field object, if found. Otherwise, false.
	 */
	public function get_square_card_field( $form ) {
		$fields = GFAPI::get_fields_by_type( $form, array( 'square_creditcard' ) );

		return empty( $fields ) ? false : $fields[0];
	}

	/**
	 * Disable feed duplication.
	 *
	 * @since  1.0
	 *
	 * @param int $id Feed ID requesting duplication.
	 *
	 * @return bool
	 */
	public function can_duplicate_feed( $id ) {

		return false;
	}

	/**
	 * Remove the add new button from the title if the form requires a Square credit card field.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function feed_list_title() {
		$form = $this->get_current_form();

		if ( ! $this->has_square_card_field( $form ) ) {
			return $this->form_settings_title();
		}

		return GFFeedAddOn::feed_list_title();
	}

	/**
	 * Get the require Square credit card message.
	 *
	 * @since 1.0.0
	 *
	 * @return false|string
	 */
	public function feed_list_message() {
		$form = $this->get_current_form();

		// If settings are not yet configured, display default message.
		if ( ! $this->initialize_api() ) {
			return GFFeedAddOn::feed_list_message();
		}

		// If form doesn't have a square card field, display require message.
		if ( ! $this->has_square_card_field( $form ) ) {
			return $this->requires_square_card_message();
		}

		return GFFeedAddOn::feed_list_message();
	}

	/**
	 * Display require Square Card field message.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function requires_square_card_message() {
		$url = add_query_arg(
			array(
				'view'    => null,
				'subview' => null,
			)
		);

		return sprintf( esc_html__( "You must add a Square Card field to your form before creating a feed. Let's go %1\$sadd one%2\$s!", 'gravityformsquare' ), "<a href='" . esc_url( $url ) . "'>", '</a>' );
	}

	/**
	 * Add supported notification events.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form The form currently being processed.
	 *
	 * @return array|false The supported notification events. False if feed cannot be found within $form.
	 */
	public function supported_notification_events( $form ) {

		// If this form does not have a Square  feed, return false.
		if ( ! $this->has_feed( $form['id'] ) ) {
			return false;
		}

		// Return Square notification events.
		return array(
			'complete_payment' => esc_html__( 'Payment Completed', 'gravityformssquare' ),
			'refund_payment'   => esc_html__( 'Payment Refunded', 'gravityformssquare' ),
			'fail_payment'     => esc_html__( 'Payment Failed', 'gravityformssquare' ),
		);

	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Frontend --------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Initialize the frontend hooks.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function init() {

		add_filter( 'gform_register_init_scripts', array( $this, 'register_init_scripts' ), 1, 3 );
		add_filter( 'gform_field_content', array( $this, 'add_square_inputs' ), 10, 5 );
		add_filter( 'gform_field_validation', array( $this, 'pre_validation' ), 10, 4 );
		add_filter( 'gform_pre_submission', array( $this, 'populate_credit_card_last_four' ) );
		add_filter(
			'gform_submission_values_pre_save',
			array(
				$this,
				'square_card_submission_value_pre_save',
			),
			10,
			3
		);

		// Support frontend feeds so JS event will be triggered when we have a valid feed so we can handle it from JS side.
		$this->_supports_frontend_feeds = true;

		parent::init();

	}

	/**
	 * Register Square scripts when displaying form.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form Form object.
	 * @param array $field_values Current field values. Not used.
	 * @param bool  $is_ajax If form is being submitted via AJAX.
	 *
	 * @return void
	 */
	public function register_init_scripts( $form, $field_values, $is_ajax ) {

		// Check if we should enqueue the frontend script.
		if ( ! $this->frontend_script_callback( $form ) ) {
			return;
		}

		// Prepare JS Square Object arguments.
		$args = array(
			'application_id' => $this->get_application_id(),
			'location_id'    => $this->get_selected_location_id(),
			'formId'         => $form['id'],
			'isAjax'         => $is_ajax,
			'currency'       => $this->get_selected_location_currency(),
			'is_sandbox'     => $this->is_sandbox(),
		);

		// Check SCA testing option.
		$force_sca = $this->get_plugin_setting( 'sca_testing' );
		if ( ( is_null( $force_sca ) || $force_sca == 1 ) && $this->get_mode() == 'sandbox' && GFCommon::get_currency() == 'GBP' ) {
			$args['forceSCA'] = true;
		} else {
			$args['forceSCA'] = false;
		}

		// Get square card field'd data.
		$cc_field          = $this->get_square_card_field( $form );
		$args['ccFieldId'] = $cc_field->id;
		$args['ccPage']    = $cc_field->pageNumber;

		// get all Square feeds.
		$feeds = $this->get_feeds_by_slug( $this->_slug, $form['id'] );

		// Default card input style.
		$default_styles = array(
			'boxShadow' => '0px 0px 0px 0px',
			'details'   => array(
				'hidden' => true,
			),
		);

		/**
		 * Filters Square single element card inputStyle object properties.
		 *
		 * Square single element styling is done by providing css-like
		 * properties and their values in an object called inputStyle,
		 * this filters the default styles provided to the card element.
		 *
		 * @since 1.0.0
		 *
		 * @param array $default_styles {
		 *      Array that contains css properties and their values, property names and values should match
		 *      inputStyle documentation here
		 *      https://developer.squareup.com/docs/api/paymentform#datatype-inputstyleobjects
		 * }
		 *
		 * @param string $form_id The id of the form that contains the field.
		 */
		$args['cardStyle'] = apply_filters( 'gform_square_card_style', $default_styles, $form['id'] );

		foreach ( $feeds as $feed ) {
			if ( rgar( $feed, 'is_active' ) === '0' ) {
				continue;
			}
			// Get feed settings to pass them to JS object.
			$feed_settings = array(
				'feedId'          => $feed['id'],
				'type'            => rgars( $feed, 'meta/transactionType' ),
				'email'           => rgars( $feed, 'meta/billingInformation_email' ),
				'first_name'      => rgars( $feed, 'meta/billingInformation_first_name' ),
				'last_name'       => rgars( $feed, 'meta/billingInformation_last_name' ),
				'address_line1'   => rgars( $feed, 'meta/billingInformation_address_line1' ),
				'address_line2'   => rgars( $feed, 'meta/billingInformation_address_line2' ),
				'address_city'    => rgars( $feed, 'meta/billingInformation_address_city' ),
				'address_state'   => rgars( $feed, 'meta/billingInformation_address_state' ),
				'address_zip'     => rgars( $feed, 'meta/billingInformation_address_zip' ),
				'address_country' => rgars( $feed, 'meta/billingInformation_address_country' ),
			);

			if ( rgars( $feed, 'meta/transactionType' ) === 'product' ) {
				$feed_settings['paymentAmount'] = rgars( $feed, 'meta/paymentAmount' );
			}

			$args['feeds'][ $feed['id'] ] = $feed_settings;
		}

		$script = 'new GFSquare( ' . json_encode( $args, JSON_FORCE_OBJECT ) . ' );';

		// Add Square script to form scripts.
		GFFormDisplay::add_init_script( $form['id'], 'square', GFFormDisplay::ON_PAGE_RENDER, $script );
	}

	/**
	 * Check if the form has an active Square feed and a Square credit card field.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form Form object.
	 *
	 * @return bool If the script and style should be enqueued.
	 */
	public function frontend_script_callback( $form ) {

		return $form && $this->has_feed( $form['id'] ) && $this->has_square_card_field( $form );

	}

	/**
	 * Add required Square inputs to form.
	 *
	 * @since  1.0.0
	 *
	 * @param string  $content The field content to be filtered.
	 * @param object  $field   The field that this input tag applies to.
	 * @param string  $value   The default/initial value that the field should be pre-populated with.
	 * @param integer $lead_id When executed from the entry detail screen, $lead_id will be populated with the Entry ID.
	 * @param integer $form_id The current Form ID.
	 *
	 * @return string $content HTML formatted content.
	 */
	public function add_square_inputs( $content, $field, $value, $lead_id, $form_id ) {

		// If this form does not have a Square feed or if this is not a Square card field, return field content.
		if ( ! $this->has_feed( $form_id ) || $field->get_input_type() !== 'square_creditcard' ) {
			return $content;
		}

		// Populate Square card data to hidden fields if they exist.

		$square_nonce = sanitize_text_field( rgpost( 'square_nonce' ) );
		if ( $square_nonce ) {
			$content .= '<input type="hidden" name="square_nonce" id="' . $form_id . '_square_nonce" value="' . esc_attr( $square_nonce ) . '" />';
		}

		$square_verification = sanitize_text_field( rgpost( 'square_verification' ) );
		if ( $square_verification ) {
			$content .= '<input type="hidden" name="square_verification" id="' . $form_id . '_square_verification" value="' . esc_attr( $square_verification ) . '" />';
		}

		$square_last_four = sanitize_text_field( rgpost( 'square_credit_card_last_four' ) );
		if ( $square_last_four ) {
			$content .= '<input type="hidden" name="square_credit_card_last_four" id="' . $form_id . '_square_credit_card_last_four" value="' . esc_attr( $square_last_four ) . '" />';
		}

		$square_card_type = sanitize_text_field( rgpost( 'square_credit_card_type' ) );
		if ( $square_card_type ) {
			$content .= '<input type="hidden" name="square_credit_card_type" id="' . $form_id . '_square_credit_card_type" value="' . esc_attr( $square_card_type ) . '" />';
		}

		return $content;

	}

	/**
	 * Handles Square card field's custom validation.
	 *
	 * The square card field doesn't have an input, it is just a div that is replaced by
	 * the square single element payment form this will cause the field to fail standard
	 * validation if marked as required, instead of checking for an input's value we check if we
	 * have a nonce.
	 *
	 * @since  1.0.0
	 *
	 * @param array    $result The field validation result and message.
	 * @param mixed    $value The field input values.
	 * @param array    $form The Form currently being processed.
	 * @param GF_Field $field The field currently being processed.
	 *
	 * @return array $result The results of the validation.
	 */
	public function pre_validation( $result, $value, $form, $field ) {
		if ( $field->type === 'square_creditcard' && $field->isRequired && empty( rgpost( 'square_nonce' ) ) ) {
			$result['is_valid'] = false;
			$result['message']  = esc_html__( 'Invalid credit card nonce', 'gravityformssquare' );
		}

		return $result;

	}

	/**
	 * Populate the $_POST with the last four digits of the card number and card type.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form Form object.
	 */
	public function populate_credit_card_last_four( $form ) {

		if ( ! $this->is_payment_gateway || ! $this->has_square_card_field( $form ) ) {
			return;
		}

		$cc_field                                 = $this->get_square_card_field( $form );
		$last_four                                = sanitize_text_field( rgpost( 'square_credit_card_last_four' ) );
		$card_type                                = sanitize_text_field( rgpost( 'square_credit_card_type' ) );
		$_POST[ 'input_' . $cc_field->id . '_1' ] = 'XXXXXXXXXXXX' . $last_four;
		$_POST[ 'input_' . $cc_field->id . '_2' ] = $card_type;

	}

	/**
	 * Allows the modification of submitted values of the Square Card field before the draft submission is saved.
	 *
	 * @since 1.0.0
	 *
	 * @param array $submitted_values The submitted values.
	 * @param array $form The Form object.
	 *
	 * @return array
	 */
	public function square_card_submission_value_pre_save( $submitted_values, $form ) {
		foreach ( $form['fields'] as $field ) {
			if ( $field->type == 'square_creditcard' ) {
				unset( $submitted_values[ $field->id ] );
			}
		}

		return $submitted_values;
	}

	/**
	 * Gets the payment validation result.
	 *
	 * @since  1.0.0
	 *
	 * @param array $validation_result Contains the form validation results.
	 * @param array $authorization_result Contains the form authorization results.
	 *
	 * @return array The validation result for the credit card field.
	 */
	public function get_validation_result( $validation_result, $authorization_result ) {
		if ( empty( $authorization_result['error_message'] ) ) {
			return $validation_result;
		}

		$credit_card_page = 0;
		foreach ( $validation_result['form']['fields'] as &$field ) {
			if ( $field->type === 'square_creditcard' ) {
				$field->failed_validation  = true;
				$field->validation_message = $authorization_result['error_message'];
				$credit_card_page          = $field->pageNumber;
				break;
			}
		}

		$validation_result['credit_card_page'] = $credit_card_page;
		$validation_result['is_valid']         = false;

		return $validation_result;
	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Transactions ----------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Initialize authorizing the transaction for the product.
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array Authorization and transaction ID if authorized. Otherwise, exception.
	 */
	public function authorize( $feed, $submission_data, $form, $entry ) {

		// Check API is ready before starting any transactions.
		if ( false === $this->square_api_ready() ) {
			$this->log_error( __METHOD__ . '(): Square API could not be loaded' );
			return $this->authorization_error( esc_html__( 'Please check your Square API settings', 'gravityformssquare' ) );
		}

		return $this->authorize_product( $feed, $submission_data, $form, $entry );

	}

	/**
	 * Create the Square payment and return any authorization errors which occur.
	 *
	 * @since  1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array Authorization and transaction ID if authorized. Otherwise, exception.
	 */
	public function authorize_product( $feed, $submission_data, $form, $entry ) {
		// Check that we have nonce otherwise return an error.
		$square_nonce = sanitize_text_field( rgpost( 'square_nonce' ) );
		if ( rgblank( $square_nonce ) ) {
			return $this->authorization_error( esc_html__( 'Invalid square nonce', 'gravityformssquare' ) );
		}
		// Get main payment information.
		$currency    = $this->get_selected_location_currency();
		$amount      = $this->get_amount_export( $submission_data['payment_amount'], $currency );
		$location_id = $this->get_selected_location_id();
		// Check amount matches minimum required amount according to location's country.
		if ( false === $this->validate_location_amount( $location_id, $amount ) ) {
			return $this->authorization_error( esc_html__( 'Payment amount is smaller than the allowed amount for this business location', 'gravityformssquare' ) );
		}

		// Build payment data array.
		$payment_data = array(
			'idempotency_key' => uniqid(),
			'amount_money'    => array(
				'amount'   => $amount,
				'currency' => $currency,
			),
			'source_id'       => $square_nonce,
			'autocomplete'    => false,
			'location_id'     => $location_id,
			'note'            => 'Gravity Forms - ' . $submission_data['form_title'],
		);

		// Add order information if it exists.
		$this->add_order_information( $feed, $entry, $submission_data, $payment_data );

		// Add verification token if it exists.
		$verification = sanitize_text_field( rgpost( 'square_verification' ) );
		if ( ! empty( $verification ) ) {
			$payment_data['verification_token'] = $verification;
		}

		/**
		 * Filters Square payment data.
		 *
		 * @since 1.0.0
		 *
		 * @param array $payment_data {
		 *      Array that contains payment properties and their values as documented in
		 *      https://developer.squareup.com/reference/square/payments-api/create-payment
		 * }
		 *
		 * @param string $form_id The id of the form currently being processed.
		 * @param array $feed The feed object currently being processed.
		 * @param array $submission_data The customer and transaction data.
		 * @param array $form The form object currently being processed.
		 * @param array $entry The entry object currently being processed.
		 */
		$payment_data = apply_filters( 'gform_square_payment_data', $payment_data, $feed, $submission_data, $form, $entry );

		// Try to create the payment, return error if we could not, this error will result in a validation error.
		$payment = $this->api->create_payment( $payment_data );
		if ( is_wp_error( $payment ) ) {
			$this->log_error( var_export( $this->api->get_last_exception(), true ) );
			return $this->authorization_error( $payment->get_error_message() );
		}

		// Get transaction id from returned payment object.
		$auth = array(
			'is_authorized'  => true,
			'transaction_id' => $payment->getId(),
		);

		return $auth;

	}

	/**
	 * Extracts billing information from entry if it exists.
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $payment_data The payment data array passed by reference.
	 *
	 * @return void
	 */
	public function add_order_information( $feed, $entry, $submission_data, &$payment_data ) {
		// Add billing to payment.
		$billing_info_mapping = array(
			'billing_address:first_name'     => 'first_name',
			'billing_address:last_name'      => 'last_name',
			'billing_address:address_line_1' => 'address_line1',
			'billing_address:address_line_2' => 'address_line2',
			'billing_address:locality'       => 'address_city',
			'billing_address:administrative_district_level_1' => 'address_state',
			'billing_address:postal_code'    => 'address_zip',
			'billing_address:country'        => 'address_country',
			'buyer_email_address'            => 'email',
		);
		foreach ( $billing_info_mapping as $square_field => $feed_key ) {
			$field_key   = rgars( $feed, 'meta/billingInformation_' . $feed_key );
			$field_value = empty( $entry[ $field_key ] ) ? '' : $entry[ $field_key ];
			if ( ! empty( $field_value ) ) {
				if ( $feed_key === 'address_country' ) {
					$field_value = GFCommon::get_country_code( $field_value );
				}
				$keys = explode( ':', $square_field );
				if ( count( $keys ) > 1 ) {
					$payment_data[ $keys[0] ][ $keys[1] ] = $field_value;
				} else {
					$payment_data[ $keys[0] ] = $field_value;
				}
			}
		}

		// Add customer if enough data exist.
		$customer_data                  = array();
		$email_key                      = rgars( $feed, 'meta/billingInformation_email' );
		$customer_data['email_address'] = empty( $entry[ $email_key ] ) ? '' : $entry[ $email_key ];

		$first_name_key              = rgars( $feed, 'meta/billingInformation_first_name' );
		$customer_data['given_name'] = empty( $entry[ $first_name_key ] ) ? '' : $entry[ $first_name_key ];

		$last_name_key                = rgars( $feed, 'meta/billingInformation_last_name' );
		$customer_data['family_name'] = empty( $entry[ $last_name_key ] ) ? '' : $entry[ $last_name_key ];

		// Add Address to customer object if address exists.
		if ( is_array( $payment_data['billing_address'] ) ) {
			$customer_data['address'] = $payment_data['billing_address'];
		}

		$customer_id = null;
		if ( ! empty( $customer_data['email_address'] ) || ! empty( $customer_data['given_name'] ) || ! empty( $customer_data['family_name'] ) ) {
			$customer_data['idempotency_key'] = uniqid();
			$customer_id                      = $this->api->create_customer( $customer_data );
			if ( ! is_wp_error( $customer_id ) ) {
				$payment_data['customer_id'] = $customer_id;
			} else {
				$this->log_error( __METHOD__ . '(): Could not create customer; ' . $customer_id->get_error_message() );
			}
		}

		// Add Order data.
		$selected_location = $this->get_selected_location_id();
		$currency          = $this->api->get_location_currency( $selected_location );
		$line_items        = array();
		foreach ( $submission_data['line_items'] as $line_item ) {
			$line_items[] = array(
				'name'             => $line_item['name'],
				'note'             => $line_item['description'],
				'quantity'         => (string) $line_item['quantity'],
				'base_price_money' => array(
					'amount'   => $this->get_amount_export( $line_item['unit_price'], $currency ),
					'currency' => $currency,
				),
			);
		}

		if ( ! empty( $line_items ) ) {
			$order_data = array(
				'idempotency_key' => uniqid(),
				'order'           => array(
					'location_id' => $selected_location,
					'customer_id' => $customer_id,
					'line_items'  => $line_items,
				),
			);

			if ( is_array( $submission_data['discounts'] ) ) {
				$order_data['order']['discounts'] = array();
				foreach ( $submission_data['discounts'] as $discount ) {
					$order_data['order']['discounts'][] = array(
						'type'         => 'FIXED_AMOUNT',
						'uid'          => uniqid(),
						'name'         => $discount['name'],
						'amount_money' => array(
							'amount'   => $this->get_amount_export( ( $discount['quantity'] * $discount['unit_price'] ) * -1, $currency ),
							'currency' => $currency,
						),
					);
				}
			}

			$order_id = $this->api->create_order( $selected_location, $order_data );
			if ( ! is_wp_error( $order_id ) ) {
				$payment_data['order_id'] = $order_id;
			} else {
				$this->log_error( __METHOD__ . '(): Could not create order; ' . $order_id->get_error_message() );
			}
		}
	}

	/**
	 * Validates an amount is greater than the minimum amount a business location can charge.
	 *
	 * @since 1.0.0
	 *
	 * @param string    $location_id Business Location ID.
	 * @param int|float $amount amount to be validated.
	 *
	 * @return bool
	 */
	public function validate_location_amount( $location_id, $amount ) {
		$country = $this->api->get_location_country( $location_id );

		if ( ( $country === 'US' || $country === 'CA' ) && $amount < 1 ) {
			return false;
		}

		if ( ( $country === 'JP' || $country === 'UK' || $country === 'AU' ) && $amount < 100 ) {
			return false;
		}

		return true;
	}

	/**
	 * Complete the Square payment which was created during validation.
	 *
	 * @since  1.0.0
	 *
	 * @param array $auth Contains the result of the authorize() function.
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array $payment Contains payment details. If failed, shows failure message.
	 */
	public function capture( $auth, $feed, $submission_data, $form, $entry ) {

		try {

			// Update entry mode, location and account ( for entry details square dashboard link ).
			gform_update_meta( $entry['id'], 'square_mode', $this->get_mode() );
			gform_update_meta( $entry['id'], 'square_location', $this->get_selected_location_id() );
			gform_update_meta( $entry['id'], 'square_merchant_id', $this->api->get_merchant_id() );
			gform_update_meta( $entry['id'], 'square_merchant_name', $this->api->get_merchant_name() );

			$capture_method = $this->get_capture_method( $feed, $submission_data, $form, $entry );

			if ( $capture_method === 'manual' ) {
				return array();
			}

			// Capture the charge.
			$payment_completed = $this->api->complete_payment( $auth['transaction_id'] );
			if ( is_wp_error( $payment_completed ) ) {
				// Log that charge could not be captured.
				$this->log_error( __METHOD__ . '(): Unable to capture charge; ' . $payment_completed->get_error_message() );

				// Prepare failed payment details.
				$payment = array(
					'is_success'    => false,
					'error_message' => $payment_completed->get_error_message(),
				);
			} else {
				// Prepare successful payment details.
				$payment_object = $payment_completed->getPayment();
				$payment        = array(
					'is_success'     => true,
					'transaction_id' => $payment_object->getId(),
					'amount'         => $this->get_amount_import( $payment_object->getAmountMoney()->getAmount(), $entry['currency'] ),
					'payment_method' => sanitize_text_field( rgpost( 'square_credit_card_type' ) ),
				);
				// Add Account name to payment note.
				$amount_formatted = GFCommon::to_money( $payment['amount'], $entry['currency'] );
				$payment['note']  = sprintf( esc_html__( 'Payment has been completed. Amount: %1$s. Transaction Id: %2$s. Square Account : %3$s. Business Location: %4$s', 'gravityformssquare' ), $amount_formatted, $payment['transaction_id'], $this->api->get_merchant_name(), $this->get_selected_location_name() );

				// Trigger delayed feeds for other addons like user registration.
				if ( method_exists( $this, 'trigger_payment_de layed_feeds' ) ) {
					$this->trigger_payment_delayed_feeds( $auth['transaction_id'], $feed, $entry, $form );
				}

				// Update order status and note.
				$order_id = $payment_object->getOrderId();
				if ( ! is_null( $order_id ) ) {
					$reference = 'Gravity Forms Entry #' . $entry['id'];
					$this->api->update_order_reference_id( $this->get_selected_location_id(), $order_id, $reference );
				}
			}
		} catch ( Exception $e ) {

			// Log that charge could not be captured.
			$this->log_error( __METHOD__ . '(): Unable to capture charge; ' . $e->getMessage() );

			// Prepare payment details.
			$payment = array(
				'is_success'    => false,
				'error_message' => $e->getMessage(),
			);

		}

		return $payment;
	}

	/**
	 * Get capture method (complete the payment or not) for the payment API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return string
	 */
	public function get_capture_method( $feed, $submission_data, $form, $entry ) {
		/**
		 * Allow authorization only transactions by preventing the capture request from being made after the entry has been saved.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $result Defaults to false, return true to prevent the payment from being captured.
		 * @param array $feed The feed object currently being processed.
		 * @param array $submission_data The customer and transaction data.
		 * @param array $form The form object currently being processed.
		 * @param array $entry The entry object currently being processed.
		 */
		$authorization_only = apply_filters( 'gform_square_authorization_only', false, $feed, $submission_data, $form, $entry );

		if ( $authorization_only ) {
			$this->log_debug( __METHOD__ . '(): The gform_square_authorization_only filter was used to prevent capture.' );

			return 'manual';
		}

		return 'automatic';
	}

	/**
	 * Get square payment object associated with an entry.
	 *
	 * @param array $entry the entry being processed.
	 *
	 * @return bool|SquareConnect\Model\Payment
	 */
	public function get_entry_square_payment( $entry ) {
		// Load entry custom auth data.
		$entry_mode      = gform_get_meta( $entry['id'], 'square_mode' );
		$entry_auth_data = $this->get_auth_data( $entry_mode );
		if ( is_null( $entry_auth_data ) || ! $this->initialize_api( $entry_auth_data, $entry_mode ) ) {
			return false;
		}

		$payment = $this->api->get_payment( $entry['transaction_id'] );
		if ( is_wp_error( $payment ) ) {
			return false;
		}

		return $payment;
	}

	/**
	 * Initialize admin hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_admin() {
		parent::init_admin();
		add_action( 'gform_payment_details', array( $this, 'add_square_payment_details' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'maybe_update_auth_tokens' ), 10, 2 );
	}

	/**
	 * Generates the callback action for entry payment status update.
	 *
	 * @since 1.0.0
	 *
	 * @param array                       $entry The entry object currently being processed.
	 * @param SquareConnect\Model\Payment $payment Square payment object.
	 *
	 * @return void|array callback action.
	 */
	public function get_entry_status_action( $entry, $payment ) {
		$sq_status    = $payment->getStatus();
		$entry_status = $entry['payment_status'];
		$action       = array(
			'type'           => null,
			'transaction_id' => $payment->getId(),
			'entry_id'       => $entry['id'],
		);

		if ( $entry_status == 'Authorized' ) {

			if ( $sq_status == 'COMPLETED' ) {
				$action['type'] = 'complete_payment';
			} elseif ( $sq_status == 'CANCELED' ) {
				$action['type'] = 'void_authorization';
			} elseif ( $sq_status == 'FAILED' ) {
				$action['type'] = 'fail_payment';
			}

			return $action;

		} elseif ( $entry_status == 'Paid' ) {
			// If paid payment, check refund status.
			$pending_refund = false;
			$failed_refund  = false;
			$refund_ids     = $payment->getRefundIds();

			if ( empty( $refund_ids ) ) {
				return $action;
			}

			$refunds = array();
			foreach ( $refund_ids as $refund_id ) {
				$refund = $this->api->get_refund( $refund_id );
				if ( is_wp_error( $refund ) ) {
					continue;
				}
				$status = $refund->getStatus();
				if ( $status == 'PENDING' ) {
					$pending_refund = true;
				} elseif ( $status == 'FAILED' ) {
					$failed_refund = true;
				}
				$refunds[ $refund_id ] = array(
					'id'     => $refund_id,
					'status' => $status,
					'amount' => $refund->getAmountMoney()->getAmount(),
				);
			}

			// Update entry refunds.
			if ( ! empty( $refunds ) ) {
				gform_update_meta( $entry['id'], 'square_refunds', $refunds );
			}

			if ( $pending_refund ) {
				gform_update_meta( $entry['id'], 'refund_status', 'pending' );
				// $action['type'] = 'pending_refund';
			} elseif ( $failed_refund ) {
				gform_update_meta( $entry['id'], 'refund_status', 'failed' );
				// $action['type'] = 'failed_refund';
			} else {
				// If no pending refunds found, check partial and completed refunds.
				$refunded_money = is_null( $payment->getRefundedMoney() ) ? 0 : $payment->getRefundedMoney()->getAmount();
				$payment_amount = $this->get_amount_export( $entry['payment_amount'], $entry['currency'] );
				if ( $refunded_money >= $payment_amount ) {
					$action['type']   = 'refund_payment';
					$action['amount'] = $entry['payment_amount'];
					gform_update_meta( $entry['id'], 'refund_status', 'completed' );
				} elseif ( ! empty( $refunded_money ) && $refunded_money < $payment_amount ) {
					// Mayeb we need custom event for partial refund later.
					$action['type']   = 'refund_payment';
					$action['amount'] = $this->get_amount_import( $refunded_money, $entry['currency'] );
					gform_update_meta( $entry['id'], 'refund_status', 'completed' );
				}
			}
		}

		return $action;
	}

	/**
	 * Add Square dashboard transaction payment link.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $form_id The current form ID.
	 * @param array $entry The current entry being processed.
	 */
	public function add_square_payment_details( $form_id, $entry ) {
		// Check if this is a square payment entry.
		if ( ! $this->is_square_entry( $entry['id'] ) ) {
			return;
		}
		// Make sure this payment is associated with the current authorized account.
		$merchant_name = gform_get_meta( $entry['id'], 'square_merchant_name' );

		// Add dashboard link.
		$entry_mode            = gform_get_meta( $entry['id'], 'square_mode' );
		$dashboard_host        = $entry_mode == 'sandbox' ? 'https://squareupsandbox.com' : 'https://squareup.com';
		$square_dashboard_link = sprintf(
			' <p><a target="_blank" href="%1$s" class="square_dashboard_link">%2$s</a></p>',
			$dashboard_host . '/dashboard/sales/transactions/' . $entry['transaction_id'],
			esc_html__( 'View payment on Square dashboard.', 'gravityformssquare' )
		);

		$square_dashboard_note = '';
		if ( ! empty( $merchant_name ) ) {
			$square_dashboard_note = '<p>' . esc_html__( 'You have to be logged in to the following square account for this link to work: ', 'gravityformssquare' ) . '<strong>' . $merchant_name . '</strong></p>';
		}

		echo $square_dashboard_link . $square_dashboard_note;

		// Display warning if payment is authorized only and not cancelled yet.
		$now        = time();
		$entry_date = strtotime( $entry['date_created'] );
		$datediff   = $now - $entry_date;
		$days       = round( $datediff / ( 60 * 60 * 24 ) );
		if ( $entry['payment_status'] == 'Authorized' && $days < 6 ) {
			echo '<p class="detail-note-content gforms_note_error">' . esc_html__( 'This payment is Authorized only, Authorized payments have a 6 day capture period and will be cancelled automatically after that.', 'gravityformssquare' ) . '</p>';
		}

	}

	/**
	 * Syncs payments refund status with Square.
	 *
	 * @since 1.0.0
	 *
	 * @param string $last_update last time we checked for refund updates.
	 *
	 * @return void
	 */
	public function sync_refunds( $last_update = null ) {
		// Get all authenticated modes.
		$modes = array( 'live', 'sandbox' );
		foreach ( $modes as $mode ) {
			// Check if mode auth data is stored.
			$mode_auth_data = $this->get_auth_data( $mode );
			if ( is_null( $mode_auth_data ) ) {
				continue;
			}

			if ( ! $this->initialize_api( $mode_auth_data, $mode, true ) ) {
				$this->log_error( __METHOD__ . '(): can\'t authenticate ' . $mode . ' mode to update refunds' );
				continue;
			}

			$refunds = $this->api->get_completed_refunds( $last_update );

			if ( is_wp_error( $refunds ) ) {
				$this->log_error( __METHOD__ . '(): unable to get refunds; ' . $refunds->get_error_message() );
				continue;
			}

			foreach ( $refunds as $refund ) {
				$entry_id = $this->get_entry_by_transaction_id( $refund->getPaymentId() );
				$entry    = GFAPI::get_entry( $entry_id );

				// Make sure entry exist and status can be changed to refunded.
				if ( ! is_array( $entry ) || empty( $entry['payment_status'] ) || ! in_array( $entry['payment_status'], array( 'Paid', 'Authorized' ) ) ) {
					continue;
				}
				$refund_amount = $this->get_amount_import( $refund->getAmountMoney()->getAmount(), $entry['currency'] );
				$action        = array(
					'transaction_id' => $refund->getPaymentId(),
					'entry_id'       => $entry['id'],
					'type'           => 'refund_payment',
					'amount'         => $refund_amount,
				);

				$this->refund_payment( $entry, $action );
			}
		}
	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Helpers ---------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Returns the encryption key
	 *
	 * @since 1.0.0
	 *
	 * @return string encryption key.
	 */
	public function get_encryption_key() {
		// Check if key exists in config file.
		if ( defined( 'GRAVITYFORMS_SQUARE_ENCRYPTION_KEY' ) && GRAVITYFORMS_SQUARE_ENCRYPTION_KEY ) {
			return GRAVITYFORMS_SQUARE_ENCRYPTION_KEY;
		}

		// Check if key exists in Database.
		$key = get_option( 'gravityformssquare_key' );

		if ( empty( $key ) ) {
			// Key hasn't been generated yet, generate it and save it.
			$key = wp_generate_password( 64, true, true );
			update_option( 'gravityformssquare_key', $key );
		}

		return $key;
	}

	/**
	 * Checks if we should use sandbox environment.
	 *
	 * @since  1.0.0
	 *
	 * @return bool
	 */
	public function is_sandbox() {
		return $this->get_mode() === 'sandbox';
	}

	/**
	 * Get API mode.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_mode() {
		if ( $this->is_save_postback() ) {
			$mode = sanitize_text_field( rgpost( '_gaddon_setting_mode' ) );
		}

		if ( empty( $mode ) ) {
			$mode = $this->get_plugin_setting( 'mode' );
		}

		return empty( $mode ) ? 'live' : $mode;
	}
	/**
	 * Gets the Gravity Forms Square Application ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string the application id.
	 */
	public function get_application_id() {
		$mode = $this->get_mode();
		if ( $this->get_plugin_setting( 'custom_app_' . $mode ) === '1' ) {
			return $this->get_plugin_setting( 'custom_app_id_' . $mode );
		}
		if ( $this->is_sandbox() ) {
			return defined( 'SQUARE_SANDBOX_APP_ID' ) ? SQUARE_SANDBOX_APP_ID : 'sandbox-sq0idb-pNhEAzS58zAaqOrijuSLxQ';
		}

		return defined( 'SQUARE_APP_ID' ) ? SQUARE_APP_ID : 'sq0idp-6IFu0hb9rVdgZpUBxDF1Ug';
	}

	/**
	 * Gets the selected Square business location ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $custom_mode specify a different mode than the current default mode.
	 * @return string|null Returns the location id or null if no location selected.
	 */
	public function get_selected_location_id( $custom_mode = null ) {
		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		return $this->get_plugin_setting( 'location_' . $mode );
	}

	/**
	 * Gets the selected Square business location Name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $custom_mode specify a different mode than the current default mode.
	 * @return string|null Returns the location name or null if no location selected.
	 */
	public function get_selected_location_name( $custom_mode = null ) {
		$location_id = $this->get_selected_location_id( $custom_mode );
		return $this->api->get_location_name( $location_id );
	}

	/**
	 * Checks if a Square business location was selected.
	 *
	 * @return bool
	 */
	public function square_location_selected() {
		$location_id = $this->get_selected_location_id();

		if ( empty( $location_id ) ) {
			return false;
		}

		$active_locations = $this->api->get_active_locations();
		foreach ( $active_locations as $location ) {
			if ( $location_id === $location['value'] ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Gets the selected business location currency.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|string the currency of selected location or false if no location selected.
	 */
	public function get_selected_location_currency() {
		$location_id = $this->get_selected_location_id();

		if ( empty( $location_id ) || is_null( $this->api ) ) {
			return false;
		}

		return $this->api->get_location_currency( $location_id );
	}

	/**
	 * Checks if stored square business location's currency matches GF currency.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function square_currency_matches_gf() {
		$selected_location = $this->get_selected_location_id();

		if ( empty( $selected_location ) || is_null( $this->api ) ) {
			return false;
		}

		return strtoupper( $this->api->get_location_currency( $selected_location ) ) === strtoupper( GFCommon::get_currency() );
	}

	/**
	 * Get Gravity API URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path Path.
	 *
	 * @return string
	 */
	public function get_gravity_api_url( $path = '' ) {
		return ( defined( 'GRAVITY_API_URL' ) ? GRAVITY_API_URL : 'https://gravityapi.com/wp-json/gravityapi/v1' ) . $path;
	}

	/**
	 * Get Square Auth URL for custom app.
	 *
	 * @since 1.0.0
	 *
	 * @param string $app_id custom app id.
	 * @param string $app_secret custom app secret.
	 *
	 * @return string
	 */
	public function get_square_auth_url( $app_id, $app_secret ) {
		// Get base OAuth URL.
		$auth_url = $this->get_square_host_url() . '/oauth2/authorize';
		$state    = wp_create_nonce( 'gf_square_auth' );
		// Session should be true if in sandbox mode.
		$session = $this->is_sandbox() ? 'true' : 'false';
		// Prepare OAuth URL parameters.
		$auth_params = array(
			'client_id' => $app_id,
			'scope'     => 'MERCHANT_PROFILE_READ+PAYMENTS_READ+PAYMENTS_WRITE+ORDERS_READ+ORDERS_WRITE+CUSTOMERS_READ+CUSTOMERS_WRITE',
			'state'     => $state,
			'session'   => $session,
		);

		// Add parameters to OAuth url.
		$auth_url = add_query_arg( $auth_params, $auth_url );

		return $auth_url;
	}

	/**
	 * Checks if an entry is a square payment entry.
	 *
	 * @since 1.0.0
	 *
	 * @param int $entry_id current entry being processed.
	 *
	 * @return bool
	 */
	public function is_square_entry( $entry_id ) {
		// Check if this is a square payment entry.
		$gateway = gform_get_meta( $entry_id, 'payment_gateway' );
		return $gateway === $this->_slug;
	}

	/**
	 * Retrieves access tokens from gravityapi.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code Authorization code.
	 * @param string $mode live or sandbox.
	 *
	 * @return bool|array
	 */
	public function get_tokens( $code, $mode ) {
		// Get Tokens.
		$get_token_url = $this->get_gravity_api_url( '/auth/square/token' );
		$args          = array(
			'body' => array(
				'code' => $code,
				'mode' => $mode,
			),
		);

		$response = wp_remote_post( $get_token_url, $args );

		// If there was an error, log and return false.
		if ( is_wp_error( $response ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get token; ' . $response->get_error_message() );
			return false;
		}

		// Get response body.
		$response_body = wp_remote_retrieve_body( $response );

		$response_body = json_decode( $response_body, true );
		if ( ! $response_body['success'] ) {
			return false;
		}

		return $response_body['data'];
	}

	/**
	 * Get tokens for custom app.
	 *
	 * @param string $data refresh token or auth code.
	 * @param string $type grant type.
	 * @param null   $custom_mode if we should use a specific mode.
	 *
	 * @return bool|mixed|string
	 */
	public function get_custom_app_tokens( $data, $type = 'authorization_code', $custom_mode = null ) {

		// Get base OAuth URL.
		$auth_url = $this->get_square_host_url() . '/oauth2/token';

		// Prepare OAuth URL parameters.
		$mode        = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		$auth_params = array(
			'client_id'     => $this->get_plugin_setting( 'custom_app_id_' . $mode ),
			'client_secret' => $this->get_plugin_setting( 'custom_app_secret_' . $mode ),
			'grant_type'    => $type,
		);

		if ( 'authorization_code' == $type ) {
			$auth_params['code'] = $data;
		} else {
			$auth_params['refresh_token'] = $data;
		}

		$args     = array( 'body' => $auth_params );
		$response = wp_remote_post( $auth_url, $this->add_square_headers( $args ) );

		// If there was an error, log and return false.
		if ( is_wp_error( $response ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get token; ' . $response->get_error_message() );
			return false;
		}

		// Get response body.
		$response_body = wp_remote_retrieve_body( $response );
		$response_body = json_decode( $response_body, true );

		return $response_body;

	}

	/**
	 * Returns Square host url after checking if sandbox mode is on.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_square_host_url() {
		if ( $this->is_sandbox() ) {
			return 'https://connect.squareupsandbox.com';
		}

		return 'https://connect.squareup.com';
	}

	/**
	 * Checks if we are ready to make square API calls.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function square_api_ready() {
		return $this->initialize_api() && $this->square_currency_matches_gf();
	}

	/**
	 * Adds Square specific headers to API requests that are made without the Square API library.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Request args.
	 *
	 * @return array
	 */
	public function add_square_headers( &$args ) {
		if ( empty( $args['headers'] ) ) {
			$args['headers'] = array();
		}

		$args['headers']['Square-Version'] = '2019-11-20';

		return $args;
	}
}
