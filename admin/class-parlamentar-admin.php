<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://zulian.org
 * @since      1.0.0
 *
 * @package    Parlamentar
 * @subpackage Parlamentar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Parlamentar
 * @subpackage Parlamentar/admin
 * @author     Eduardo Zulian <ola@zulian.org>
 */
class Parlamentar_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Parlamentar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Parlamentar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/parlamentar-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Parlamentar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Parlamentar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/parlamentar-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create the post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public function register_post_type() {
	
		$args = array (
			'label' => __( 'Parlamentar','fluxo' ),
			'labels' => $labels,
			'description' => __( 'Parlamentar','fluxo' ),
			'public' => true,
			'publicly_queryable' => true, // public
			//'exclude_from_search' => '', // public
			'show_ui' => true, // public
			'show_in_menu' => true,
			'menu_position' => 5,
			// 'menu_icon' => '',
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => false,
			'supports' => array('title', 'editor', 'author', 'excerpt', 'trackbacks','thumbnail', 'revisions', 'comments'),
			//'register_meta_box_cb' => array($this, 'fluxo_emrede_custom_meta'),
			//'taxonomies' => array('post_tag','category'),
			'permalink_epmask' => 'EP_PERMALINK ',
			'has_archive' => true,
			'rewrite' => true,
			'query_var' => true,
			'can_export' => true
			//'show_in_nav_menus' => '', // public
			//'_builtin' => '', // Core
			//'_edit_link' => '' // Core
		);
	
		register_post_type( 'parlamentar', $args );

	}

	/**
	 * Create a new taxonomy for the custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public function register_taxonomy() {

		$tax_name = 'parlamentar_type';

		$args = array (
			'hierarchical' => true,
			'label' => __( 'Type' ),
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => true,
		);

		register_taxonomy( $tax_name, 'parlamentar', $args );

	}

	/**
	 * Create a meta box area
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_meta_box() {
		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
		add_meta_box(
			'parlamentar_information',
			apply_filters( 'parlamentar-information-title', __( 'Information', 'parlamentar' ) ),
			array( $this, 'callback_meta_box_parlamentar_information' ),
			'parlamentar',
			'normal',
			'default'
		);
	} 

	/**
	 * [callback_metabox_job_location description]
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return [type] [description]
	 */
	public function callback_meta_box_parlamentar_information( $object, $box ) {
		include( plugin_dir_path( __FILE__ ) . 'partials/parlamentar-meta-box-view.php' );
	} 

}
