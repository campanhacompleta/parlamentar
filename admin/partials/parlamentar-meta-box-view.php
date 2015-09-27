<?php
/**
 * Provide the view for Parlamentar Infor Meta Box
 *
 * @link       	http://zulian.org
 * @since 		1.0.0
 *
 * @package    Parlamentar
 * @subpackage Parlamentar/admin/partials
 */

$value = '';

wp_nonce_field( $this->plugin_name, $this->plugin_name . '_nonce' );

if ( ! empty( $meta['parlamentar-type'][0] ) ) {
	$value = $meta['parlamentar-type'][0];
}

foreach ( $this->meta_fields as $key => $info ) : ?>

	<?php
		$slug = $this->meta_fields_prefix . $info['slug'];
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

<?php endforeach; ?>