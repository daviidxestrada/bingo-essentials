<?php
/**
 * Iconos Phosphor para todo el sitio.
 *
 * - blv_be_icon(): SVG en línea de los iconos fijos del plugin (sin
 *   descargar ninguna fuente).
 * - blv_be_render_icon(): pinta el valor de un control ICONS de Elementor;
 *   si es un Phosphor que el plugin ya trae en SVG lo pinta en línea y, si
 *   no, deja que Elementor cargue la fuente.
 * - Registra "Phosphor" y "Phosphor (relleno)" en el selector de iconos de
 *   Elementor, para que cualquier icono del sitio pueda ser Phosphor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function blv_be_phosphor_map() {
	static $map = null;
	if ( null === $map ) {
		$map = require BLV_BE_PATH . 'includes/phosphor-icons.php';
	}
	return $map;
}

/**
 * SVG Phosphor en línea.
 *
 * @param string $name  Nombre Phosphor ("caret-right") o con sufijo "-fill".
 * @param string $class Clases CSS extra.
 */
function blv_be_icon( $name, $class = '' ) {
	$map = blv_be_phosphor_map();
	if ( ! isset( $map[ $name ] ) ) {
		return '';
	}
	return '<svg class="blv-ph' . ( $class ? ' ' . esc_attr( $class ) : '' ) . '" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true" focusable="false">' . $map[ $name ] . '</svg>';
}

/**
 * Pinta el valor de un control ICONS de Elementor.
 */
function blv_be_render_icon( $icon, $class = '' ) {
	$value = is_array( $icon ) ? (string) ( $icon['value'] ?? '' ) : '';
	if ( preg_match( '/^ph(-fill)?\s+ph-([a-z0-9-]+)$/', trim( $value ), $m ) ) {
		$svg = blv_be_icon( $m[2] . ( $m[1] ? '-fill' : '' ), $class );
		if ( $svg ) {
			return $svg;
		}
	}
	if ( ! $value && empty( $icon['value']['url'] ) ) {
		return '';
	}
	ob_start();
	\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true', 'class' => $class ) );
	return ob_get_clean();
}

/*
 * Elementor encola la hoja de la fuente Phosphor en cuanto un ajuste usa
 * un icono Phosphor, aunque nuestros widgets lo pinten como SVG. Se quita
 * de la cabecera; si algún icono no está en SVG, Icons_Manager la vuelve a
 * encolar al pintarlo y se imprime en el pie.
 */
add_action( 'wp_print_styles', function () {
	if ( is_admin() || ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
		return;
	}
	wp_dequeue_style( 'elementor-icons-ph' );
	wp_dequeue_style( 'elementor-icons-ph-fill' );
}, 1 );

add_filter( 'elementor/icons_manager/additional_tabs', function ( $tabs ) {
	$base = BLV_BE_URL . 'assets/vendor/phosphor/';

	$tabs['ph'] = array(
		'name'          => 'ph',
		'label'         => esc_html__( 'Phosphor', 'bingo-essentials' ),
		'url'           => $base . 'regular.css',
		'prefix'        => 'ph-',
		'displayPrefix' => 'ph',
		'labelIcon'     => 'ph ph-phosphor-logo',
		'ver'           => '2.1.2',
		'fetchJson'     => $base . 'regular.json',
		'native'        => false,
	);

	$tabs['ph-fill'] = array(
		'name'          => 'ph-fill',
		'label'         => esc_html__( 'Phosphor (relleno)', 'bingo-essentials' ),
		'url'           => $base . 'fill.css',
		'prefix'        => 'ph-',
		'displayPrefix' => 'ph-fill',
		'labelIcon'     => 'ph-fill ph-phosphor-logo',
		'ver'           => '2.1.2',
		'fetchJson'     => $base . 'fill.json',
		'native'        => false,
	);

	return $tabs;
} );
