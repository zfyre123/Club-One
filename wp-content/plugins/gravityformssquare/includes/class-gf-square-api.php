<?php
/**
 * Gravity Forms Square API Library Wrapper.
 *
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */

use SquareConnect\Api\LocationsApi;
use SquareConnect\Api\MerchantsApi;
use SquareConnect\ApiClient;
use SquareConnect\ApiException;
use SquareConnect\Configuration;
use SquareConnect\Model\CreatePaymentRequest;
use SquareConnect\Model\GetPaymentResponse;
use SquareConnect\Model\Location;
use SquareConnect\Model\Payment;

/**
 * Square API Library Wrapper Class.
 *
 * Exposes required functionality from the Square API and returns localized WP_Error objects
 * instead of API Exceptions.
 *
 * @since     1.0
 */
class GF_Square_API {

	/**
	 * Square authentication data.
	 *
	 * @since 1.0.0
	 * @var    array $auth_data Square authentication data.
	 */
	protected $auth_data = null;

	/**
	 * Square API client.
	 *
	 * @since 1.0.0
	 * @var ApiClient $api_client Square API client object.
	 */
	protected $api_client = null;

	/**
	 * Business locations.
	 *
	 * @since 1.0.0
	 * @var Location[]
	 */
	protected $locations = null;

	/**
	 * Last API Call Exception.
	 *
	 * @since 1.0.0
	 * @var ApiException
	 */
	protected $last_exception = null;

	/**
	 * Initialize API library.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $auth_data Square authentication data.
	 *
	 * @param string $mode live or sandbox.
	 */
	public function __construct( $auth_data, $mode = 'live' ) {
		$this->auth_data = $auth_data;
		// Create API Client with current supported access token.
		$api_config = new Configuration();
		$api_url    = $mode != 'live' ? 'https://connect.squareupsandbox.com' : 'https://connect.squareup.com';
		$api_config->setHost( $api_url );
		$api_config->setAccessToken( $auth_data['access_token'] );
		$api_client       = new ApiClient( $api_config );
		$this->api_client = $api_client;
	}

	/**
	 * Filters locations for active ones that have credit card processing enabled.
	 *
	 * @since 1.0.0
	 *
	 * @return array active locations that support credit card processing.
	 */
	public function get_active_locations() {
		$locations = array();
		foreach ( $this->locations as $location ) {
			$gf_currency = strtolower( GFCommon::get_currency() );
			if ( $location->getStatus() !== 'ACTIVE' || ! in_array( 'CREDIT_CARD_PROCESSING', $location->getCapabilities() ) || strtolower( $location->getCurrency() ) !== $gf_currency ) {
				continue;
			}

			$locations[] = array(
				'label' => $location->getName(),
				'value' => $location->getId(),
			);

		}

		return $locations;
	}

	/**
	 * Gets the currency of a given business location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location_id Business Location ID.
	 *
	 * @return bool|string
	 */
	public function get_location_currency( $location_id ) {
		foreach ( $this->locations as $location ) {
			if ( $location_id === $location->getId() ) {
				return $location->getCurrency();
			}
		}

		return false;
	}

	/**
	 * Gets the Name of a given business location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location_id Business Location ID.
	 *
	 * @return null|string
	 */
	public function get_location_name( $location_id ) {
		foreach ( $this->locations as $location ) {
			if ( $location_id === $location->getId() ) {
				return $location->getBusinessName();
			}
		}

		return null;
	}

	/**
	 * Gets the country of a given business location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location_id Business Location ID.
	 *
	 * @return bool|string
	 */
	public function get_location_country( $location_id ) {
		foreach ( $this->locations as $location ) {
			if ( $location_id === $location->getId() ) {
				return $location->getAddress()->getCountry();
			}
		}

		return false;
	}

	/**
	 * Retrieves a list of business locations associated with the account.
	 *
	 * This functions is also used to make sure the token is not revoked.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function fetch_locations() {
		// Call the ListLocations endpoint as a test.
		$locations_api = new LocationsApi( $this->api_client );
		try {
			// save locations.
			$this->locations = $locations_api->listLocations()->getLocations();
			return true;
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
		}

		return false;
	}

	/**
	 * Gets a merchant's name
	 *
	 * @since 1.0.0
	 *
	 * @return string|WP_Error
	 */
	public function get_merchant_name() {
		$merchant_api = new MerchantsApi( $this->api_client );
		try {
			$merchant = $merchant_api->retrieveMerchant( $this->get_merchant_id() );

			return $merchant->getMerchant()->getBusinessName();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return $this->get_wp_error( $e );
		}
	}

	/**
	 * Creates a payment on selected Square business location.
	 *
	 * @since 1.0.0
	 *
	 * @param array $payment_data Associated array of property value initializing the payment model.
	 *
	 * @return Payment|WP_Error The payment object or a WP error object.
	 */
	public function create_payment( $payment_data ) {
		// Create payment request object and try to create the payment.
		$payment_request = new CreatePaymentRequest( $payment_data );
		$payment_api     = new SquareConnect\Api\PaymentsApi( $this->api_client );
		try {
			$payment_response = $payment_api->createPayment( $payment_request );
			return $payment_response->getPayment();
		} catch ( SquareConnect\ApiException $e ) {
			$this->last_exception = $e;
			return $this->get_wp_error( $e );
		}
	}

	/**
	 * Completes a payment that was authorized before.
	 *
	 * @since 1.0.0
	 *
	 * @param string $payment_id Payment Object ID.
	 *
	 * @return GetPaymentResponse|WP_Error
	 */
	public function complete_payment( $payment_id ) {
		$payment_api = new SquareConnect\Api\PaymentsApi( $this->api_client );
		try {
			$payment_api->completePayment( $payment_id );
			return $payment_api->getPayment( $payment_id );
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return new WP_Error( $e->getCode(), $e->getMessage(), $e );
		}
	}

	/**
	 * Fetches a Square payment by id
	 *
	 * @since 1.0.0
	 *
	 * @param string $transaction_id The transaction ID.
	 *
	 * @return Payment|WP_Error
	 */
	public function get_payment( $transaction_id ) {

		$payment_api = new SquareConnect\Api\PaymentsApi( $this->api_client );
		try {
			$payment = $payment_api->getPayment( $transaction_id );
			return $payment->getPayment();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return new WP_Error( $e->getCode(), $e->getMessage(), $e );
		}

	}

	/**
	 * Create a refund request for a payment.
	 *
	 * @since 1.0.0
	 *
	 * @param string $transaction_id Payment ID.
	 *
	 * @return Payment|\SquareConnect\Model\PaymentRefund|WP_Error
	 */
	public function create_refund( $transaction_id ) {
		$payment = $this->get_payment( $transaction_id );
		if ( is_wp_error( $payment ) ) {
			return $payment;
		}

		$payment_total  = $payment->getTotalMoney()->getAmount();
		$refunded_money = is_null( $payment->getRefundedMoney() ) ? 0 : $payment->getRefundedMoney()->getAmount();
		$refund_amount  = $payment_total - $refunded_money;
		if ( $refund_amount === 0 ) {
			return new WP_Error( 500, __( 'This payment has already been refunded', 'gravityformssquare' ) );
		}
		$refund_api     = new SquareConnect\Api\RefundsApi( $this->api_client );
		$refund_request = new SquareConnect\Model\RefundPaymentRequest(
			array(
				'idempotency_key' => uniqid(),
				'payment_id'      => $transaction_id,
				'amount_money'    => array(
					'amount'   => $refund_amount,
					'currency' => $payment->getTotalMoney()->getCurrency(),
				),
			)
		);
		try {
			$refund = $refund_api->refundPayment( $refund_request );
			return $refund->getRefund();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return $this->get_wp_error( $e );
		}
	}

	/**
	 * Gets a refund object by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $refund_id Refund ID.
	 *
	 * @return \SquareConnect\Model\PaymentRefund|WP_Error
	 */
	public function get_refund( $refund_id ) {
		$refund_api = new SquareConnect\Api\RefundsApi( $this->api_client );
		try {
			$refund = $refund_api->getPaymentRefund( $refund_id );
			return $refund->getRefund();
		} catch ( ApiException $e ) {
			return new WP_Error( $e->getCode(), $e->getMessage(), $e );
		}
	}

	/**
	 * Gets refund information for a location within a set time period.
	 *
	 * @since 1.0.0
	 *
	 * @param string $begin_time start of time period when refunds were created.
	 * @param string $end_time end of time period when refunds were created.
	 *
	 * @return \SquareConnect\Model\PaymentRefund[]|WP_Error
	 */
	public function get_completed_refunds( $begin_time = null, $end_time = null ) {
		$request_data = array(
			'source_type' => 'CARD',
			'status'      => 'COMPLETED',
		);

		if ( ! is_null( $begin_time ) ) {
			$request_data['begin_time'] = $begin_time;
		}

		if ( ! is_null( $end_time ) ) {
			$request_data['end_time'] = $end_time;
		}

		$list_refunds_request = new SquareConnect\Model\ListPaymentRefundsRequest( $request_data );
		$refunds_api          = new SquareConnect\Api\RefundsApi( $this->api_client );

		try {
			$refunds_list = array();
			// Get first refunds patch.
			$refunds           = $refunds_api->listPaymentRefunds( $list_refunds_request );
			$available_refunds = $refunds->getRefunds();
			if ( ! is_null( $available_refunds ) ) {
				$refunds_list = array_merge( $refunds_list, $available_refunds );
			}
			// Paginate rest of results if it exists.
			while ( $refunds->getCursor() ) {
				$list_refunds_request->setCursor( $refunds->getCursor() );
				$refunds           = $refunds_api->listPaymentRefunds( $list_refunds_request );
				$available_refunds = $refunds->getRefunds();
				if ( ! is_null( $available_refunds ) ) {
					$refunds_list = array_merge( $refunds_list, $available_refunds );
				}
				$refunds_list = array_merge( $refunds_list, $refunds->getRefunds() );
			}
			return $refunds_list;
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return $this->get_wp_error( $e );
		}

	}

	/**
	 * Creates a square customer
	 *
	 * @since 1.0.0
	 *
	 * @param array $customer_data Customer parameters.
	 *
	 * @return string|WP_Error
	 */
	public function create_customer( $customer_data ) {

		$customer_request = new \SquareConnect\Model\CreateCustomerRequest( $customer_data );
		$customer_api     = new SquareConnect\Api\CustomersApi( $this->api_client );

		try {
			$response = $customer_api->createCustomer( $customer_request );
			return $response->getCustomer()->getId();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return $this->get_wp_error( $e );
		}

		return null;
	}

	/**
	 * Creates an Order.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location Order location.
	 * @param array  $order_data Order parameters.
	 *
	 * @return string|WP_Error
	 */
	public function create_order( $location, $order_data ) {
		$order_request = new SquareConnect\Model\CreateOrderRequest( $order_data );
		$order_api     = new SquareConnect\Api\OrdersApi( $this->api_client );
		try {
			$response = $order_api->createOrder( $location, $order_request );
			return $response->getOrder()->getId();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return $this->get_wp_error( $e );
		}

		return null;
	}

	/**
	 * Updates an order's reference ID with entry ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location Order location ID.
	 * @param string $order_id Order ID.
	 * @param string $reference_id Order reference ID.
	 *
	 * @return \SquareConnect\Model\Order
	 */
	public function update_order_reference_id( $location, $order_id, $reference_id ) {
		$update_order_request = new SquareConnect\Model\UpdateOrderRequest(
			array(
				'order' => array(
					'reference_id' => $reference_id,
				),
			)
		);
		$order_api            = new SquareConnect\Api\OrdersApi( $this->api_client );
		try {
			$response = $order_api->updateOrder( $location, $order_id, $update_order_request );
			return $response->getOrder();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
		}
	}

	/**
	 * Gets refresh token from auth data.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null token string or null if it doesn't exit.
	 */
	public function get_refresh_token() {
		return isset( $this->auth_data['refresh_token'] ) ? $this->auth_data['refresh_token'] : null;
	}

	/**
	 * Gets access token from auth data.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null token string or null if it doesn't exit.
	 */
	public function get_access_token() {
		return isset( $this->auth_data['access_token'] ) ? $this->auth_data['access_token'] : null;
	}

	/**
	 * Gets authorized merchant's ID from aut data.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null merchant's ID string or null if it doesn't exit.
	 */
	public function get_merchant_id() {

		if ( isset( $this->auth_data['merchant_id'] ) ) {
			return $this->auth_data['merchant_id'];
		}

		// Only for sandbox.
		$merchant_api = new SquareConnect\Api\MerchantsApi( $this->api_client );

		try {
			$merchant_response = $merchant_api->listMerchants( 0 );
			$merchant          = $merchant_response->getMerchant();

			return $merchant[0]->getId();
		} catch ( ApiException $e ) {
			$this->last_exception = $e;
			return null;
		}
	}

	/**
	 * Converts an API exception to wp_error object.
	 *
	 * @since 1.0.0
	 *
	 * @param ApiException $e Square API exception object.
	 *
	 * @return WP_Error
	 */
	public function get_wp_error( ApiException $e ) {
		$errors = $e->getResponseBody()->errors;
		if ( ! is_array( $errors ) ) {
			$message = $this->get_error_code_message( '' );
		} else {
			$message = $this->get_error_code_message( $errors[0]->code );
		}

		return new WP_Error( $e->getCode(), $message, $e );
	}

	/**
	 * Translates an error code to a localized message.
	 *
	 * @param string $code Square API error code string.
	 *
	 * @return string the localized message or the original code if no message found for it.
	 */
	public function get_error_code_message( $code ) {
		$messages = array(
			'CARD_EXPIRED'                           => esc_html__( 'The card issuer declined the request because the card is expired.', 'gravityformssquare' ),
			'PAN_FAILURE'                            => esc_html__( 'Invalid credit card number.', 'gravityformssquare' ),
			'INSUFFICIENT_FUNDS'                     => esc_html__( 'Card has insufficient funds.', 'gravityformssquare' ),
			'CVV_FAILURE'                            => esc_html__( 'Invalid CVV.', 'gravityformssquare' ),
			'INVALID_POSTAL_CODE'                    => esc_html__( 'Invalid Postal Code.', 'gravityformssquare' ),
			'INVALID_EXPIRATION'                     => esc_html__( 'The card expiration date is either missing or incorrectly formatted.', 'gravityformssquare' ),
			'INVALID_EXPIRATION_YEAR'                => esc_html__( 'The expiration year for the payment card is invalid.', 'gravityformssquare' ),
			'INVALID_EXPIRATION_DATE'                => esc_html__( 'The expiration date for the payment card is invalid.', 'gravityformssquare' ),
			'BAD_EXPIRATION'                         => esc_html__( 'The card expiration date is either missing or incorrectly formatted.', 'gravityformssquare' ),
			'CARD_NOT_SUPPORTED'                     => esc_html__( 'The card is not supported in the merchant\'s geographic region.', 'gravityformssquare' ),
			'UNSUPPORTED_CARD_BRAND'                 => esc_html__( 'The credit card provided is not from a supported issuer.', 'gravityformssquare' ),
			'UNSUPPORTED_ENTRY_METHOD'               => esc_html__( 'The entry method for the credit card (swipe, dip, tap) is not supported.', 'gravityformssquare' ),
			'CHIP_INSERTION_REQUIRED'                => esc_html__( 'The card issuer requires that the card be read using a chip reader.', 'gravityformssquare' ),
			'INVALID_ENCRYPTED_CARD'                 => esc_html__( 'The encrypted card information is invalid.', 'gravityformssquare' ),
			'INVALID_CARD'                           => esc_html__( 'The credit card cannot be validated based on the provided details.', 'gravityformssquare' ),
			'EXPIRATION_FAILURE'                     => esc_html__( 'The card expiration date is either invalid or indicates that the card is expired.', 'gravityformssquare' ),
			'GENERIC_DECLINE'                        => esc_html__( 'The credit card was decline by the issuer for an unspecified reason.', 'gravityformssquare' ),
			'INVALID_ACCOUNT'                        => esc_html__( 'The credit card was decline by the issuer for an unspecified reason.', 'gravityformssquare' ),
			'INVALID_ENUM_VALUE'                     => esc_html__( 'Required Data is missing.', 'gravityformssquare' ),
			'VALUE_EMPTY'                            => esc_html__( 'Required Data is missing.', 'gravityformssquare' ),
			'VALUE_TOO_HIGH'                         => esc_html__( 'Payment amount is greater than the account supported maximum.', 'gravityformssquare' ),
			'VALUE_TOO_LOW'                          => esc_html__( 'Payment amount is less than the account supported minimum.', 'gravityformssquare' ),
			'ADDRESS_VERIFICATION_FAILURE'           => esc_html__( 'The card issuer declined the request because the postal code is invalid.', 'gravityformssquare' ),
			'CURRENCY_MISMATCH'                      => esc_html__( 'The currency associated with the payment is not valid for the provided funding source.', 'gravityformssquare' ),
			'CARDHOLDER_INSUFFICIENT_PERMISSIONS'    => esc_html__( 'The funding source associated with the payment has limitations on how it can be used. For example, it is only valid for specific merchants or transaction types.', 'gravityformssquare' ),
			'INVALID_LOCATION'                       => esc_html__( 'Payments in this region is not allowed.', 'gravityformssquare' ),
			'TRANSACTION_LIMIT'                      => esc_html__( 'The payment amount violates an associated transaction limit.', 'gravityformssquare' ),
			'VOICE_FAILURE'                          => esc_html__( 'The transaction was declined because the card issuer requires voice authorization from the cardholder.', 'gravityformssquare' ),
			'INVALID_PIN'                            => esc_html__( 'The card issuer declined the request because the PIN is invalid.', 'gravityformssquare' ),
			'MANUALLY_ENTERED_PAYMENT_NOT_SUPPORTED' => esc_html__( 'The payment was declined because manually keying-in the card information is disallowed. The card must be swiped, tapped, or dipped.', 'gravityformssquare' ),
			'AMOUNT_TOO_HIGH'                        => esc_html__( 'The requested payment amount is too high for the provided payment source.', 'gravityformssquare' ),
			'INVALID_CARD_DATA'                      => esc_html__( 'The provided card data is invalid.', 'gravityformssquare' ),
			'INVALID_EMAIL_ADDRESS'                  => esc_html__( 'The provided email address is invalid.', 'gravityformssquare' ),
			'INVALID_PHONE_NUMBER'                   => esc_html__( 'The provided phone number is invalid.', 'gravityformssquare' ),
			'CARD_DECLINED'                          => esc_html__( 'The card was declined.', 'gravityformssquare' ),
			'VERIFY_CVV_FAILURE'                     => esc_html__( 'The CVV could not be verified.', 'gravityformssquare' ),
			'VERIFY_AVS_FAILURE'                     => esc_html__( 'The AVS could not be verified.', 'gravityformssquare' ),
			'CARD_DECLINED_CALL_ISSUER'              => esc_html__( 'The payment card was declined with a request for the card holder to call the issuer.', 'gravityformssquare' ),
			'CARD_DECLINED_VERIFICATION_REQUIRED'    => esc_html__( 'The payment card was declined with a request for additional verification.', 'gravityformssquare' ),
			'ALLOWABLE_PIN_TRIES_EXCEEDED'           => esc_html__( 'The card has exhausted its available pin entry retries set by the card issuer. Resolving the error typically requires the card holder to contact the card issuer.', 'gravityformssquare' ),
			'REFUND_AMOUNT_INVALID'                  => esc_html__( 'The requested refund amount exceeds the amount available to refund.', 'gravityformssquare' ),
			'REFUND_ALREADY_PENDING'                 => esc_html__( 'The payment already has a pending refund.', 'gravityformssquare' ),
			'PAYMENT_NOT_REFUNDABLE'                 => esc_html__( 'The payment is not refundable. For example, a previous refund has already been rejected and no new refunds can be accepted.', 'gravityformssquare' ),
			'RESERVATION_DECLINED'                   => esc_html__( 'The card issuer declined the refund..', 'gravityformssquare' ),

		);

		if ( array_key_exists( $code, $messages ) ) {
			return $messages[ $code ];
		} else {
			return esc_html__( 'An error occurred while processing your request.', 'gravityformssquare' );
		}
	}

	/**
	 * Gets last API call exception if it exists.
	 *
	 * @Since 1.0.0
	 *
	 * @return ApiException
	 */
	public function get_last_exception() {
		return $this->last_exception;
	}
}
