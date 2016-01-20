<?php
/**
 * Plugin Name: Reminder
 * Plugin URI: http://reminder.incognitech.in/
 * Description: A WordPress plugin to support Reminder Mobile App
 * Version: 0.1
 * Author: desaiuditd
 * Author URI: http://blog.incognitech.in
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Reminder' ) ) {

	class Reminder {

		/** Singleton *************************************************************/

		/**
		 * @var Reminder The one true Reminder
		 * @since 0.1
		 */
		private static $instance;

		/**
		 * Main Reminder Instance
		 *
		 * Insures that only one instance of Reminder exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 0.1
		 * @static
		 * @static var array $instance
		 * @return Reminder The one true Reminder
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Reminder ) ) {
				self::$instance = new Reminder;
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();
				self::$instance->hooks();
			}
			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 0.1
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', RM_TEXT_DOMAIN ), '1.6' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since 0.1
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', RM_TEXT_DOMAIN ), '1.6' );
		}

		/**
		 * Setup plugin constants
		 *
		 * @access private
		 * @since 0.1
		 * @return void
		 */
		private function setup_constants() {

			// Defines RM_VERSION if it does not exits.
			if ( ! defined( 'RM_VERSION' ) ) {
				define( 'RM_VERSION', '0.1' );
			}

			// Defines RM_TEXT_DOMAIN if it does not exits.
			if ( ! defined( 'RM_TEXT_DOMAIN' ) ) {
				define( 'RM_TEXT_DOMAIN', 'Reminder' );
			}

			// Defines RM_PATH if it does not exits.
			if ( ! defined( 'RM_PATH' ) ) {
				define( 'RM_PATH', plugin_dir_path( __FILE__ ) );
			}

			// Defines RM_URL if it does not exits.
			if ( ! defined( 'RM_URL' ) ) {
				define( 'RM_URL', plugin_dir_url( __FILE__ ) );
			}

			// Defines rM_BASE_PATH if it does not exits.
			if ( ! defined( 'RM_BASE_PATH' ) ) {
				define( 'RM_BASE_PATH', plugin_basename( __FILE__ ) );
			}
		}

		/**
		 * Include required files
		 *
		 * @access private
		 * @since 0.1
		 * @return void
		 */
		private function includes() {
			include_once trailingslashit( RM_PATH ) . 'lib/class-rm-autoload.php';
			new WM_Autoload( trailingslashit( WM_PATH ) . 'revision/' );
			new WM_Autoload( trailingslashit( WM_PATH ) . 'settings/' );

			new WM_Settings();
			new WM_Admin();
			new WM_Revision();
		}

		/**
		 * Loads the plugin language files
		 *
		 * @access public
		 * @since 0.1
		 * @return void
		 */
		public function load_textdomain() {
			// Set filter for plugin's languages directory
			$lang_dir = dirname( plugin_basename( RM_PATH ) ) . '/languages/';
			$lang_dir = apply_filters( 'rm_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale        = apply_filters( 'plugin_locale',  get_locale(), RM_TEXT_DOMAIN );
			$mofile        = sprintf( '%1$s-%2$s.mo', RM_TEXT_DOMAIN, $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/' . RM_TEXT_DOMAIN . '/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/wp_ti folder
				load_textdomain( RM_TEXT_DOMAIN, $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/wp-time-is/languages/ folder
				load_textdomain( RM_TEXT_DOMAIN, $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( RM_TEXT_DOMAIN, false, $lang_dir );
			}
		}

		function hooks() {

		}
	}

}

/**
 * The main function responsible for returning the one true Reminder
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $reminder = Reminder(); ?>
 *
 * @since 1.4
 * @return object The one true Reminder Instance
 */
function reminder() {
	return Reminder::instance();
}

// Get Reminder Running
reminder();

/**
 * Look Maa! A Singleton Class Design Pattern! I'm sure you would be <3 ing design patterns.
 */
