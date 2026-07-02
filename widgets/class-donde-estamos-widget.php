<?php
/**
 * Widget de Elementor: Bingo Las Vegas – Dónde Estamos.
 *
 * Genera la sección "Dónde Estamos" con dos bloques fijos
 * (Sala + Aparcamiento). El DISEÑO (colores, iconos, orden,
 * estilos) está bloqueado: el cliente SOLO puede editar los
 * TEXTOS de cada apartado desde el panel de Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class BLV_BE_Donde_Estamos_Widget extends Widget_Base {

	public function get_name() {
		return 'blv_donde_estamos';
	}

	public function get_title() {
		return esc_html__( 'Dónde Estamos', 'bingo-donde-estamos' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return array( 'blv-essentials' );
	}

	public function get_keywords() {
		return array( 'mapa', 'localizacion', 'donde', 'estamos', 'bingo', 'contacto' );
	}

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-de-style' );
	}

	public function get_script_depends() {
		return array( 'blv-de-gsap', 'blv-de-scrolltrigger', 'blv-de-init' );
	}

	/* =========================================================
	 *  ICONOS incrustados como SVG (Phosphor). Sin dependencia
	 *  externa: se pintan inline y toman el color del texto.
	 * ========================================================= */
	private function icon( $key ) {
		$paths = array(
			'map-pin'          => 'M128,16a88.1,88.1,0,0,0-88,88c0,75.3,80,132.17,83.41,134.55a8,8,0,0,0,9.18,0C136,236.17,216,179.3,216,104A88.1,88.1,0,0,0,128,16Zm0,56a32,32,0,1,1-32,32A32,32,0,0,1,128,72Z',
			'subway'           => 'M224,96V208a8,8,0,0,1-16,0V96a56.06,56.06,0,0,0-56-56H104A56.06,56.06,0,0,0,48,96V208a8,8,0,0,1-16,0V96a72.08,72.08,0,0,1,72-72h48A72.08,72.08,0,0,1,224,96Zm-40,0v72a24,24,0,0,1-19.29,23.53l2.45,4.89a8,8,0,0,1-14.32,7.16L147.06,192H108.94l-5.78,11.58a8,8,0,0,1-14.32-7.16l2.45-4.89A24,24,0,0,1,72,168V96A24,24,0,0,1,96,72h64A24,24,0,0,1,184,96ZM88,96v48h80V96a8,8,0,0,0-8-8H96A8,8,0,0,0,88,96Zm32,64v16h16V160ZM96,176h8V160H88v8A8,8,0,0,0,96,176Zm72-8v-8H152v16h8A8,8,0,0,0,168,168Z',
			'clock'            => 'M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z',
			'car-profile'      => 'M240,112H211.31L168,68.69A15.86,15.86,0,0,0,156.69,64H44.28A16,16,0,0,0,31,71.12L1.34,115.56A8.07,8.07,0,0,0,0,120v48a16,16,0,0,0,16,16H33a32,32,0,0,0,62,0h66a32,32,0,0,0,62,0h17a16,16,0,0,0,16-16V128A16,16,0,0,0,240,112ZM44.28,80H156.69l32,32H23ZM64,192a16,16,0,1,1,16-16A16,16,0,0,1,64,192Zm128,0a16,16,0,1,1,16-16A16,16,0,0,1,192,192Z',
			'key'              => 'M216.57,39.43A80,80,0,0,0,83.91,120.78L28.69,176A15.86,15.86,0,0,0,24,187.31V216a16,16,0,0,0,16,16H72a8,8,0,0,0,8-8V208H96a8,8,0,0,0,8-8V184h16a8,8,0,0,0,5.66-2.34l9.56-9.57A79.73,79.73,0,0,0,160,176h.1A80,80,0,0,0,216.57,39.43ZM224,98.1c-1.09,34.09-29.75,61.86-63.89,61.9H160a63.7,63.7,0,0,1-23.65-4.51,8,8,0,0,0-8.84,1.68L116.69,168H96a8,8,0,0,0-8,8v16H72a8,8,0,0,0-8,8v16H40V187.31l58.83-58.82a8,8,0,0,0,1.68-8.84A63.72,63.72,0,0,1,96,95.92c0-34.14,27.81-62.8,61.9-63.89A64,64,0,0,1,224,98.1ZM192,76a12,12,0,1,1-12-12A12,12,0,0,1,192,76Z',
			'shield-check'     => 'M208,40H48A16,16,0,0,0,32,56v56c0,52.72,25.52,84.67,46.93,102.19,23.06,18.86,46,25.26,47,25.53a8,8,0,0,0,4.2,0c1-.27,23.91-6.67,47-25.53C198.48,196.67,224,164.72,224,112V56A16,16,0,0,0,208,40Zm0,72c0,37.07-13.66,67.16-40.6,89.42A129.3,129.3,0,0,1,128,223.62a128.25,128.25,0,0,1-38.92-21.81C61.82,179.51,48,149.3,48,112l0-56,160,0ZM82.34,141.66a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35a8,8,0,0,1,11.32,11.32l-56,56a8,8,0,0,1-11.32,0Z',
			'navigation-arrow' => 'M238.7,102.46,62.81,37.21l-.25-.09A20,20,0,0,0,37.12,62.56l.09.25L102.46,238.7A20,20,0,0,0,121.3,252h.35a20,20,0,0,0,18.77-14.12l.09-.29,21.23-75.85,75.85-21.23.29-.09a20,20,0,0,0,.82-38Zm-89.93,38a12,12,0,0,0-8.32,8.32l-19.68,70.29L62.8,62.8l156.26,58Z',
		);
		if ( empty( $key ) || ! isset( $paths[ $key ] ) ) {
			return '';
		}
		return '<svg class="blv-ico" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true" focusable="false"><path d="' . $paths[ $key ] . '"></path></svg>';
	}

	/* =========================================================
	 *  DISEÑO FIJO POR BLOQUE (no editable por el cliente).
	 *  Solo los textos vienen de los controles de Elementor.
	 * ========================================================= */
	private function block_design() {
		return array(
			'b1' => array(
				'accent'       => 'gold',
				'reverse'      => false,
				'address_icon' => 'map-pin',
				'd1_icon'      => 'subway',
				'd2_icon'      => 'clock',
				'btn1_icon'    => 'navigation-arrow',
				'btn1_style'   => 'primary',      // fucsia
				'has_btn2'     => false,
			),
			'b2' => array(
				'accent'       => 'fuchsia',
				'reverse'      => true,
				'address_icon' => 'car-profile',
				'd1_icon'      => 'key',
				'd2_icon'      => 'shield-check',
				'btn1_icon'    => 'navigation-arrow',
				'btn1_style'   => 'primary-gold', // oro
				'btn2_style'   => 'outline',
				'has_btn2'     => false,
			),
		);
	}

	/**
	 * Registro de controles: SOLO textos, agrupados por apartados.
	 */
	protected function register_controls() {

		$this->register_block_controls(
			'b1',
			esc_html__( 'Bloque 1 · Sala', 'bingo-donde-estamos' ),
			array(
				'badge'     => 'Ubicación Principal',
				'title'     => 'SALA',
				'addr_main' => 'C/ Hermanos García Noblejas, 17',
				'addr_sub'  => '28037 Madrid, España',
				'd1_label'  => 'Transporte Público',
				'd1_text'   => 'Metro Ciudad Lineal (L5) / Autobuses 38, 48, 70',
				'd2_label'  => 'Horario',
				'd2_text'   => 'Abierto todos los días de 12:30 a 03:00',
				'btn1_text' => 'Cómo Llegar',
				'btn1_url'  => 'https://maps.google.com/?q=Calle+Hermanos+Garcia+Noblejas+17+Madrid',
				'legal'     => "Acceso exclusivo a mayores de 18 años.\nImprescindible para acceder al local la presentación de documento oficial de identidad vigente físico (DNI, NIE, Pasaporte).\nNo se permite el acceso a quien figure en el Registro de Interdicciones de Acceso al Juego (RGIAJ).",
				'map'       => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.79051878361!2d-3.636040884603504!3d40.43555597936315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422f56b0f19c11%3A0x6b4f762740a6b5a!2sC.%20de%20los%20Hnos.%20Garc%C3%ADa%20Noblejas%2C%2017%2C%2028037%20Madrid!5e0!3m2!1sen!2ses!4v1698000000000!5m2!1sen!2ses',
			),
			false
		);

		$this->register_block_controls(
			'b2',
			esc_html__( 'Bloque 2 · Aparcamiento', 'bingo-donde-estamos' ),
			array(
				'badge'     => 'Servicio Exclusivo',
				'title'     => 'Aparcamiento Gratuito',
				'addr_main' => 'C/ Caunedo, 4',
				'addr_sub'  => 'Acceso directo a nuestras instalaciones',
				'd1_label'  => 'Atención VIP',
				'd1_text'   => 'Servicio de aparcacoches disponible para clientes. Deje su vehículo en la puerta y nosotros nos encargamos del resto.',
				'd2_label'  => 'Seguridad',
				'd2_text'   => 'Parking vigilado durante su estancia en la sala.',
				'btn1_text' => 'Ruta al Parking',
				'btn1_url'  => 'https://maps.google.com/?q=Calle+Caunedo+4+Madrid',
				'btn2_text' => '',
				'btn2_url'  => '',
				'legal'     => "Acceso exclusivo a mayores de 18 años.\nImprescindible para acceder al local la presentación de documento oficial de identidad vigente físico (DNI, NIE, Pasaporte).\nNo se permite el acceso a quien figure en el Registro de Interdicciones de Acceso al Juego (RGIAJ).",
				'map'       => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.758004554865!2d-3.633912184603487!3d40.43625757936306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422f5a3b31a3b9%3A0x8e8a60f9e3c9a6a!2sC.%20de%20Caunedo%2C%204%2C%2028037%20Madrid!5e0!3m2!1sen!2ses!4v1698000000001!5m2!1sen!2ses',
			),
			false
		);
	}

	/**
	 * Registra la sección de controles (solo textos) de un bloque.
	 *
	 * @param string $p        Prefijo del bloque (b1, b2).
	 * @param string $label    Título de la sección en el panel.
	 * @param array  $d        Textos por defecto.
	 * @param bool   $show_btn2 Si el bloque tiene segundo botón.
	 */
	private function register_block_controls( $p, $label, $d, $show_btn2 ) {

		$this->start_controls_section(
			$p . '_section',
			array(
				'label' => $label,
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		// --- Encabezado del bloque ---
		$this->add_control(
			$p . '_badge',
			array(
				'label'       => esc_html__( 'Etiqueta superior', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['badge'],
				'label_block' => true,
			)
		);
		$this->add_control(
			$p . '_title',
			array(
				'label'       => esc_html__( 'Título', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['title'],
				'label_block' => true,
			)
		);

		// --- Dirección ---
		$this->add_control(
			$p . '_addr_heading',
			array(
				'label'     => esc_html__( 'Dirección', 'bingo-donde-estamos' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			$p . '_addr_main',
			array(
				'label'       => esc_html__( 'Calle / dirección', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['addr_main'],
				'label_block' => true,
			)
		);
		$this->add_control(
			$p . '_addr_sub',
			array(
				'label'       => esc_html__( 'Segunda línea', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['addr_sub'],
				'label_block' => true,
			)
		);

		// --- Detalle 1 ---
		$this->add_control(
			$p . '_d1_heading',
			array(
				'label'     => esc_html__( 'Dato 1', 'bingo-donde-estamos' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			$p . '_d1_label',
			array(
				'label'       => esc_html__( 'Título del dato', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['d1_label'],
				'label_block' => true,
			)
		);
		$this->add_control(
			$p . '_d1_text',
			array(
				'label'   => esc_html__( 'Descripción', 'bingo-donde-estamos' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => $d['d1_text'],
			)
		);

		// --- Detalle 2 ---
		$this->add_control(
			$p . '_d2_heading',
			array(
				'label'     => esc_html__( 'Dato 2', 'bingo-donde-estamos' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			$p . '_d2_label',
			array(
				'label'       => esc_html__( 'Título del dato', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['d2_label'],
				'label_block' => true,
			)
		);
		$this->add_control(
			$p . '_d2_text',
			array(
				'label'   => esc_html__( 'Descripción', 'bingo-donde-estamos' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => $d['d2_text'],
			)
		);

		// --- Botones ---
		$this->add_control(
			$p . '_btn_heading',
			array(
				'label'     => esc_html__( 'Botones', 'bingo-donde-estamos' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			$p . '_btn1_text',
			array(
				'label'       => esc_html__( 'Botón principal · Texto', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['btn1_text'],
				'label_block' => true,
			)
		);
		$this->add_control(
			$p . '_btn1_url',
			array(
				'label'       => esc_html__( 'Botón principal · Enlace', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://...',
				'default'     => array( 'url' => $d['btn1_url'], 'is_external' => 'on' ),
			)
		);

		if ( $show_btn2 ) {
			$this->add_control(
				$p . '_btn2_text',
				array(
					'label'       => esc_html__( 'Botón secundario · Texto', 'bingo-donde-estamos' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => $d['btn2_text'],
					'label_block' => true,
					'description' => esc_html__( 'Déjalo vacío para ocultar este botón.', 'bingo-donde-estamos' ),
				)
			);
			$this->add_control(
				$p . '_btn2_url',
				array(
					'label'       => esc_html__( 'Botón secundario · Enlace', 'bingo-donde-estamos' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => 'https://...',
					'default'     => array( 'url' => $d['btn2_url'] ),
				)
			);
		}

		// --- Mapa y aviso legal ---
		$this->add_control(
			$p . '_map_heading',
			array(
				'label'     => esc_html__( 'Mapa y aviso legal', 'bingo-donde-estamos' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			$p . '_legal',
			array(
				'label'       => esc_html__( 'Aviso legal', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => $d['legal'],
				'description' => esc_html__( 'Cada línea será un párrafo.', 'bingo-donde-estamos' ),
			)
		);
		$this->add_control(
			$p . '_map',
			array(
				'label'       => esc_html__( 'Dirección del mapa (Google Maps)', 'bingo-donde-estamos' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => $d['map'],
				'description' => esc_html__( 'En Google Maps: Compartir → Insertar un mapa → copia solo lo que hay entre comillas en src="...".', 'bingo-donde-estamos' ),
			)
		);

		$this->end_controls_section();
	}

	/* =========================================================
	 *  RENDER
	 * ========================================================= */

	private function btn_class( $style ) {
		switch ( $style ) {
			case 'outline':
				return 'btn-outline';
			case 'primary-gold':
				return 'btn-primary btn-gold';
			default:
				return 'btn-primary';
		}
	}

	private function render_button( $text, $url, $icon, $style ) {
		if ( empty( $text ) ) {
			return;
		}
		$href   = ! empty( $url['url'] ) ? $url['url'] : '#';
		$target = ! empty( $url['is_external'] ) ? ' target="_blank"' : '';
		$rel    = ! empty( $url['is_external'] ) ? ' rel="noopener"' : '';
		$class  = $this->btn_class( $style );

		echo '<a href="' . esc_url( $href ) . '"' . $target . $rel . ' class="' . esc_attr( $class ) . '">';
		if ( ! empty( $icon ) ) {
			echo $this->icon( $icon ) . ' ';
		}
		echo esc_html( $text );
		echo '</a>';
	}

	private function render_detail( $icon, $label, $text ) {
		if ( empty( $label ) && empty( $text ) ) {
			return;
		}
		echo '<div class="detail-item">';
		if ( ! empty( $icon ) ) {
			echo $this->icon( $icon );
		}
		echo '<div class="detail-text">';
		if ( ! empty( $label ) ) {
			echo '<span class="label">' . esc_html( $label ) . '</span>';
		}
		if ( ! empty( $text ) ) {
			echo '<span>' . esc_html( $text ) . '</span>';
		}
		echo '</div></div>';
	}

	private function render_legal( $raw ) {
		$raw = trim( (string) $raw );
		if ( '' === $raw ) {
			return;
		}
		echo '<div class="map-legal-notice">';
		$lines = preg_split( '/\r\n|\r|\n/', $raw );
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( '' !== $line ) {
				echo '<p>' . esc_html( $line ) . '</p>';
			}
		}
		echo '</div>';
	}

	/**
	 * Render de un bloque combinando textos (settings) + diseño fijo.
	 */
	private function render_block( $p, $s, $design, $with_divider_before ) {

		if ( $with_divider_before ) {
			echo '<div class="section-divider"></div>';
		}

		$accent_class  = ( 'fuchsia' === $design['accent'] ) ? 'blv-accent-fuchsia' : 'blv-accent-gold';
		$reverse_class = $design['reverse'] ? ' blv-reverse' : '';

		echo '<section class="location-section ' . esc_attr( $accent_class ) . $reverse_class . '">';
		echo '<div class="location-container">';

		/* ---- Tarjeta de información ---- */
		echo '<div class="location-info-card blv-reveal">';

		if ( ! empty( $s[ $p . '_badge' ] ) ) {
			echo '<span class="loc-badge label">' . esc_html( $s[ $p . '_badge' ] ) . '</span>';
		}
		if ( ! empty( $s[ $p . '_title' ] ) ) {
			echo '<h2 class="loc-title">' . esc_html( $s[ $p . '_title' ] ) . '</h2>';
		}

		if ( ! empty( $s[ $p . '_addr_main' ] ) || ! empty( $s[ $p . '_addr_sub' ] ) ) {
			echo '<div class="loc-address">';
			echo $this->icon( $design['address_icon'] );
			echo '<div>';
			if ( ! empty( $s[ $p . '_addr_main' ] ) ) {
				echo '<p class="addr-main">' . esc_html( $s[ $p . '_addr_main' ] ) . '</p>';
			}
			if ( ! empty( $s[ $p . '_addr_sub' ] ) ) {
				echo '<p>' . esc_html( $s[ $p . '_addr_sub' ] ) . '</p>';
			}
			echo '</div></div>';
		}

		echo '<div class="loc-details">';
		$this->render_detail( $design['d1_icon'], $s[ $p . '_d1_label' ] ?? '', $s[ $p . '_d1_text' ] ?? '' );
		$this->render_detail( $design['d2_icon'], $s[ $p . '_d2_label' ] ?? '', $s[ $p . '_d2_text' ] ?? '' );
		echo '</div>';

		echo '<div class="actions">';
		$this->render_button( $s[ $p . '_btn1_text' ] ?? '', $s[ $p . '_btn1_url' ] ?? array(), $design['btn1_icon'], $design['btn1_style'] );
		if ( ! empty( $design['has_btn2'] ) ) {
			$this->render_button( $s[ $p . '_btn2_text' ] ?? '', $s[ $p . '_btn2_url' ] ?? array(), '', $design['btn2_style'] );
		}
		echo '</div>';

		echo '</div>'; // .location-info-card

		/* ---- Mapa + aviso legal ---- */
		echo '<div class="map-legal-wrapper blv-reveal">';
		$this->render_legal( $s[ $p . '_legal' ] ?? '' );
		if ( ! empty( $s[ $p . '_map' ] ) ) {
			echo '<div class="map-frame">';
			echo '<iframe src="' . esc_url( $s[ $p . '_map' ] ) . '" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
			echo '</div>';
		}
		echo '</div>'; // .map-legal-wrapper

		echo '</div>'; // .location-container
		echo '</section>';
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$design = $this->block_design();

		echo '<div class="blv-widget" data-blv-anim="pending">';
		$this->render_block( 'b1', $s, $design['b1'], false );
		$this->render_block( 'b2', $s, $design['b2'], true );
		echo '</div>';
	}
}
