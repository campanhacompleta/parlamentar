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

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php the_terms( $post->ID, 'parlamentar_type', '<div class="entry-meta">', ', ', '</div>' ); ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-image">
							<?php the_post_thumbnail( 'large' ); ?>
						</div><!-- .entry-image -->
					<?php endif; ?>
				</header><!-- .entry-header -->

				<?php 
				$post_metas = get_post_meta( $post->ID, '', true );

				echo '<ul>';
				foreach( $post_metas as $key => $value ) {

					if ( strpos( $key, '_parlamentar') === false ) {
						continue;
					}

				    echo '<li>' . $value[0] . '</li>';
				}
				echo '</ul>';
				?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php publico_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
