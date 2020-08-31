<?php
/**
 * Wp_Abstraction
 *
 * @package wpengine/common-mu-plugin
 */

namespace wpe\plugin;

/**
 * Class Wp_Abstraction
 */
class Wp_Abstraction {
	/**
	 * WordPress's get_site_url()
	 *
	 * Documentation: https://developer.wordpress.org/reference/functions/get_site_url/
	 *
	 * @return string Url of the site.
	 */
	public function get_site_url() {
		return \get_site_url();
	}

	/**
	 * WordPress's wp_create_nonce()
	 *
	 * Documentation: https://developer.wordpress.org/reference/functions/wp_create_nonce/
	 *
	 * @param int|string $action Description of the nonce.
	 * @return string Some nonce.
	 */
	public function wp_create_nonce( $action ) {
		return \wp_create_nonce( $action );
	}

	/**
	 * WordPress's wp_remote_request()
	 *
	 * Documentation: https://developer.wordpress.org/reference/functions/wp_remote_request/
	 *
	 * @param string $url Some url.
	 * @return \Wp_Error|array Response as an array or Wp_Error if request failed.
	 */
	public function wp_remote_request( $url ) {
		return \wp_remote_request( $url );
	}

	/**
	 * WordPress's is_wp_error()
	 *
	 * Documentation: https://developer.wordpress.org/reference/functions/is_wp_error/
	 *
	 * @param mixed $object Some object to check.
	 * @return bool True if object is of instance type \Wp_Error.
	 */
	public function is_wp_error( $object ) {
		return \is_wp_error( $object );
	}
}
