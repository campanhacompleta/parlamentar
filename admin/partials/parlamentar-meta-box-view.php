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

/* 

Links externos (Wikipedia, Facebook, Twitter etc)


Link para prestação de contas ao TRE
Equipe do mandato
*/

$meta = get_post_custom( $object->ID );

$value = '';

wp_nonce_field( $this->plugin_name, $this->plugin_name . '_nonce' );

$this->_customs = array(

	'Nome complato' => array (
		'slug' => 'full-name',
		'title' => __('Nome complato', 'parlamentar'),
		'tip' => __('', 'parlamentar'),
	),
	
	'Data de nascimento' => array
	(
		'slug' => 'birthday',
		'title' => __('Data de nascimento', 'parlamentar'),
		'tip' => __('', 'parlamentar'),
	),
	
	'Naturalidade' => array (
		'slug' => 'nationality',
		'title' => __('Naturalidade', 'parlamentar'),
		'tip' => __('', 'parlamentar'),
	),
	
	'Estado civil' => array (
		'slug' => 'marital-status',
		'title' => __('Estado civil', 'parlamentar'),
		'tip' => __('', 'parlamentar'),
	),
	
	'Ocupação' => array (
		'slug' => 'occupation',
		'title' => __('Ocupação', 'parlamentar'),
	),

	'Escolaridade' => array (
		'slug' => 'education',
		'title' => __('Escolaridade', 'parlamentar'),
	),

	'Link para prestação de contas do mandato' => array (
		'slug' => 'contas-mandato',
		'title' => __( 'Link para prestação de contas do mandato', 'parlamentar' ),
	),

	'Link para prestação de contas ao TRE' => array (
		'slug' => 'contas-tre',
		'title' => __( 'Link para prestação de contas ao TRE', 'parlamentar' ),
	),

	'Endereço' => array (
		'slug' => 'address',
		'title' => __( 'Endereço', 'parlamentar' ),
	),

	'Telephone' => array (
		'slug' => 'telephone',
		'title' => __( 'Telephone', 'parlamentar' ),
	),

	'Email' => array (
		'slug' => 'email',
		'title' => __( 'Email', 'parlamentar' ),
	),

	'Facebook' => array (
		'slug' => 'facebook',
		'title' => __( 'Facebook', 'parlamentar' ),
	),

	'Twitter' => array (
		'slug' => 'twitter',
		'title' => __( 'Twitter', 'parlamentar' ),
	),

	'Wikipedia' => array (
		'slug' => 'wikipedia',
		'title' => __( 'Wikipedia', 'parlamentar' ),
	),

	'Website' => array (
		'slug' => 'website',
		'title' => __( 'Website', 'parlamentar' ),
	),

);

if ( ! empty( $meta['parlamentar-type'][0] ) ) {
	$value = $meta['parlamentar-type'][0];
}

foreach ($this->_customs as $key => $info ) : ?>
	<?php $slug = 'parlamentar-info-' . $info['slug']; ?>
	<p>
		<label for="<?php echo $slug; ?>"><?php echo $info['title']; ?></label>
		<input class="widefat" type="text" name="<?php echo $slug; ?>" id="<?php echo $slug; ?>" value="<?php echo esc_attr( $value ); ?>" />
	</p>
<?php endforeach; ?>