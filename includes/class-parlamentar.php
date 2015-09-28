<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://zulian.org
 * @since      1.0.0
 *
 * @package    Parlamentar
 * @subpackage Parlamentar/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Parlamentar
 * @subpackage Parlamentar/includes
 * @author     Eduardo Zulian <ola@zulian.org>
 */
class Parlamentar {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Parlamentar_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The fields that will be used
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $version    The array of data
	 */
	public $fields;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'parlamentar';
		$this->version = '1.0.0';

		$this->fields_prefix = '_parlamentar-info-';
		$this->fields = array(
			'Nome completo' => array(
				'slug' => 'full-name',
				'title' => __( 'Nome completo', 'parlamentar' ),
				'tip' => __( '', 'parlamentar' ),
				'type' => '',
			),
			'Data de nascimento' => array(
				'slug' => 'birthday',
				'title' => __( 'Data de nascimento', 'parlamentar' ),
				'tip' => __( '', 'parlamentar' ),
				'type' => 'date',
			),
			'Naturalidade' => array(
				'slug' => 'birthplace',
				'title' => __( 'Naturalidade', 'parlamentar' ),
				'tip' => __( '', 'parlamentar' ),
				'type' => '',
			),
			'Estado civil' => array(
				'slug' => 'marital-status',
				'title' => __( 'Estado civil', 'parlamentar' ),
				'tip' => __( '', 'parlamentar' ),
				'type' => '',
			),
			'Ocupação' => array(
				'slug' => 'occupation',
				'title' => __( 'Ocupação', 'parlamentar' ),
				'type' => '',
			),
			'Escolaridade' => array(
				'slug' => 'education',
				'title' => __( 'Escolaridade', 'parlamentar' ),
				'type' => '',
			),
			'Link para prestação de contas do mandato' => array(
				'slug' => 'political-accountability',
				'title' => __( 'Link para prestação de contas do mandato', 'parlamentar' ),
				'type' => 'url',
			),
			'Link para prestação de contas ao TRE' => array(
				'slug' => 'accountability',
				'title' => __( 'Link para prestação de contas ao TRE', 'parlamentar' ),
				'type' => 'url',
			),
			'Equipe do mandato' => array(
				'slug' => 'term-cabinet',
				'title' => __( 'Equipe do mandato', 'parlamentar' ),
				'type' => 'wp_editor',
			),
			'Endereço' => array(
				'slug' => 'address',
				'title' => __( 'Endereço', 'parlamentar' ),
				'type' => '',
			),
			'Telephone' => array(
				'slug' => 'telephone',
				'title' => __( 'Telephone', 'parlamentar' ),
				'type' => '',
			),
			'Email' => array(
				'slug' => 'email',
				'title' => __( 'Email', 'parlamentar' ),
				'type' => 'email',
			),
			'Facebook' => array(
				'slug' => 'facebook',
				'title' => __( 'Facebook', 'parlamentar' ),
				'type' => 'url',
			),
			'Twitter' => array(
				'slug' => 'twitter',
				'title' => __( 'Twitter', 'parlamentar' ),
				'type' => 'url',
			),
			'Wikipedia' => array(
				'slug' => 'wikipedia',
				'title' => __( 'Wikipedia', 'parlamentar' ),
				'type' => 'url',
			),
			'Website' => array(
				'slug' => 'website',
				'title' => __( 'Website', 'parlamentar' ),
				'type' => 'url',
			),

		);

		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) ) ;

		/* Admin hooks */

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		add_action( 'after_setup_theme', array( $this, 'add_image_sizes' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

		/* Public hooks */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		//add_filter( 'template_include', array( $this, 'include_single_template' ) );
		add_filter( 'archive_template', array( $this, 'include_archive_template' ) );

		add_filter( 'the_content', array( $this, 'add_parlamentar_info_to_content' ) );

	}

	/**
	 * Define the internationalization functionality
	 *
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @link       http://zulian.org
	 * @since      1.0.0
	 *
	 * @package    Parlamentar
	 */
	 function load_plugin_textdomain() {

		load_plugin_textdomain(
			$this->plugin_name,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Create the post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public function register_post_type() {
	
		$args = array(
			'label' => __( 'Parlamentar','fluxo' ),
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
			'supports' => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'revisions' ),
			//'register_meta_box_cb' => array($this, 'fluxo_emrede_custom_meta' ),
			//'taxonomies' => array('post_tag','category' ),
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

		$args = array(
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
	 * @param 	object 		$object 		The post object
	 */
	public function callback_meta_box_parlamentar_information( $object, $box ) {

		$value = '';

		wp_nonce_field( $this->plugin_name, $this->plugin_name . '_nonce' );

		if ( ! empty( $meta['parlamentar-type'][0] ) ) {
			$value = $meta['parlamentar-type'][0];
		}

		foreach ( $this->fields as $key => $info ) : ?>

			<?php
				$slug = $this->fields_prefix . $info['slug'];
			    $value =  get_post_meta( $object->ID, $slug, true );
			?>
			<p>
				<label for="<?php echo $slug; ?>"><?php echo $info['title']; ?></label>
				<?php if ( $info['type'] == 'wp_editor' ) : ?>
					<?php
						wp_editor(
							$value,
							$slug,
							array(
								'media_buttons' => false,
								'quicktags'		=> false,
								'teeny'			=> true
							)
						);
					?>
				<?php else : ?>
					<input class="widefat" type="text" name="<?php echo $slug; ?>" id="<?php echo $slug; ?>" value="<?php echo esc_attr( $value ); ?>" />
				<?php endif; ?>
			</p>

		<?php
		endforeach;
	}

	/**
	 * Save metabox data
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	int 		$post_id 		The post ID
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	public function save_post( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		$nonce = $_POST['parlamentar_nonce'];
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['parlamentar_nonce'] ) ) {
			return $post_id;
		}
		
		// Verify that the nonce is valid
		if ( ! wp_verify_nonce( $nonce, $this->plugin_name ) ) {
			return $post_id;
		}
		
		// The form is not submitted yet
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
		// Check the user's permissions
		if ( 'parlamentar' !== $_POST['post_type'] ) {
				return $post_id;
		}
	
		// Save the data
		foreach ( $this->fields as $key => $field ) {
			$slug = $this->fields_prefix . $field['slug'];

			$old = get_post_meta( $post_id, $slug, true );

			if ( $field['type'] == 'email' ) {
				$new = sanitize_email( $_POST[$slug] );
			}
			elseif ( $field['type'] == 'url') {
				$new = esc_url_raw( $_POST[$slug] );
			}
			elseif ( $field['type'] == 'wp_editor') {
				$new = $_POST[$slug];
			}
			else {
				$new = sanitize_text_field( $_POST[$slug] );
			}

			if ( $new && $new != $old ) {
			    update_post_meta( $post_id, $slug, $new );  
			}
			elseif ( '' == $new && $old ) {
				delete_post_meta( $post_id, $slug, $old );  
			}
		}

	}

	/**
	 * Add custom image sizes
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_image_sizes() {
		add_image_size( 'parlamentar-archive', 250, 250, true );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname( __FILE__ ) ) . 'css/parlamentar-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Verify if the appropriate single-parlamentar.php template is present in active template directory
	 * Otherwise it will use the template present in plugin's directory
	 * 
	 * @since	1.0.0
	 * @uses locate_template()
	 */
	function include_single_template( $template ) {

	    if ( is_singular( 'parlamentar' ) && locate_template( array( 'single-parlamentar.php' ) ) == '' ) {
	        $template = dirname( dirname( __FILE__  ) ) . '/templates/single-parlamentar.php';
	    }

	    return $template;

	}

	/**
	 * Include archive template file
	 * 
	 * @since	1.0.0
	 */
	function include_archive_template( $template ) {

	    if ( is_post_type_archive ( 'parlamentar' ) ) {
	        $template = dirname( dirname( __FILE__ ) ) . '/templates/archive-parlamentar.php';
	    }

	    return $template;

	}

	public function get_parlamentar_meta() {

		global $post;
		$output .= '<ul>';

		foreach( $this->fields as $key => $value ) {
			print_r($value);

			$meta_key = $this->fields_prefix . $value['slug'];
			$meta_title = $value['title'];
			$meta_type = $value['type'];

			$meta_value = get_post_meta( $post->ID, $meta_key, true );

			if ( ! empty ( $meta_value ) ) {
				$output .= '<li>';

				switch ( $meta_type ) {
					case 'url' :
						$output .= '<a href="' . $meta_value . '">' . $meta_title . '</a>';
						break;

					case 'wp_editor' :
						$output .= wpautop( $meta_value );
						break;

					default :
						$output .= $meta_title . ': ' . $meta_value;
						break;
				}

				$output .= '</li>';
		    }
		}
		$output .= '</ul>';

		return $output;
	}

	public function add_parlamentar_info_to_content( $content ) {

		global $post;
		$new_content = '';

		$parlamentar_full_name = get_post_meta( $post->ID, '_parlamentar-info-full-name', true );

		$new_content .= '<h2>' . $parlamentar_full_name . '</h2>';

		// Top info
		$metas_array = array(
			'_parlamentar-info-birthday',
			'_parlamentar-info-marital-status',
			'_parlamentar-info-birthplace',
			'_parlamentar-info-education',
			'_parlamentar-info-occupation'
		);

		$new_content .= '<ul>';
		foreach( $metas_array as $meta ) {
			$meta_value = get_post_meta( $post->ID, $meta, true );
		    if ( ! empty ( $meta_value ) ) {
		    	$new_content .= '<li>' . $meta_value . '</li>';
		    }
		}
		$new_content .= '</ul>';

		// Contact info
		$metas_array = array(
			'_parlamentar-info-address',
			'_parlamentar-info-telephone',
			'_parlamentar-info-email',
		);

		$new_content .= '<ul>';
		foreach( $metas_array as $meta ) {
			$meta_value = get_post_meta( $post->ID, $meta, true );

			if ( ! empty ( $meta_value ) ) {
		    	$new_content .= '<li>' . $meta_value . '</li>';
		    }
		}
		$new_content .= '</ul>';

		// Social info
		$metas_array = array(
			'_parlamentar-info-website',
			'_parlamentar-info-facebook',
			'_parlamentar-info-twitter',
			'_parlamentar-info-wikipedia',
		);

		$new_content .= '<ul>';
		foreach( $metas_array as $meta ) {
			$meta_value = get_post_meta( $post->ID, $meta, true );

			if ( ! empty ( $meta_value ) ) {
		    	$new_content .= '<li>' . $meta_value . '</li>';
		    }
		}
		$new_content .= '</ul>';

		$new_content .= $content;

		// Transparency info
		$metas_array = array(
			'_parlamentar-info-accountability',
			'_parlamentar-info-political-accountability',
		);

		$new_content .= '<h3>Transparência</h3>';
		$new_content .= '<ul>';
		foreach( $metas_array as $meta ) {
			$meta_value = get_post_meta( $post->ID, $meta, true );

			if ( ! empty ( $meta_value ) ) {
		    	$new_content .= '<li><a href="' . esc_url( $meta_value ) . '"">' . $meta_value . '</a></li>';
		    }
		}
		$new_content .= '</ul>';

		$meta_value = get_post_meta( $post->ID, '_parlamentar-info-term-cabinet', true );

		if ( ! empty ( $meta_value ) ) {
			$new_content .= '<h3>Equipe do mandato</h3>';
	    	$new_content .= wpautop( $meta_value );
	    }

		return $new_content;

	}

}

