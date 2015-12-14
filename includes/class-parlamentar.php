<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://campanhacompleta.com.br
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
 * @author     Campanha Completa <ola@zulian.org>
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

		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) ) ;

		/* Admin hooks */
		add_action( 'init', array( $this, 'define_parlamentar_fields' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		add_action( 'after_setup_theme', array( $this, 'add_image_sizes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );

		/* Public hooks */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		add_filter( 'the_content', array( $this, 'add_parlamentar_info_to_content' ) );
		add_filter( 'the_title', array( $this, 'add_parlamentar_info_to_title' ) );

		add_shortcode( 'parlamentar', array( $this, 'add_parlamentar_shortcode' ) );

		add_action( 'parlamentar_the_biography', array( $this, 'parlamentar_the_biography' ) );
		add_action( 'parlamentar_the_top_info', array( $this, 'parlamentar_the_top_info' ) );
		add_action( 'parlamentar_the_transparency_info', array( $this, 'parlamentar_the_transparency_info' ) );

	}

	/**
	 * Defines the fields that will be used
	 */
	function define_parlamentar_fields() {

		$this->fields_prefix = '_parlamentar-info-';
		$this->fields = array(
			'full-name' => array(
				'slug'	=> 'full-name',
				'title'	=> __( 'Full name', 'parlamentar' ),
				'tip'	=> __( '', 'parlamentar' ),
				'type'	=> '',
			),
			'birthday'	=> array(
				'slug'	=> 'birthday',
				'title'	=> __( 'Birthday', 'parlamentar' ),
				'tip'	=> __( '', 'parlamentar' ),
				'type'	=> 'date',
			),
			'birthplace' => array(
				'slug'	=> 'birthplace',
				'title'	=> __( 'Birthplace', 'parlamentar' ),
				'tip'	=> __( '', 'parlamentar' ),
				'type'	=> '',
			),
			'marital-status' => array(
				'slug'	=> 'marital-status',
				'title'	=> __( 'Marital status', 'parlamentar' ),
				'tip'	=> __( '', 'parlamentar' ),
				'type'	=> '',
			),
			'occupation' => array(
				'slug'	=> 'occupation',
				'title'	=> __( 'Occupation', 'parlamentar' ),
				'type'	=> '',
			),
			'education'	=> array(
				'slug'	=> 'education',
				'title'	=> __( 'Education', 'parlamentar' ),
				'type'	=> '',
			),
			'city-of-work'	=> array(
				'slug'	=> 'city-of-work',
				'title'	=> __( 'City of work', 'parlamentar' ),
				'type'	=> '',
			),
			'political-accountability' => array(
				'slug'	=> 'political-accountability',
				'title'	=> __( 'Political accountability URL', 'parlamentar' ),
				'type'	=> 'url',
			),
			'accountability' => array(
				'slug'	=> 'accountability',
				'title'	=> __( 'Personal accountability URL', 'parlamentar' ),
				'type'	=> 'url',
			),
			'term-cabinet'	=> array(
				'slug'	=> 'term-cabinet',
				'title'	=> __( 'Term cabinet', 'parlamentar' ),
				'type'	=> 'wp_editor',
			),
			'address'	=> array(
				'slug'	=> 'address',
				'title'	=> __( 'Address', 'parlamentar' ),
				'type'	=> '',
			),
			'telephone'	=> array(
				'slug'	=> 'telephone',
				'title'	=> __( 'Telephone', 'parlamentar' ),
				'type'	=> '',
			),
			'email'	=> array(
				'slug'	=> 'email',
				'title'	=> __( 'E-mail', 'parlamentar' ),
				'type'	=> 'email',
			),
			'facebook'	=> array(
				'slug'	=> 'facebook',
				'title'	=> __( 'Facebook', 'parlamentar' ),
				'type'	=> 'url',
			),
			'twitter'	=> array(
				'slug'	=> 'twitter',
				'title'	=> __( 'Twitter', 'parlamentar' ),
				'type'	=> 'url',
			),
			'wikipedia'	=> array(
				'slug'	=> 'wikipedia',
				'title'	=> __( 'Wikipedia', 'parlamentar' ),
				'type'	=> 'url',
			),
			'website'	=> array(
				'slug'	=> 'website',
				'title'	=> __( 'Website', 'parlamentar' ),
				'type'	=> 'url',
			),

		);
	}

	/**
	 * Define the internationalization functionality
	 *
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @link       http://campanhacompleta.com.br
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

		$labels = array(
			'name' 					=> __( 'Parliamentarians', 'parlamentar' ),
			'singular_name' 		=> __( 'Parliamentarian', 'parlamentar' ),
			'add_new' 				=> _x( 'Add New', 'parliamentarian', 'parlamentar' ),
			'add_new_item' 			=> __( 'Add New Parliamentarian', 'parlamentar' ),
			'edit_item' 			=> __( 'Edit Parliamentarian', 'parlamentar' ),
			'view_item' 			=> __( 'View Parliamentarian', 'parlamentar' ),
			'search_items' 			=> __( 'Search Parliamentarians', 'parlamentar' ),
			'not_found'				=> __( 'No parliamentarians found', 'parlamentar' ),
			'not_found_in_trash'	=> __( 'No parliamentarians found in Trash', 'parlamentar' ),
		);

		$args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-businessman',
			'capability_type' 		=> 'post',
			'map_meta_cap' 			=> true,
			'hierarchical' 			=> false,
			'supports' 				=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'permalink_epmask' 		=> 'EP_PERMALINK ',
			'has_archive' 			=> true,
			'rewrite' 				=> true,
			'query_var' 			=> true,
			'can_export' 			=> true
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

		$tax_name = 'parlamentar_role';

		$args = array(
			'hierarchical' 		=> true,
			'label' 			=> __( 'Role', 'parlamentar' ),
			'show_ui' 			=> true,
			'query_var' 		=> true,
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
				<?php
				switch ( $info['type'] ) {
					case 'wp_editor':
						wp_editor(
							$value,
							$slug,
							array(
								'media_buttons' => false,
								'quicktags'		=> false,
								'teeny'			=> true
							)
						);
						break;

					case 'date' : ?>
						<input class="widefat js-parlamentar-datepicker" type="text" name="<?php echo $slug; ?>" id="<?php echo $slug; ?>" value="<?php echo esc_attr( $value ); ?>" />
						<?php
						break;

					default : ?>
						<input class="widefat" type="text" name="<?php echo $slug; ?>" id="<?php echo $slug; ?>" value="<?php echo esc_attr( $value ); ?>" />
						<?php
						break;
				}
				?>
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

		// Check if our nonce is set.
		if ( ! isset( $_POST['parlamentar_nonce'] ) ) {
			return $post_id;
		}

		// Verify that the nonce is valid
		if ( ! wp_verify_nonce( $_POST['parlamentar_nonce'], $this->plugin_name ) ) {
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
	 * Register scripts and stylesheets for the admin-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_scripts( $hook ) {

		global $post;

		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
	        return;
	    }

	    if ( 'parlamentar' != $post->post_type ) {
	    	return;
	    }

		wp_enqueue_style( $this->plugin_name . '-datepicker', 'https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'my_custom_script', plugin_dir_url( dirname( __FILE__ ) ) . 'js/parlamentar-admin.js' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname( __FILE__ ) ) . 'css/parlamentar-public.css', array(), $this->version, 'all' );

	}

	public function get_parlamentar_meta( $field_id ) {

		global $post;
		$output = '';

		if ( ! empty( $field_id ) ) {

			if ( array_key_exists( $field_id, $this->fields ) ) {

				$meta_field = $this->fields[$field_id];

				$meta_key = $this->fields_prefix . $meta_field['slug'];
				$meta_type = $meta_field['type'];
				$meta_title = $meta_field['title'];
				$meta_value = get_post_meta( $post->ID, $meta_key, true );

				if ( ! empty ( $meta_value ) ) {

					switch ( $meta_type ) {
						case 'url' :
							$output .= '<a href="' . $meta_value . '" target="_blank">' . $meta_title . '</a>';
							break;

						case 'email' :
							$output .= $meta_title . ': <a href="mailto:' . antispambot( $meta_value ) . '">' . antispambot( $meta_value ) . '</a>';
							break;

						case 'wp_editor' :
							$output .= wpautop( $meta_value );
							break;

						default :
							$output .= $meta_title . ': ' . $meta_value;
							if ( 'birthday' == $meta_field['slug'] ) {
								$output .= ' (' . sprintf( __( '%d years', 'parlamentar'), $this->get_age( $meta_value ) ) . ')';
							}
							break;
					}

				}

			}

		}

		return $output;
	}

	/**
	 * Add Parlamentar info to `the_content` filter
	 * 
	 * @since 1.0.0
	 */
	public function add_parlamentar_info_to_content( $content ) {

		global $post;

		if ( 'parlamentar' != get_post_type() ) {
			return $content;
		}

		$new_content = '';

		// Top info
		$new_content .= $this->parlamentar_get_the_top_info();

		// Regular content
		if ( ! empty ( $content ) ) {
			$new_content .= $this->parlamentar_get_the_biography();
		}

		// Transparency info
		$new_content .= $this->parlamentar_get_the_transparency_info();

		return $new_content;

	}

	/**
	 * Add Parlamentar taxonomy info to `the_title` filter
	 * 
	 * @since 1.0.0
	 */
	public function add_parlamentar_info_to_title( $title ) {

		global $post;

		if ( ! ( is_singular( 'parlamentar' ) && in_the_loop() ) ) {
			return $title;
		}

		$new_title = $title;

		$terms = get_the_terms( $post->ID, 'parlamentar_role' );

		if ( $terms && ! is_wp_error( $terms ) ) {

			$parlamentar_role_output = '';
			$parlamentar_term = array();

			foreach ( $terms as $term ) {
				$parlamentar_term[] = $term->name;
			}

			$parlamentar_role_output = join( ', ', $parlamentar_term );

			$city = get_post_meta( $post->ID, '_parlamentar-info-city-of-work', true );

			$new_title .= '<span class="parlamentar__type">';
			$new_title .= $parlamentar_role_output;

			if ( !empty ( $city ) ) {
				$new_title .=  ' (' . $city . ')';
			}

			$new_title .= '</span>';
		}

		return $new_title;

	}

	/**
	 * Create a shortcode to list posts and create an archive of parliamentarians
	 * 
	 * @since	1.0.0
	 * @param 	string  $atts  The shortcode attributes
	 */
	public function add_parlamentar_shortcode( $atts ) {

		global $post;

		$atts = shortcode_atts( array(
			'role' => '',
		), $atts, 'parlamentar' );

		$output = '';

		$args = array(
			'post_type' => 'parlamentar',
			'posts_per_page' => '-1',
		);

		if ( ! empty ( $atts['role'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'parlamentar_role',
					'field'    => 'slug',
					'terms'    => $atts['role'],
				)
			);
		}

		$parlamentar_list = new WP_Query( $args );

		if ( $parlamentar_list->have_posts() ) :

			$output .= '<div class="parlamentar__list">';

			while ( $parlamentar_list->have_posts() ) : $parlamentar_list->the_post();

				$output .= '<div class="parlamentar__info">';

				if ( has_post_thumbnail() ) {
					$output .= '<div class="entry-image post-thumbnail parlamentar__thumbbnail">';
					$output .= '<a href="' . get_permalink() . '" rel="bookmark" class="parlamentar__permalink">' . get_the_post_thumbnail( get_the_ID(), 'parlamentar-archive' ) . '</a>';
					$output .= '</div>';
				}

				$output .= '<h2 class="entry-title parlamentar__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
				$output .= get_the_title();
				$output .= '</a></h2>';

				$output .= '</div>';

			endwhile;

			$output .= '</div>';

		endif;

		return $output;

	}

	/**
	 * Prints the biography
	 *
	 * @uses the_content()
	 *
	 * @since 1.0.0
	 */
	public function parlamentar_the_biography() {
		echo $this->parlamentar_get_the_biography();
	}

	/**
	 * Gets the biography
	 *
	 * @since 1.0.0
	 */
	public function parlamentar_get_the_biography() {
		global $post;

		// Remove our filter
		remove_filter( 'the_content', array( $this, 'add_parlamentar_info_to_content' ) );

		$output = '<div class="parlamentar__biography">';
		$output .= '<h2 class="parlamentar__area-title parlamentar__area-title--biography">' . __( 'Profile', 'parlamentar' ) . '</h2>';
		$output .= apply_filters('the_content', $post->post_content);
		$output .= '</div>';

		return $output;
	}

	/**
	 * Prints Parlamentar information
	 *
	 * @since 1.0.0
	 */
	public function parlamentar_the_top_info() {
		echo $this->parlamentar_get_the_top_info();
	}

	/**
	 * Gets Parlamentar main information meta data
	 *
	 * @since 1.0.0
	 */
	public function parlamentar_get_the_top_info() {

		$new_content = '<div class="parlamentar__main_info">';

		// Top info
		$metas_array = array(
			'full-name',
			'birthday',
			'marital-status',
			'birthplace',
			'education',
			'occupation'
		);

		$new_content .= '<ul class="parlamentar__meta-list parlamentar__personal_info">';
		foreach( $metas_array as $meta_key ) {
			$meta_value = $this->get_parlamentar_meta( $meta_key );

		    if ( ! empty ( $meta_value ) ) {
		    	$new_content .= '<li>' . $meta_value . '</li>';
		    }

		}
		$new_content .= '</ul>';

		// Contact info
		$metas_array = array(
			'address',
			'telephone',
			'email',
		);

		$new_content .= '<div class="parlamentar__contact">';
		$new_content .= '<address>';

		foreach( $metas_array as $meta_key ) {
			$meta_value = $this->get_parlamentar_meta( $meta_key );

		    if ( ! empty ( $meta_value ) ) {
		    	$new_content .= $meta_value . '<br>';
		    }

		}
		$new_content .= '</address>';
		$new_content .= '</div>';

		// Social info
		$metas_array = array(
			'website',
			'facebook',
			'twitter',
			'wikipedia',
		);

		$new_content .= '<ul class="parlamentar__meta-list parlamentar__meta-list--inline parlamentar__social-links">';
		foreach( $metas_array as $meta_key ) {
			$meta_value = $this->get_parlamentar_meta( $meta_key );

		    if ( ! empty ( $meta_value ) ) {
		    	$new_content .= '<li>' . $meta_value . '</li>';
		    }

		}
		$new_content .= '</ul>';

		$new_content .= '</div>';
		return $new_content;
	}

	/**
	 * Prints transparency information
	 *
	 * @since 1.0.0
	 */
	public function parlamentar_the_transparency_info() {
		echo $this->parlamentar_get_the_transparency_info();
	}

	/**
	 * Get Parlamentar transparency meta data
	 *
	 * @since 1.0.0
	 */
	public function parlamentar_get_the_transparency_info() {
		global $post;

		$output = '<div class="parlamentar__transparency">';

		// Transparency info
		$metas_array = array(
			'accountability',
			'political-accountability',
		);

		$output .= '<h2 class="parlamentar__area-title parlamentar__area-title--transparency">' . __( 'Transparency', 'parlamentar' ) . '</h2>';
		$output .= '<ul class="parlamentar__meta-list">';
		foreach( $metas_array as $meta_key ) {
			$meta_value = $this->get_parlamentar_meta( $meta_key );

		    if ( ! empty ( $meta_value ) ) {
		    	$output .= '<li>'. $meta_value . '</li>';
		    }

		}
		$output .= '</ul>';

		if ( $term_cabinet = $this->get_parlamentar_meta( 'term-cabinet' ) ) {
			$output .= '<h2 class="parlamentar__area-title parlamentar__area-title--term-cabinet">' . __( 'Term cabinet', 'parlamentar' ) . '</h2>' . $term_cabinet;
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Parliamentarian update messages.
	 *
	 * See /wp-admin/edit-form-advanced.php
	 *
	 * @param array $messages Existing post update messages.
	 *
	 * @return array Amended post update messages with new CPT update messages.
	 */
	function post_updated_messages( $messages ) {
		$post = get_post();
		$post_type = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['parlamentar'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Parliamentarian updated.', 'parlamentar' ),
			2  => __( 'Custom field updated.', 'parlamentar' ),
			3  => __( 'Custom field deleted.', 'parlamentar' ),
			4  => __( 'Parliamentarian updated.', 'parlamentar' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Parliamentarian restored to revision from %s', 'parlamentar' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Parliamentarian published.', 'parlamentar' ),
			7  => __( 'Parliamentarian saved.', 'parlamentar' ),
			8  => __( 'Parliamentarian submitted.', 'parlamentar' ),
			9  => sprintf(
				__( 'Parliamentarian scheduled for: <strong>%1$s</strong>.', 'parlamentar' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'parlamentar' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Parliamentarian draft updated.', 'parlamentar' )
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Parliamentarian', 'parlamentar' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview parliamentarian', 'parlamentar' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Get age from birthday
	 */
	function get_age( $then ) {
	    $then = date( 'Ymd', strtotime( $then ) );
	    $diff = date( 'Ymd' ) - $then;
	    return substr( $diff, 0, -4 );
	}

}

