<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://zulian.org
 * @since             1.0.0
 * @package           Parlamentar
 *
 * @wordpress-plugin
 * Plugin Name:       Parlamentar
 * Plugin URI:        http://github.com/campanhacompleta/parlamentar
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Eduardo Zulian
 * Author URI:        http://zulian.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       parlamentar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook( __FILE__, 'activate_parlamentar' );
register_deactivation_hook( __FILE__, 'deactivate_parlamentar' );

function check_parlamentar_rewrite() {
	$rules = get_option( 'rewrite_rules' );
	$found = false;
	foreach ($rules as $rule)
	{
		if(strpos($rule, 'palamentar') !== false)
		{
			$found = true;
			break;
		}
	}
	if ( ! $found ) {
		global $wp_rewrite; $wp_rewrite->flush_rules();
	}
}
add_action( 'wp_loaded','check_parlamentar_rewrite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-parlamentar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_parlamentar() {

	$plugin = new Parlamentar();

}
run_parlamentar();
