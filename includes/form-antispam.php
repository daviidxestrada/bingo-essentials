<?php
/**
 * Filtro anti-spam para los formularios de Elementor Pro.
 *
 * Complementa al reCAPTCHA v3 y al campo trampa (honeypot) de cada
 * formulario con reglas sobre el contenido que solo cumple el spam
 * habitual del sitio: enlaces en el nombre, alfabetos que el público
 * de la sala no usa y teléfonos con formato imposible.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normaliza un teléfono y dice si tiene un formato plausible:
 * 9 cifras españolas, 34 + 9 cifras, o prefijo internacional (+ / 00).
 */
function blv_be_phone_is_plausible( $value ) {
	$value  = trim( (string) $value );
	$digits = preg_replace( '/\D+/', '', $value );

	if ( '' === $digits ) {
		return false;
	}
	if ( 0 === strpos( $value, '+' ) || 0 === strpos( $digits, '00' ) ) {
		$len = strlen( ltrim( $digits, '0' ) );
		return $len >= 8 && $len <= 15;
	}
	if ( 9 === strlen( $digits ) ) {
		return (bool) preg_match( '/^[6789]/', $digits );
	}
	if ( 11 === strlen( $digits ) ) {
		return 0 === strpos( $digits, '34' ) && (bool) preg_match( '/^34[6789]/', $digits );
	}
	return false;
}

add_action( 'elementor_pro/forms/validation', function ( $record, $ajax_handler ) {
	$fields  = (array) $record->get( 'fields' );
	$links   = 0;
	$blocked = false;

	foreach ( $fields as $id => $field ) {
		$type  = $field['type'] ?? 'text';
		$value = is_array( $field['value'] ?? '' ) ? implode( ' ', $field['value'] ) : (string) ( $field['value'] ?? '' );
		$title = strtolower( wp_strip_all_tags( (string) ( $field['title'] ?? '' ) ) );

		if ( '' === trim( $value ) || in_array( $type, array( 'upload', 'acceptance', 'recaptcha', 'recaptcha_v3', 'honeypot', 'hidden' ), true ) ) {
			continue;
		}

		// Cirílico, chino, japonés o coreano: nunca en los envíos reales.
		if ( preg_match( '/[\x{0400}-\x{04FF}\x{3040}-\x{30FF}\x{4E00}-\x{9FFF}\x{AC00}-\x{D7AF}]/u', $value ) ) {
			$blocked = true;
			$ajax_handler->add_error( $id, __( 'Este texto contiene caracteres no admitidos.', 'bingo-essentials' ) );
			continue;
		}

		$field_links = preg_match_all( '~(https?://|www\.)~i', $value );
		$links      += $field_links;

		$is_name = 'name' === $id || false !== strpos( $title, 'nombre' ) || false !== strpos( $title, 'apellido' ) || false !== strpos( $title, 'asunto' );
		if ( $is_name && $field_links ) {
			$blocked = true;
			$ajax_handler->add_error( $id, __( 'No incluyas enlaces en este campo.', 'bingo-essentials' ) );
			continue;
		}

		if ( 'tel' === $type && ! blv_be_phone_is_plausible( $value ) ) {
			$blocked = true;
			$ajax_handler->add_error( $id, __( 'Escribe un teléfono válido: 9 cifras, o con prefijo internacional (por ejemplo +34).', 'bingo-essentials' ) );
		}
	}

	if ( $links > 1 ) {
		$blocked = true;
		$ajax_handler->add_error_message( __( 'El mensaje no puede incluir más de un enlace.', 'bingo-essentials' ) );
	}

	if ( $blocked ) {
		update_option( 'blv_be_spam_blocked', absint( get_option( 'blv_be_spam_blocked', 0 ) ) + 1, false );
	}
}, 10, 2 );
