<?php
/**
 * Plugin Name:       Bingo Essentials
 * Description:        Widgets esenciales de Elementor para Bingo Las Vegas: Dónde Estamos, Nuestra Historia y bloques visuales.
 * Version:           1.0.8
 * Author:            Bingo Las Vegas
 * Text Domain:       bingo-essentials
 * Requires Plugins:  elementor
 * Elementor tested up to: 3.25
 *
 * Compatible con Elementor v3 y v4.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No acceso directo.
}

define( 'BLV_BE_VERSION', '1.0.8' );
define( 'BLV_BE_PATH', plugin_dir_path( __FILE__ ) );
define( 'BLV_BE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Actualizaciones desde GitHub.
 */
function blv_be_register_update_checker() {
	$update_checker_path = BLV_BE_PATH . 'vendor/plugin-update-checker/plugin-update-checker.php';

	if ( ! file_exists( $update_checker_path ) ) {
		return;
	}

	require_once $update_checker_path;

	if ( ! class_exists( '\YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) ) {
		return;
	}

	$update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/daviidxestrada/bingo-essentials/',
		__FILE__,
		'bingo-essentials'
	);
	$update_checker->setBranch( 'main' );
}
add_action( 'plugins_loaded', 'blv_be_register_update_checker' );

/**
 * Aviso si Elementor no está activo.
 */
function blv_be_check_elementor() {
	if ( did_action( 'elementor/loaded' ) ) {
		return true;
	}
	add_action( 'admin_notices', function () {
		$message = sprintf(
			/* translators: %s: Elementor */
			esc_html__( 'El plugin "Bingo Essentials" necesita %s para funcionar.', 'bingo-essentials' ),
			'<strong>Elementor</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', $message );
	} );
	return false;
}

/**
 * Categoria propia en Elementor.
 */
add_action( 'elementor/elements/categories_registered', function ( $elements_manager ) {
	$elements_manager->add_category(
		'blv-essentials',
		array(
			'title' => esc_html__( 'Bingo Essentials', 'bingo-essentials' ),
			'icon'  => 'fa fa-plug',
		)
	);
} );

/**
 * Registra el widget en Elementor.
 */
add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
	if ( ! blv_be_check_elementor() ) {
		return;
	}
	require_once BLV_BE_PATH . 'widgets/class-donde-estamos-widget.php';
	require_once BLV_BE_PATH . 'widgets/class-nuestra-historia-widgets.php';
	require_once BLV_BE_PATH . 'widgets/class-bingo-visual-widgets.php';

	$widgets_manager->register( new \BLV_BE_Donde_Estamos_Widget() );
	$widgets_manager->register( new \BLV_Historia_Hero_Widget() );
	$widgets_manager->register( new \BLV_Historia_Nacimiento_Widget() );
	$widgets_manager->register( new \BLV_Historia_Famosos_Widget() );
	$widgets_manager->register( new \BLV_Historia_Producciones_Widget() );
	$widgets_manager->register( new \BLV_Historia_Revolucion_Widget() );
	$widgets_manager->register( new \BLV_Historia_Cta_Widget() );
	$widgets_manager->register( new \BLV_Experiencias_Cards_Widget() );
	$widgets_manager->register( new \BLV_Sorteos_Promos_Widget() );
	$widgets_manager->register( new \BLV_Arrow_Link_Widget() );
	$widgets_manager->register( new \BLV_Partidas_Especiales_Widget() );
	$widgets_manager->register( new \BLV_Carta_Widget() );
} );

/**
 * Registra (no encola) los assets. El widget declara sus dependencias
 * con get_style_depends() / get_script_depends(), así solo se cargan
 * en las páginas donde realmente se usa el widget.
 *
 * TODO se sirve en local (fuentes, GSAP e iconos): el plugin es
 * autocontenido y no depende de ningún CDN externo.
 */
function blv_be_register_assets() {

	// ---- Fuentes auto-hospedadas (Open Sans + Libre Bodoni) ----
	wp_register_style(
		'blv-de-fonts',
		BLV_BE_URL . 'assets/fonts/fonts.css',
		array(),
		BLV_BE_VERSION
	);

	// ---- CSS del widget ----
	wp_register_style(
		'blv-de-style',
		BLV_BE_URL . 'assets/css/donde-estamos.css',
		array( 'blv-de-fonts' ),
		BLV_BE_VERSION
	);

	wp_register_style(
		'blv-be-history-style',
		BLV_BE_URL . 'assets/css/nuestra-historia.css',
		array( 'blv-de-fonts' ),
		BLV_BE_VERSION
	);

	wp_register_style(
		'blv-be-visual-widgets-style',
		BLV_BE_URL . 'assets/css/visual-widgets.css',
		array( 'blv-de-fonts' ),
		BLV_BE_VERSION
	);

	// ---- GSAP + ScrollTrigger (locales) ----
	wp_register_script(
		'blv-de-gsap',
		BLV_BE_URL . 'assets/js/gsap.min.js',
		array(),
		'3.13.0',
		true
	);
	wp_register_script(
		'blv-de-scrolltrigger',
		BLV_BE_URL . 'assets/js/ScrollTrigger.min.js',
		array( 'blv-de-gsap' ),
		'3.13.0',
		true
	);

	// ---- Init de animaciones ----
	wp_register_script(
		'blv-de-init',
		BLV_BE_URL . 'assets/js/donde-estamos.js',
		array( 'blv-de-gsap', 'blv-de-scrolltrigger' ),
		BLV_BE_VERSION,
		true
	);

	wp_register_script(
		'blv-be-history-init',
		BLV_BE_URL . 'assets/js/nuestra-historia.js',
		array( 'blv-de-gsap', 'blv-de-scrolltrigger' ),
		BLV_BE_VERSION,
		true
	);

	wp_register_script(
		'blv-be-promos-lightbox',
		BLV_BE_URL . 'assets/js/promos-lightbox.js',
		array(),
		BLV_BE_VERSION,
		true
	);

	wp_register_script(
		'blv-be-premios-lightbox',
		BLV_BE_URL . 'assets/js/premios-lightbox.js',
		array(),
		BLV_BE_VERSION,
		true
	);

	wp_register_script(
		'blv-be-visual-widgets-init',
		BLV_BE_URL . 'assets/js/visual-widgets.js',
		array(),
		BLV_BE_VERSION,
		true
	);

	wp_register_script(
		'blv-be-pdfjs',
		BLV_BE_URL . 'assets/js/pdf.min.js',
		array(),
		'3.11.174',
		true
	);

	wp_register_script(
		'blv-be-carta-pdf-viewer',
		BLV_BE_URL . 'assets/js/carta-pdf-viewer.js',
		array( 'blv-be-pdfjs' ),
		BLV_BE_VERSION,
		true
	);
	wp_localize_script(
		'blv-be-carta-pdf-viewer',
		'BLV_BE_PDF',
		array(
			'workerUrl' => BLV_BE_URL . 'assets/js/pdf.worker.min.js',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'blv_be_register_assets' );
// También en el editor de Elementor para ver estilos/animaciones en la vista previa.
add_action( 'elementor/editor/after_enqueue_scripts', 'blv_be_register_assets' );
add_action( 'elementor/preview/enqueue_styles', 'blv_be_register_assets' );
