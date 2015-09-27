<?php
/**
 * The template for displaying post type Parlamentar archive pages
 * 
 * Based on the _s archive.php file (https://github.com/Automattic/_s/blob/master/archive.php)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since      1.0.0
 *
 * @package    Parlamentar
 * @subpackage Parlamentar/public/templates
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="parlamentar-list">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<?php if ( has_post_thumbnail() ) : ?>
							<div class="entry-image">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'parlamentar-archive' ); ?></a>
							</div><!-- .entry-image -->
							<?php endif; ?>

							<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						</header><!-- .entry-header -->
					</article><!-- #post-## -->

				<?php endwhile; ?>
			</div>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
