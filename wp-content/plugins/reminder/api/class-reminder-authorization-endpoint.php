<?php
/**
 * Created by PhpStorm.
 * User: udit
 * Date: 23/01/16
 * Time: 17:05
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Reminder_Authorization_Endpoint' ) ) {


	class Reminder_Authorization_Endpoint {

		function __construct() {
			add_action( 'rest_api_init', array( $this, 'register_endpoint' ) );
		}

		function register_endpoint() {
			register_rest_route( 'reminder/v1', 'get-cookie-nonce', array(
				'methods' => 'GET',
				'callback' => array( $this, 'get_cookie_nonce' ),
			) );
		}

		function get_cookie_nonce( $data ) {
			$nonce = wp_create_nonce( 'wp_rest' );

			return new WP_REST_Response( array( 'nonce' => $nonce ) );
		}
	}

}
