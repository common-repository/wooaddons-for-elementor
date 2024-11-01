<?php
/**
 * @link              http://wpthemespace.com
 * @since             1.1.0
 * @package           Wooaddons For Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       Wooaddons For Elementor
 * Plugin URI:        
 * Description:       Awesome Elementor page builder addons for woocommerce 
 * Version:           1.0.0
 * Author:            elementpress
 * Author URI:        https://profiles.wordpress.org/nalam-1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wooaddons-for-elementor
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'WOOADDONS_URL', plugin_dir_url( __FILE__ ) );
define( 'WOOADDONS_PATH', plugin_dir_path( __FILE__ ) );

//include file


/**
 * Main Wooaddons For Elementor Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class wooAddons_For_Elementor {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.6.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'wooaddons-for-elementor' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		// Check if woocommerce3 installed and activated
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_woo_plugin' ] );
			return;
		}
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_new_category' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_widget_styles' ] );
		add_action( "elementor/frontend/after_enqueue_scripts", [ $this, 'frontend_assets_scripts' ] );
	}

		public function register_new_category($manager){
		$manager->add_category('productwoo',[
			'title' => esc_html__('Woo Addons','wooaddons-for-elementor'),
			'icon' => 'fa fa-magic',
		]);
	}

	/*
	plugin css
	*/
	function frontend_widget_styles(){
		wp_enqueue_style( 'bootstrap',  plugins_url( '/assets/css/bootstrap.min.css', __FILE__ ), array(), '4.3.1', 'all');


//image hover card
		wp_enqueue_style( 'wooaddons-hover-card',  plugins_url( '/assets/css/imagehover.min.css', __FILE__ ), array(), '1.0', 'all');


//main style
		wp_enqueue_style( 'wooaddons-style',  plugins_url( '/assets/css/wooaddons-style.css', __FILE__ ), array(), time(), 'all');
		

	}
	/*
	plugin js
	*/
	function frontend_assets_scripts(){
		wp_enqueue_script("bootstrap-js",plugins_url("/assets/js/bootstrap.min.js",__FILE__),array('jquery'),'4.3.1',true);
		wp_enqueue_script("flipclock-js",plugins_url("/assets/js/flipclock.min.js",__FILE__),array('jquery'),'1.0',true);

		/*//accordion style
		wp_enqueue_script("jquery.beefup-js",plugins_url("/assets/widget-assets/accordion/jquery.beefup.min.js",__FILE__),array('jquery'),'1.0',true);
		wp_enqueue_script("mg-accordion-js",plugins_url("/assets/js/accordion/mg-accordion.js",__FILE__),array('jquery'),'1.0',true);*/
//Timeline script 
		/*wp_enqueue_script("mg-timeline-js", plugins_url( '/assets/widget-assets/timeline/timeline.min.js', __FILE__ ), array(), '1.0',true);
		wp_enqueue_script("mg-timeline-active", plugins_url( '/assets/widget-assets/timeline/timeline-active.js', __FILE__ ), array(), '1.0',true);*/


		wp_enqueue_script("wooaddons-script-js",plugins_url("/assets/js/main-scripts.js",__FILE__),array('jquery'),time(),true);
	}
	

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		
		if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
				$magial_eactive_url = wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php' );
					$message = sprintf(
			        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
			        esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'wooaddons-for-elementor' ),
			        '<strong>' . esc_html__( 'Wooaddons For Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			        '<strong>' . esc_html__( 'Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			        '<a class="button button-primary" style="margin-left:20px" href="'.$magial_eactive_url.'">' . __( 'Activate Elementor', 'wooaddons-for-elementor' ) . '</a>'

			    );

			} else {

				$magial_einstall_url =  wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
					$message = sprintf(
			        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
			        esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'wooaddons-for-elementor' ),
			        '<strong>' . esc_html__( 'Wooaddons For Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			        '<strong>' . esc_html__( 'Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			        '<a class="button button-primary" style="margin-left:20px" href="'.$magial_einstall_url.'">' . __( 'Install Elementor', 'wooaddons-for-elementor' ) . '</a>'

			    );
			
			}



    printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have WooCommerce installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_woo_plugin() {
				
		if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
				$magial_eactive_url = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
					$message = sprintf(
			        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
			        esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'wooaddons-for-elementor' ),
			        '<strong>' . esc_html__( 'Wooaddons For Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			        '<strong>' . esc_html__( 'woocommerce', 'wooaddons-for-elementor' ) . '</strong>',
			        '<a class="button button-primary" style="margin-left:20px" href="'.$magial_eactive_url.'">' . __( 'Activate WooCommerce', 'wooaddons-for-elementor' ) . '</a>'

			    );

			}else{

				$magial_einstall_url =  wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
					$message = sprintf(
			        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
			        esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'wooaddons-for-elementor' ),
			        '<strong>' . esc_html__( 'Wooaddons For Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			        '<strong>' . esc_html__( 'woocommerce', 'wooaddons-for-elementor' ) . '</strong>',
			        '<a class="button button-primary" style="margin-left:20px" href="'.$magial_einstall_url.'">' . __( 'Install woocommerce', 'wooaddons-for-elementor' ) . '</a>'

			    );
			
			}



    printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wooaddons-for-elementor' ),
			'<strong>' . esc_html__( 'Wooaddons For Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wooaddons-for-elementor' ),
			'<strong>' . esc_html__( 'Wooaddons For Elementor', 'wooaddons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'wooaddons-for-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// include file
		 require_once( __DIR__ . '/includes/functions.php' );
		 require_once( __DIR__ . '/includes/widgets/products-grid.php' );

		




		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \wooaddons_Product_Widget() );
		

	}

}

wooAddons_For_Elementor::instance();