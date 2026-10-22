<?php
/**
 * Panel "Fotos de la Home" para el equipo de marketing.
 *
 * Permite cambiar, sin entrar en Elementor, el cartel de Partidas
 * especiales y las imágenes de Promociones de la Home. Los datos se
 * guardan en la opción `blv_be_home_media` y los widgets
 * "Partidas especiales" y "Carrusel cards sorteos/promos" los leen
 * cuando tienen activado "Usar fotos del panel de marketing".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BLV_BE_HOME_MEDIA_OPTION', 'blv_be_home_media' );
define( 'BLV_BE_HOME_MEDIA_CAP', 'blv_manage_home_media' );
define( 'BLV_BE_HOME_MEDIA_PAGE', 'blv-fotos-home' );
define( 'BLV_BE_ROLES_VERSION', '1' );

/**
 * Datos guardados en el panel, normalizados.
 *
 * @return array{poster_id:int,poster_alt:string,promos:array<int,array{id:int,alt:string}>,updated:int,updated_by:int}
 */
function blv_be_home_media() {
	$data = get_option( BLV_BE_HOME_MEDIA_OPTION, array() );
	$data = is_array( $data ) ? $data : array();

	$promos = array();
	foreach ( (array) ( $data['promos'] ?? array() ) as $promo ) {
		$id = absint( $promo['id'] ?? 0 );
		if ( $id ) {
			$promos[] = array(
				'id'  => $id,
				'alt' => (string) ( $promo['alt'] ?? '' ),
			);
		}
	}

	return array(
		'poster_id'  => absint( $data['poster_id'] ?? 0 ),
		'poster_alt' => (string) ( $data['poster_alt'] ?? '' ),
		'promos'     => $promos,
		'updated'    => absint( $data['updated'] ?? 0 ),
		'updated_by' => absint( $data['updated_by'] ?? 0 ),
	);
}

/**
 * Rol "Marketing" y capacidad del panel. Se aplica una sola vez por versión.
 */
function blv_be_home_media_roles() {
	if ( get_option( 'blv_be_roles_version' ) === BLV_BE_ROLES_VERSION ) {
		return;
	}

	$admin = get_role( 'administrator' );
	if ( $admin ) {
		$admin->add_cap( BLV_BE_HOME_MEDIA_CAP );
	}

	remove_role( 'blv_marketing' );
	add_role(
		'blv_marketing',
		__( 'Marketing (Fotos Home)', 'bingo-essentials' ),
		array(
			'read'                => true,
			'upload_files'        => true,
			BLV_BE_HOME_MEDIA_CAP => true,
		)
	);

	update_option( 'blv_be_roles_version', BLV_BE_ROLES_VERSION );
}
add_action( 'init', 'blv_be_home_media_roles' );

function blv_be_is_marketing_user( $user = null ) {
	$user = $user ? $user : wp_get_current_user();
	return $user && in_array( 'blv_marketing', (array) $user->roles, true );
}

/**
 * Menú del panel.
 */
add_action( 'admin_menu', function () {
	$hook = add_menu_page(
		__( 'Fotos de la Home', 'bingo-essentials' ),
		__( 'Fotos Home', 'bingo-essentials' ),
		BLV_BE_HOME_MEDIA_CAP,
		BLV_BE_HOME_MEDIA_PAGE,
		'blv_be_home_media_render_page',
		'dashicons-format-gallery',
		3
	);

	add_action( 'admin_enqueue_scripts', function ( $current ) use ( $hook ) {
		if ( $current !== $hook ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_style( 'blv-be-home-media-fonts', BLV_BE_URL . 'assets/fonts/fonts.css', array(), BLV_BE_VERSION );
		wp_enqueue_style( 'blv-be-home-media', BLV_BE_URL . 'assets/css/admin-home-media.css', array( 'blv-be-home-media-fonts' ), BLV_BE_VERSION );
		wp_enqueue_script( 'blv-be-home-media', BLV_BE_URL . 'assets/js/admin-home-media.js', array( 'jquery', 'jquery-ui-sortable' ), BLV_BE_VERSION, true );
	} );

	// Marketing solo necesita el panel y la biblioteca de medios.
	if ( blv_be_is_marketing_user() ) {
		remove_menu_page( 'index.php' );
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'tools.php' );
	}
}, 20 );

add_filter( 'admin_body_class', function ( $classes ) {
	$screen = get_current_screen();
	if ( $screen && 'toplevel_page_' . BLV_BE_HOME_MEDIA_PAGE === $screen->id ) {
		$classes .= ' blv-hm-screen';
	}
	return $classes;
} );

// Marketing aterriza directamente en el panel.
add_filter( 'login_redirect', function ( $redirect_to, $requested, $user ) {
	if ( $user instanceof WP_User && blv_be_is_marketing_user( $user ) ) {
		return admin_url( 'admin.php?page=' . BLV_BE_HOME_MEDIA_PAGE );
	}
	return $redirect_to;
}, 10, 3 );

add_action( 'load-index.php', function () {
	if ( blv_be_is_marketing_user() ) {
		wp_safe_redirect( admin_url( 'admin.php?page=' . BLV_BE_HOME_MEDIA_PAGE ) );
		exit;
	}
} );

/**
 * Guardado.
 */
add_action( 'admin_post_blv_save_home_media', function () {
	if ( ! current_user_can( BLV_BE_HOME_MEDIA_CAP ) ) {
		wp_die( esc_html__( 'No tienes permiso para cambiar las fotos de la Home.', 'bingo-essentials' ), 403 );
	}
	check_admin_referer( 'blv_save_home_media' );

	$is_image = function ( $id ) {
		return $id && wp_attachment_is_image( $id );
	};

	$poster_id = absint( $_POST['poster_id'] ?? 0 );
	$promos    = array();
	$ids       = array_map( 'absint', (array) ( $_POST['promo_id'] ?? array() ) );
	$alts      = array_map( 'sanitize_text_field', array_map( 'wp_unslash', (array) ( $_POST['promo_alt'] ?? array() ) ) );

	foreach ( $ids as $i => $id ) {
		if ( $is_image( $id ) ) {
			$promos[] = array(
				'id'  => $id,
				'alt' => $alts[ $i ] ?? '',
			);
		}
	}

	update_option(
		BLV_BE_HOME_MEDIA_OPTION,
		array(
			'poster_id'  => $is_image( $poster_id ) ? $poster_id : 0,
			'poster_alt' => sanitize_text_field( wp_unslash( $_POST['poster_alt'] ?? '' ) ),
			'promos'     => $promos,
			'updated'    => time(),
			'updated_by' => get_current_user_id(),
		),
		false
	);

	blv_be_home_media_flush_cache();

	wp_safe_redirect( add_query_arg( 'blv-saved', '1', admin_url( 'admin.php?page=' . BLV_BE_HOME_MEDIA_PAGE ) ) );
	exit;
} );

/**
 * Vacía la caché de elementos de Elementor de la Home para que el
 * cambio se vea al momento.
 */
function blv_be_home_media_flush_cache() {
	$front = (int) get_option( 'page_on_front' );
	if ( $front ) {
		delete_post_meta( $front, '_elementor_element_cache' );
		clean_post_cache( $front );
	}
}

/**
 * Valores actuales de los widgets de la Home: sirven para rellenar el
 * panel la primera vez, antes de que marketing guarde nada.
 */
function blv_be_home_media_from_elementor() {
	$front = (int) get_option( 'page_on_front' );
	$tree  = $front ? json_decode( (string) get_post_meta( $front, '_elementor_data', true ), true ) : null;
	$found = array(
		'poster_id'  => 0,
		'poster_alt' => '',
		'promos'     => array(),
	);

	$walk = function ( $elements ) use ( &$walk, &$found ) {
		foreach ( (array) $elements as $el ) {
			$type = $el['widgetType'] ?? '';
			$s    = $el['settings'] ?? array();
			if ( 'blv_partidas_especiales' === $type && ! $found['poster_id'] ) {
				$found['poster_id']  = absint( $s['poster']['id'] ?? 0 );
				$found['poster_alt'] = (string) ( $s['poster_alt'] ?? '' );
			}
			if ( 'blv_sorteos_promos' === $type && ! $found['promos'] ) {
				foreach ( (array) ( $s['items'] ?? array() ) as $item ) {
					$id = absint( $item['image']['id'] ?? 0 );
					if ( $id ) {
						$found['promos'][] = array(
							'id'  => $id,
							'alt' => (string) ( $item['alt'] ?? '' ),
						);
					}
				}
			}
			if ( ! empty( $el['elements'] ) ) {
				$walk( $el['elements'] );
			}
		}
	};
	$walk( $tree );

	return $found;
}

/**
 * Pantalla del panel.
 */
function blv_be_home_media_render_page() {
	if ( ! current_user_can( BLV_BE_HOME_MEDIA_CAP ) ) {
		return;
	}

	$data = blv_be_home_media();
	if ( ! $data['updated'] ) {
		$data = array_merge( $data, blv_be_home_media_from_elementor() );
	}

	$poster_url = $data['poster_id'] ? wp_get_attachment_image_url( $data['poster_id'], 'large' ) : '';
	$home_url   = home_url( '/' );
	$saved      = isset( $_GET['blv-saved'] );
	$updated_by = $data['updated_by'] ? get_userdata( $data['updated_by'] ) : null;
	?>
	<div class="blv-hm" data-blv-hm>
		<header class="blv-hm-head">
			<div class="blv-hm-head__inner">
				<div>
					<h1 class="blv-hm-title"><?php esc_html_e( 'Fotos de la Home', 'bingo-essentials' ); ?></h1>
					<p class="blv-hm-sub"><?php esc_html_e( 'Cambia el cartel de Partidas especiales y las promociones. Al guardar, la Home se actualiza al momento.', 'bingo-essentials' ); ?></p>
				</div>
				<a class="blv-hm-link" href="<?php echo esc_url( $home_url ); ?>" target="_blank" rel="noopener">
					<?php esc_html_e( 'Ver la Home', 'bingo-essentials' ); ?>
					<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"></path><path d="M10 14 21 3"></path><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path></svg>
				</a>
			</div>
		</header>

		<?php if ( $saved ) : ?>
			<div class="blv-hm-toast" role="status" data-blv-hm-toast>
				<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>
				<span><?php esc_html_e( 'Guardado. La Home ya muestra las nuevas fotos.', 'bingo-essentials' ); ?></span>
			</div>
		<?php endif; ?>

		<form class="blv-hm-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-blv-hm-form>
			<input type="hidden" name="action" value="blv_save_home_media">
			<?php wp_nonce_field( 'blv_save_home_media' ); ?>

			<section class="blv-hm-section" aria-labelledby="blv-hm-poster-title">
				<div class="blv-hm-section__head">
					<h2 id="blv-hm-poster-title" class="blv-hm-h2"><?php esc_html_e( 'Partidas especiales', 'bingo-essentials' ); ?></h2>
					<p class="blv-hm-help"><?php esc_html_e( 'El cartel que aparece junto al título. Funciona mejor una imagen vertical; al pulsarla en la web se abre en grande.', 'bingo-essentials' ); ?></p>
				</div>

				<div class="blv-hm-poster">
					<button type="button" class="blv-hm-poster__frame<?php echo $poster_url ? '' : ' is-empty'; ?>" data-blv-hm-pick-poster aria-label="<?php esc_attr_e( 'Cambiar cartel de Partidas especiales', 'bingo-essentials' ); ?>">
						<img src="<?php echo esc_url( $poster_url ); ?>" alt="" data-blv-hm-poster-img<?php echo $poster_url ? '' : ' hidden'; ?>>
						<span class="blv-hm-empty" data-blv-hm-poster-empty<?php echo $poster_url ? ' hidden' : ''; ?>><?php esc_html_e( 'Sin cartel. Pulsa para elegir uno.', 'bingo-essentials' ); ?></span>
					</button>
					<div class="blv-hm-poster__side">
						<input type="hidden" name="poster_id" value="<?php echo esc_attr( $data['poster_id'] ); ?>" data-blv-hm-poster-id>
						<button type="button" class="blv-hm-btn blv-hm-btn--gold" data-blv-hm-pick-poster>
							<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
							<?php esc_html_e( 'Cambiar cartel', 'bingo-essentials' ); ?>
						</button>
						<label class="blv-hm-field">
							<span class="blv-hm-label"><?php esc_html_e( 'Descripción de la imagen', 'bingo-essentials' ); ?></span>
							<input type="text" name="poster_alt" value="<?php echo esc_attr( $data['poster_alt'] ); ?>" placeholder="<?php esc_attr_e( 'Ej.: Cartel de partidas especiales de octubre', 'bingo-essentials' ); ?>">
							<span class="blv-hm-hint"><?php esc_html_e( 'La leen los buscadores y los lectores de pantalla. Describe lo que se ve.', 'bingo-essentials' ); ?></span>
						</label>
					</div>
				</div>
			</section>

			<section class="blv-hm-section" aria-labelledby="blv-hm-promos-title">
				<div class="blv-hm-section__head blv-hm-section__head--row">
					<div>
						<h2 id="blv-hm-promos-title" class="blv-hm-h2"><?php esc_html_e( 'Promociones', 'bingo-essentials' ); ?></h2>
						<p class="blv-hm-help"><?php esc_html_e( 'Se muestran en la Home en este orden. Arrastra una tarjeta para moverla. Formato cuadrado (por ejemplo 600 × 600).', 'bingo-essentials' ); ?></p>
					</div>
					<button type="button" class="blv-hm-btn blv-hm-btn--gold" data-blv-hm-add-promos>
						<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
						<?php esc_html_e( 'Añadir promociones', 'bingo-essentials' ); ?>
					</button>
				</div>

				<ol class="blv-hm-promos" data-blv-hm-promos>
					<?php foreach ( $data['promos'] as $promo ) : ?>
						<?php
						$url = wp_get_attachment_image_url( $promo['id'], 'medium_large' );
						if ( ! $url ) {
							continue;
						}
						?>
						<li class="blv-hm-promo" data-blv-hm-promo>
							<input type="hidden" name="promo_id[]" value="<?php echo esc_attr( $promo['id'] ); ?>">
							<div class="blv-hm-promo__media">
								<img src="<?php echo esc_url( $url ); ?>" alt="">
								<span class="blv-hm-promo__handle" title="<?php esc_attr_e( 'Arrastra para ordenar', 'bingo-essentials' ); ?>" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="9" cy="6" r="1.6"></circle><circle cx="15" cy="6" r="1.6"></circle><circle cx="9" cy="12" r="1.6"></circle><circle cx="15" cy="12" r="1.6"></circle><circle cx="9" cy="18" r="1.6"></circle><circle cx="15" cy="18" r="1.6"></circle></svg>
								</span>
								<span class="blv-hm-promo__order" aria-hidden="true"></span>
							</div>
							<div class="blv-hm-promo__body">
								<label class="blv-hm-field">
									<span class="blv-hm-label"><?php esc_html_e( 'Descripción', 'bingo-essentials' ); ?></span>
									<input type="text" name="promo_alt[]" value="<?php echo esc_attr( $promo['alt'] ); ?>" placeholder="<?php esc_attr_e( 'Ej.: Sorteo de 8.000 € los miércoles', 'bingo-essentials' ); ?>">
								</label>
								<div class="blv-hm-promo__actions">
									<button type="button" class="blv-hm-icon-btn" data-blv-hm-move="-1" aria-label="<?php esc_attr_e( 'Mover antes', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg></button>
									<button type="button" class="blv-hm-icon-btn" data-blv-hm-move="1" aria-label="<?php esc_attr_e( 'Mover después', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg></button>
									<button type="button" class="blv-hm-icon-btn" data-blv-hm-replace aria-label="<?php esc_attr_e( 'Cambiar imagen', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path><path d="M16 16h5v5"></path></svg></button>
									<button type="button" class="blv-hm-icon-btn blv-hm-icon-btn--danger" data-blv-hm-remove aria-label="<?php esc_attr_e( 'Quitar de la Home', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg></button>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>

				<div class="blv-hm-empty-state" data-blv-hm-promos-empty<?php echo $data['promos'] ? ' hidden' : ''; ?>>
					<p><?php esc_html_e( 'No hay promociones en la Home. Añade la primera para que aparezca la sección.', 'bingo-essentials' ); ?></p>
				</div>
			</section>

			<div class="blv-hm-bar" data-blv-hm-bar>
				<p class="blv-hm-bar__status" data-blv-hm-status aria-live="polite">
					<?php
					if ( $data['updated'] ) {
						printf(
							/* translators: 1: fecha, 2: usuario */
							esc_html__( 'Última actualización: %1$s%2$s', 'bingo-essentials' ),
							esc_html( wp_date( 'j M Y, H:i', $data['updated'] ) ),
							$updated_by ? esc_html( ' · ' . $updated_by->display_name ) : ''
						);
					} else {
						esc_html_e( 'Estas son las fotos que se ven ahora en la Home.', 'bingo-essentials' );
					}
					?>
				</p>
				<button type="submit" class="blv-hm-btn blv-hm-btn--primary" data-blv-hm-submit>
					<?php esc_html_e( 'Guardar y publicar', 'bingo-essentials' ); ?>
				</button>
			</div>
		</form>

		<template data-blv-hm-promo-template>
			<li class="blv-hm-promo is-new" data-blv-hm-promo>
				<input type="hidden" name="promo_id[]" value="">
				<div class="blv-hm-promo__media">
					<img src="" alt="">
					<span class="blv-hm-promo__handle" title="<?php esc_attr_e( 'Arrastra para ordenar', 'bingo-essentials' ); ?>" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="9" cy="6" r="1.6"></circle><circle cx="15" cy="6" r="1.6"></circle><circle cx="9" cy="12" r="1.6"></circle><circle cx="15" cy="12" r="1.6"></circle><circle cx="9" cy="18" r="1.6"></circle><circle cx="15" cy="18" r="1.6"></circle></svg>
					</span>
					<span class="blv-hm-promo__order" aria-hidden="true"></span>
				</div>
				<div class="blv-hm-promo__body">
					<label class="blv-hm-field">
						<span class="blv-hm-label"><?php esc_html_e( 'Descripción', 'bingo-essentials' ); ?></span>
						<input type="text" name="promo_alt[]" value="" placeholder="<?php esc_attr_e( 'Ej.: Sorteo de 8.000 € los miércoles', 'bingo-essentials' ); ?>">
					</label>
					<div class="blv-hm-promo__actions">
						<button type="button" class="blv-hm-icon-btn" data-blv-hm-move="-1" aria-label="<?php esc_attr_e( 'Mover antes', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg></button>
						<button type="button" class="blv-hm-icon-btn" data-blv-hm-move="1" aria-label="<?php esc_attr_e( 'Mover después', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg></button>
						<button type="button" class="blv-hm-icon-btn" data-blv-hm-replace aria-label="<?php esc_attr_e( 'Cambiar imagen', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path><path d="M16 16h5v5"></path></svg></button>
						<button type="button" class="blv-hm-icon-btn blv-hm-icon-btn--danger" data-blv-hm-remove aria-label="<?php esc_attr_e( 'Quitar de la Home', 'bingo-essentials' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg></button>
					</div>
				</div>
			</li>
		</template>
	</div>
	<?php
}
