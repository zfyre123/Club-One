<?php
/**
 * Wp_Engine_Abstraction
 *
 * @package wpengine/common-mu-plugin
 */

namespace wpe\plugin;

/**
 * Class Wp_Engine_Abstraction
 */
class Wp_Engine_Abstraction {

	/**
	 * Cluster Type
	 *
	 * @return string Type of cluster
	 */
	public function cluster_type() : string {
		return ( defined( 'WPE_CLUSTER_TYPE' ) && WPE_CLUSTER_TYPE ) ? WPE_CLUSTER_TYPE : '';
	}
}
