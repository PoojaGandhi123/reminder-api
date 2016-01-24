<?php
/**
 * Created by PhpStorm.
 * User: udit
 * Date: 23/01/16
 * Time: 19:04
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RM_User' ) ) {

	class RM_User {

		function __construct() {
			// Add extra contact detail
			add_filter( 'user_contactmethods', array( $this, 'filter_extra_contact_details' ) );
			// Add extra contact detail on new user page
			add_action( 'user_new_form', array( $this, 'add_extra_contact_details_markup' ) );
			// Check for custom contact details
			add_action( 'user_profile_update_errors', array( $this, 'check_extra_contact_details' ), 10, 3 );
			// Add Mobile Number Column
			add_filter( 'manage_users_columns', array( $this, 'add_contact_column' ) );
			// Manage Contact Column
			add_action( 'manage_users_custom_column', array( $this, 'manage_contact_column' ), 10, 3 );
		}

		function filter_extra_contact_details( $methods, $user ) {
			$methods['mobile_number'] = __( 'Mobile Number', RM_TEXT_DOMAIN );
			return $methods;
		}

		function add_extra_contact_details_markup( $context ) {
			?>
			<table class="form-table">
				<tr class="form-field form-required">
					<th scope="row"><label for="mobile_number"><?php _e( 'Mobile Number', RM_TEXT_DOMAIN ); ?> <span class="description"><?php _e( '(required)', RM_TEXT_DOMAIN ); ?></span></label></th>
					<td><input name="mobile_number" type="text" id="mobile_number" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" /></td>
				</tr>
			</table>
			<?php
		}

		function check_extra_contact_details( $errors, $update, $user ) {
			if ( empty( $user->mobile_number ) ) {
				$errors->add( 'mobile_number', sprintf( '<strong>%s</strong>: %s.', __( 'ERROR', RM_TEXT_DOMAIN ), __( 'Please enter mobile number', RM_TEXT_DOMAIN ) ) );
			} elseif ( ! preg_match( '/[2-9][2-9][0-9]{8}/', $user->mobile_number ) ) {
				$errors->add( 'mobile_number', sprintf( '<strong>%s</strong>: %s.', __( 'ERROR', RM_TEXT_DOMAIN ), __( 'Please enter a 10 digit valid mobile number.', RM_TEXT_DOMAIN ) ) );
			} elseif ( ( $owner_id = $this->mobile_number_exists( $user->mobile_number ) ) && ( ! $update || ( $owner_id != $user->ID ) ) ) {
				$errors->add( 'mobile_number_exists', sprintf( '<strong>%s</strong>: %s.', __( 'ERROR', RM_TEXT_DOMAIN ), __( 'This mobile number is already registered, please choose another one', RM_TEXT_DOMAIN ) ), array( 'form-field' => 'mobile_number' ) );
			}
		}

		function add_contact_column( $columns ) {
			$columns['mobile_number'] = __( 'Mobile Number', RM_TEXT_DOMAIN );
			return $columns;
		}

		function manage_contact_column( $value, $column_name, $user_id ) {
			if ( 'mobile_number' === $column_name ) {
				$value = get_user_meta( $user_id, 'mobile_number', true );
			}
			return $value;
		}

		function mobile_number_exists( $mobile_number ) {
			$users = get_users(
				array(
					'meta_key' => 'mobile_number',
					'meta_value' => $mobile_number,
				)
			);

			if ( count( $users ) >= 1 ) {
				return $users[0]->ID;
			}

			return false;
		}
	}

}