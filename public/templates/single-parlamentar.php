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

				do_action( 'the_parlamentar_meta' );


					

					$parlamentar_full_name = get_post_meta( $post->ID, '_parlamentar-info-full-name', true );

					echo '<h2>' . $parlamentar_full_name . '</h2>';

					// Top info
					$metas_array = array(
						'_parlamentar-info-birthday',
						'_parlamentar-info-marital-status',
						'_parlamentar-info-birthplace',
						'_parlamentar-info-education',
						'_parlamentar-info-occupation'
					);

					echo '<ul>';
					foreach( $metas_array as $meta ) {
						$meta_value = get_post_meta( $post->ID, $meta, true );
					    if ( ! empty ( $meta_value ) ) {
					    	echo '<li>' . $meta_value . '</li>';
					    }
					}
					echo '</ul>';

					// Contact info
					$metas_array = array(
						'_parlamentar-info-address',
						'_parlamentar-info-telephone',
						'_parlamentar-info-email',
					);

					echo '<ul>';
					foreach( $metas_array as $meta ) {
						$meta_value = get_post_meta( $post->ID, $meta, true );

						if ( ! empty ( $meta_value ) ) {
					    	echo '<li>' . $meta_value . '</li>';
					    }
					}
					echo '</ul>';

					// Social info
					$metas_array = array(
						'_parlamentar-info-website',
						'_parlamentar-info-facebook',
						'_parlamentar-info-twitter',
						'_parlamentar-info-wikipedia',
					);

					echo '<ul>';
					foreach( $metas_array as $meta ) {
						$meta_value = get_post_meta( $post->ID, $meta, true );

						if ( ! empty ( $meta_value ) ) {
					    	echo '<li>' . $meta_value . '</li>';
					    }
					}
					echo '</ul>';
					

					/*
					$post_metas = get_post_meta( $post->ID, '', true );
					echo '<hr><ul>';
					foreach( $post_metas as $key => $value ) {

						if ( strpos( $key, '_parlamentar') === false ) {
							continue;
						}

					    echo '<li>' . $value[0] . '</li>';
					}
					echo '</ul>';
					*/
				?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

				<?php
				// Transparency info
				$metas_array = array(
					'_parlamentar-info-accountability',
					'_parlamentar-info-political-accountability',
				);

				echo '<h3>Transparência</h3>';
				echo '<ul>';
				foreach( $metas_array as $meta ) {
					$meta_value = get_post_meta( $post->ID, $meta, true );

					if ( ! empty ( $meta_value ) ) {
				    	echo '<li><a href="' . esc_url( $meta_value ) . '"">' . $meta_value . '</a></li>';
				    }
				}
				echo '</ul>';

				$meta_value = get_post_meta( $post->ID, '_parlamentar-info-term-cabinet', true );

				if ( ! empty ( $meta_value ) ) {
					echo '<h3>Equipe do mandato</h3>';
			    	echo wpautop( $meta_value );
			    }
				?>

			</article><!-- #post-## -->

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
