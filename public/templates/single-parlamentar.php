<?php
/**
 * The template for displaying single posts from Parlamentar post type
 * 
 * Based on the _s single.php file (https://github.com/Automattic/_s/blob/master/single.php)
 *
 * @since      1.0.0
 *
 * @package    Parlamentar
 * @subpackage Parlamentar/public/templates
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site__section" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
