<?php
/**
 * Widget "Mapa con dirección" de Bingo Las Vegas.
 *
 * Mapa de Google en el marco de la casa (esquina dorada, como en Dónde
 * Estamos) y, encima de su borde inferior, una tarjeta con dirección,
 * horario, aparcamiento y botón "Cómo llegar".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class BLV_Map_Card_Widget extends Widget_Base {

	public function get_name() { return 'blv_map_card'; }
	public function get_title() { return esc_html__( 'Mapa con dirección', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-google-maps'; }
	public function get_categories() { return array( 'blv-essentials' ); }
	public function get_keywords() { return array( 'mapa', 'google', 'direccion', 'dirección', 'contacto', 'horario' ); }

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-map-card' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_map', array( 'label' => esc_html__( 'Mapa', 'bingo-essentials' ) ) );
		$this->add_control(
			'map_src',
			array(
				'label'       => esc_html__( 'Dirección del mapa (Google Maps)', 'bingo-essentials' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.79051878361!2d-3.636040884603504!3d40.43555597936315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422f56b0f19c11%3A0x6b4f762740a6b5a!2sC.%20de%20los%20Hnos.%20Garc%C3%ADa%20Noblejas%2C%2017%2C%2028037%20Madrid!5e0!3m2!1sen!2ses!4v1698000000000!5m2!1sen!2ses',
				'description' => esc_html__( 'En Google Maps: Compartir → Insertar un mapa → copia solo lo que hay entre comillas en src="...".', 'bingo-essentials' ),
			)
		);
		$this->add_responsive_control(
			'map_height',
			array(
				'label'          => esc_html__( 'Alto del mapa', 'bingo-essentials' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array( 'px' => array( 'min' => 220, 'max' => 720 ) ),
				'default'        => array( 'unit' => 'px', 'size' => 420 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 280 ),
				'selectors'      => array( '{{WRAPPER}} .blv-map__frame iframe' => 'height: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_card', array( 'label' => esc_html__( 'Tarjeta', 'bingo-essentials' ) ) );
		$this->add_control( 'name', array( 'label' => esc_html__( 'Nombre', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bingo Las Vegas', 'label_block' => true ) );
		$this->add_control( 'address', array( 'label' => esc_html__( 'Dirección', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => "C/ Hermanos García Noblejas, 17\n28037 Madrid" ) );
		$this->add_control( 'hours', array( 'label' => esc_html__( 'Horario', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => "Lunes a jueves: 13:00 – 03:00\nViernes, sábados y festivos: 13:00 – 03:30" ) );
		$this->add_control( 'parking', array( 'label' => esc_html__( 'Aparcamiento', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => "Parking gratuito con aparcacoches\nC/ Caunedo, 4" ) );
		$this->add_control( 'button_text', array( 'label' => esc_html__( 'Botón', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Cómo llegar', 'separator' => 'before' ) );
		$this->add_control( 'button_link', array( 'label' => esc_html__( 'Enlace del botón', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Bingo+Las+Vegas+C.+de+los+Hermanos+Garc%C3%ADa+Noblejas+17+28037+Madrid', 'is_external' => 'on' ) ) );
		$this->end_controls_section();
	}

	private function row( $icon, $label, $text ) {
		$text = trim( (string) $text );
		if ( '' === $text ) {
			return;
		}
		echo '<li class="blv-map__row">' . blv_be_icon( $icon, 'blv-map__icon' );
		echo '<div><span class="blv-map__label">' . esc_html( $label ) . '</span><span class="blv-map__text">' . nl2br( esc_html( $text ) ) . '</span></div></li>';
	}

	protected function render() {
		$s   = $this->get_settings_for_display();
		$src = trim( (string) ( $s['map_src'] ?? '' ) );
		$btn = $s['button_link'] ?? array();

		echo '<div class="blv-map">';

		if ( '' !== $src ) {
			echo '<div class="blv-map__frame">';
			echo '<iframe src="' . esc_url( $src ) . '" title="' . esc_attr( sprintf( __( 'Mapa: %s', 'bingo-essentials' ), $s['name'] ?? '' ) ) . '" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>';
			echo '</div>';
		}

		echo '<div class="blv-map__card">';
		if ( ! empty( $s['name'] ) ) {
			echo '<h3 class="blv-map__name">' . esc_html( $s['name'] ) . '</h3>';
		}
		echo '<ul class="blv-map__rows">';
		$this->row( 'map-pin', __( 'Dirección', 'bingo-essentials' ), $s['address'] ?? '' );
		$this->row( 'clock', __( 'Horario', 'bingo-essentials' ), $s['hours'] ?? '' );
		$this->row( 'car-profile', __( 'Aparcamiento', 'bingo-essentials' ), $s['parking'] ?? '' );
		echo '</ul>';
		if ( ! empty( $s['button_text'] ) && ! empty( $btn['url'] ) ) {
			echo '<a class="blv-map__button" href="' . esc_url( $btn['url'] ) . '"' . ( ! empty( $btn['is_external'] ) ? ' target="_blank" rel="noopener"' : '' ) . '>' . blv_be_icon( 'navigation-arrow' ) . '<span>' . esc_html( $s['button_text'] ) . '</span></a>';
		}
		echo '</div>';

		echo '</div>';
	}
}
