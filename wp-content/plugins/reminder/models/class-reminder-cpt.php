<?php
/**
 * Created by PhpStorm.
 * User: udit
 * Date: 20/01/16
 * Time: 00:03
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Reminder_CPT' ) ) {


	class Reminder_CPT {
		function __construct() {
			add_action( 'init', array( $this, 'register_cpt' ) );
		}

		function register_cpt() {

			$labels = array(
				'name'                  => _x( 'Reminders', 'Post Type General Name', RM_TEXT_DOMAIN ),
				'singular_name'         => _x( 'Reminder', 'Post Type Singular Name', RM_TEXT_DOMAIN ),
				'menu_name'             => __( 'Reminders', RM_TEXT_DOMAIN ),
				'name_admin_bar'        => __( 'Reminders', RM_TEXT_DOMAIN ),
				'archives'              => __( 'Reminder Archives', RM_TEXT_DOMAIN ),
				'parent_item_colon'     => __( 'Parent Reminder:', RM_TEXT_DOMAIN ),
				'all_items'             => __( 'All Reminders', RM_TEXT_DOMAIN ),
				'add_new_item'          => __( 'Add New Reminder', RM_TEXT_DOMAIN ),
				'add_new'               => __( 'Add New', RM_TEXT_DOMAIN ),
				'new_item'              => __( 'New Reminder', RM_TEXT_DOMAIN ),
				'edit_item'             => __( 'Edit Reminder', RM_TEXT_DOMAIN ),
				'update_item'           => __( 'Update Reminder', RM_TEXT_DOMAIN ),
				'view_item'             => __( 'View Reminder', RM_TEXT_DOMAIN ),
				'search_items'          => __( 'Search Reminder', RM_TEXT_DOMAIN ),
				'not_found'             => __( 'Not found', RM_TEXT_DOMAIN ),
				'not_found_in_trash'    => __( 'Not found in Trash', RM_TEXT_DOMAIN ),
				'featured_image'        => __( 'Featured Image', RM_TEXT_DOMAIN ),
				'set_featured_image'    => __( 'Set featured image', RM_TEXT_DOMAIN ),
				'remove_featured_image' => __( 'Remove featured image', RM_TEXT_DOMAIN ),
				'use_featured_image'    => __( 'Use as featured image', RM_TEXT_DOMAIN ),
				'insert_into_item'      => __( 'Insert into reminder', RM_TEXT_DOMAIN ),
				'uploaded_to_this_item' => __( 'Uploaded to this reminder', RM_TEXT_DOMAIN ),
				'items_list'            => __( 'Reminders list', RM_TEXT_DOMAIN ),
				'items_list_navigation' => __( 'Reminders list navigation', RM_TEXT_DOMAIN ),
				'filter_items_list'     => __( 'Filter reminders list', RM_TEXT_DOMAIN ),
			);
			$args = array(
				'label'                 => __( 'Reminder', RM_TEXT_DOMAIN ),
				'description'           => __( 'Reminders for people', RM_TEXT_DOMAIN ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'author', 'custom-fields' ),
				'hierarchical'          => false,
				'public'                => false,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 25,
				'menu_icon'             => 'dashicons-clock',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => false,
				'exclude_from_search'   => true,
				'publicly_queryable'    => false,
			);
			register_post_type( 'reminder', $args );

		}
	}
}
