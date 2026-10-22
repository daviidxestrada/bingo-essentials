<?php
/**
 * Heroes de Bingo Las Vegas: texto sobre vídeo o foto.
 *
 * - "Hero portada" (Home): a sangre completa y a alto de pantalla. La línea
 *   manuscrita se escribe letra a letra con un trazo dorado y se enciende
 *   como un neón; después entran el titular, el filete y el botón.
 * - "Cabecera de página" (resto de páginas): banda más baja con el texto
 *   apoyado abajo; entra el titular, el filete, el texto y el botón.
 *
 * Comparten marcado, estilos (assets/css/video-hero.css) y secuencia
 * (assets/js/video-hero.js).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

abstract class BLV_Hero_Base_Widget extends Widget_Base {

	public function get_categories() { return array( 'blv-essentials' ); }

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-video-hero' );
	}

	public function get_script_depends() {
		return array( 'blv-be-video-hero' );
	}

	/** 'home' | 'page' */
	abstract protected function variant();

	/** Valores por defecto de cada variante. */
	abstract protected function defaults();

	protected function register_controls() {
		$d = $this->defaults();

		// ---- Textos ----
		$this->start_controls_section( 'section_text', array( 'label' => esc_html__( 'Textos', 'bingo-essentials' ) ) );
		if ( 'home' === $this->variant() ) {
			$this->add_control( 'script', array( 'label' => esc_html__( 'Línea manuscrita', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bienvenido a', 'label_block' => true, 'description' => esc_html__( 'Se escribe letra a letra en dorado. Mejor corta: 1 a 3 palabras.', 'bingo-essentials' ) ) );
		}
		$this->add_control( 'title', array( 'label' => esc_html__( 'Titular', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => $d['title'], 'label_block' => true ) );
		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__( 'Etiqueta del titular', 'bingo-essentials' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => array( 'h1' => 'H1', 'h2' => 'H2', 'p' => 'P' ),
			)
		);
		if ( 'page' === $this->variant() ) {
			$this->add_control( 'lead', array( 'label' => esc_html__( 'Texto (opcional)', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => '' ) );
		}
		$this->add_control( 'button_text', array( 'label' => esc_html__( 'Botón', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => $d['button_text'], 'separator' => 'before', 'description' => esc_html__( 'Vacío para ocultar el botón.', 'bingo-essentials' ) ) );
		$this->add_control( 'button_link', array( 'label' => esc_html__( 'Enlace del botón', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'default' => $d['button_link'] ) );
		$this->end_controls_section();

		// ---- Fondo ----
		$this->start_controls_section( 'section_video', array( 'label' => esc_html__( 'Fondo', 'bingo-essentials' ) ) );
		$this->add_control(
			'video_source',
			array(
				'label'   => esc_html__( 'Fondo', 'bingo-essentials' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $d['video_source'],
				'options' => array(
					'vimeo' => esc_html__( 'Vídeo de Vimeo', 'bingo-essentials' ),
					'file'  => esc_html__( 'Vídeo MP4 de la biblioteca', 'bingo-essentials' ),
					'none'  => esc_html__( 'Solo imagen', 'bingo-essentials' ),
				),
			)
		);
		$this->add_control( 'vimeo_url', array( 'label' => esc_html__( 'Enlace de Vimeo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => $d['vimeo_url'], 'label_block' => true, 'condition' => array( 'video_source' => 'vimeo' ) ) );
		$this->add_control( 'video_file', array( 'label' => esc_html__( 'Vídeo MP4', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'media_types' => array( 'video' ), 'condition' => array( 'video_source' => 'file' ) ) );
		$this->add_control( 'poster', array( 'label' => esc_html__( 'Imagen', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'media_types' => array( 'image' ), 'default' => array( 'url' => $d['poster'] ), 'description' => esc_html__( 'Fondo de la sección, o respaldo mientras carga el vídeo.', 'bingo-essentials' ) ) );
		$this->add_responsive_control(
			'focus_y',
			array(
				'label'       => esc_html__( 'Encuadre vertical de la imagen', 'bingo-essentials' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'range'       => array( '%' => array( 'min' => 0, 'max' => 100 ) ),
				'default'     => array( 'unit' => '%', 'size' => 50 ),
				'description' => esc_html__( '0 % enseña la parte de arriba de la foto, 100 % la de abajo. Úsalo para que se vea bien lo importante.', 'bingo-essentials' ),
				'selectors'   => array( '{{WRAPPER}} .blv-vh__poster' => 'object-position: 50% {{SIZE}}%;' ),
			)
		);
		$this->add_control(
			'scrim',
			array(
				'label'      => esc_html__( 'Oscurecer el fondo', 'bingo-essentials' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array( '%' => array( 'min' => 0, 'max' => 90 ) ),
				'default'    => array( 'unit' => '%', 'size' => $d['scrim'] ),
				'selectors'  => array( '{{WRAPPER}} .blv-vh' => '--blv-vh-scrim: {{SIZE}}%;' ),
			)
		);
		$this->end_controls_section();

		// ---- Composición ----
		$this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Composición', 'bingo-essentials' ) ) );
		if ( 'page' === $this->variant() ) {
			$this->add_control(
				'align',
				array(
					'label'   => esc_html__( 'Posición del texto', 'bingo-essentials' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'left',
					'options' => array(
						'left'   => esc_html__( 'Abajo a la izquierda', 'bingo-essentials' ),
						'center' => esc_html__( 'Centrado', 'bingo-essentials' ),
					),
				)
			);
			$this->add_control(
				'stack_mobile',
				array(
					'label'        => esc_html__( 'Móvil: imagen arriba y texto debajo', 'bingo-essentials' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Sí', 'bingo-essentials' ),
					'label_off'    => esc_html__( 'No', 'bingo-essentials' ),
					'return_value' => 'yes',
					'default'      => '',
					'description'  => esc_html__( 'Para fotos con un elemento importante (un cartel, una fachada) que el texto taparía en pantallas estrechas.', 'bingo-essentials' ),
				)
			);
			$this->add_control(
				'size',
				array(
					'label'   => esc_html__( 'Tamaño del titular', 'bingo-essentials' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'xl',
					'options' => array(
						'xl' => esc_html__( 'Grande (2 o 3 palabras)', 'bingo-essentials' ),
						'lg' => esc_html__( 'Mediano (frases)', 'bingo-essentials' ),
					),
				)
			);
		}
		$this->add_responsive_control(
			'height',
			array(
				'label'          => esc_html__( 'Alto mínimo', 'bingo-essentials' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'vh', 'px' ),
				'range'          => array( 'vh' => array( 'min' => 30, 'max' => 100 ), 'px' => array( 'min' => 280, 'max' => 1200 ) ),
				'default'        => $d['height'][0],
				'tablet_default' => $d['height'][1],
				'mobile_default' => $d['height'][2],
				'selectors'      => array( '{{WRAPPER}} .blv-vh' => 'min-height: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_control(
			'replay',
			array(
				'label'        => esc_html__( 'Animación de entrada', 'bingo-essentials' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Sí', 'bingo-essentials' ),
				'label_off'    => esc_html__( 'No', 'bingo-essentials' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$this->end_controls_section();
	}

	private function vimeo_id( $url ) {
		return preg_match( '~vimeo\.com/(?:video/)?(\d+)~', (string) $url, $m ) ? $m[1] : '';
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$variant  = $this->variant();
		$script   = 'home' === $variant ? trim( (string) ( $s['script'] ?? '' ) ) : '';
		$title    = trim( (string) ( $s['title'] ?? '' ) );
		$tag      = in_array( $s['title_tag'] ?? 'h1', array( 'h1', 'h2', 'p' ), true ) ? $s['title_tag'] : 'h1';
		$lead     = 'page' === $variant ? trim( (string) ( $s['lead'] ?? '' ) ) : '';
		$poster   = ! empty( $s['poster']['url'] ) ? $s['poster']['url'] : '';
		$source   = $s['video_source'] ?? 'none';
		$animate  = 'yes' === ( $s['replay'] ?? 'yes' );
		$btn_text = trim( (string) ( $s['button_text'] ?? '' ) );
		$btn      = $s['button_link'] ?? array();
		$align    = 'home' === $variant ? 'center' : ( 'center' === ( $s['align'] ?? 'left' ) ? 'center' : 'left' );
		$size     = 'page' === $variant && 'lg' === ( $s['size'] ?? 'xl' ) ? 'lg' : 'xl';

		$stack    = 'page' === $variant && 'yes' === ( $s['stack_mobile'] ?? '' ) ? ' blv-vh--stack-m' : '';

		echo '<section class="blv-vh blv-vh--' . esc_attr( $variant ) . ' blv-vh--' . esc_attr( $align ) . ' blv-vh--' . esc_attr( $size ) . $stack . '" data-blv-vh>';

		echo '<div class="blv-vh__media" aria-hidden="true">';
		if ( $poster ) {
			echo '<img class="blv-vh__poster" src="' . esc_url( $poster ) . '" alt="" fetchpriority="high" decoding="async">';
		}
		$id = 'vimeo' === $source ? $this->vimeo_id( $s['vimeo_url'] ?? '' ) : '';
		if ( $id ) {
			echo '<iframe class="blv-vh__video blv-vh__video--vimeo" src="https://player.vimeo.com/video/' . esc_attr( $id ) . '?background=1&autoplay=1&loop=1&muted=1&playsinline=1&dnt=1" title="" tabindex="-1" allow="autoplay; fullscreen; picture-in-picture"></iframe>';
		} elseif ( 'file' === $source && ! empty( $s['video_file']['url'] ) ) {
			echo '<video class="blv-vh__video" src="' . esc_url( $s['video_file']['url'] ) . '"' . ( $poster ? ' poster="' . esc_url( $poster ) . '"' : '' ) . ' autoplay muted loop playsinline preload="auto"></video>';
		}
		echo '<span class="blv-vh__scrim"></span>';
		echo '</div>';

		echo '<div class="blv-vh__copy">';
		if ( '' !== $script ) {
			// Texto real para lectores y buscadores; el SVG solo dibuja.
			echo '<p class="blv-vh__script"><span class="blv-vh__script-text">' . esc_html( $script ) . '</span>';
			echo '<svg class="blv-vh__script-svg" aria-hidden="true" focusable="false" data-blv-vh-svg><text class="blv-vh__measure" x="0" y="0">' . esc_html( $script ) . '</text></svg>';
			echo '</p>';
		}
		if ( '' !== $title ) {
			echo '<' . $tag . ' class="blv-vh__title" data-blv-vh-title>' . esc_html( $title ) . '</' . $tag . '>';
		}
		echo '<span class="blv-vh__rule" aria-hidden="true"></span>';
		if ( '' !== $lead ) {
			echo '<p class="blv-vh__lead">' . nl2br( esc_html( $lead ) ) . '</p>';
		}
		if ( '' !== $btn_text && ! empty( $btn['url'] ) ) {
			echo '<a class="blv-vh__button" href="' . esc_url( $btn['url'] ) . '"' . ( ! empty( $btn['is_external'] ) ? ' target="_blank" rel="noopener"' : '' ) . '>' . esc_html( $btn_text ) . '</a>';
		}
		echo '</div>';

		echo '</section>';

		// Estado inicial antes del primer pintado (si no, se vería el final y luego la entrada).
		if ( $animate ) {
			echo '<script>(function(h){if(!h||!h.classList)return;if(window.matchMedia&&matchMedia("(prefers-reduced-motion: reduce)").matches){h.classList.add("is-calm");return;}h.classList.add("is-pre");})(document.currentScript&&document.currentScript.previousElementSibling);</script>';
		}
	}
}

class BLV_Video_Hero_Widget extends BLV_Hero_Base_Widget {

	public function get_name() { return 'blv_video_hero'; }
	public function get_title() { return esc_html__( 'Hero portada Bingo Las Vegas', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-youtube'; }
	public function get_keywords() { return array( 'hero', 'portada', 'home', 'video', 'vídeo', 'bienvenido' ); }

	protected function variant() { return 'home'; }

	protected function defaults() {
		return array(
			'title'        => 'Bingo Las Vegas',
			'button_text'  => '¡Ven hoy!',
			'button_link'  => array( 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Bingo+Las+Vegas+C.+de+los+Hermanos+Garc%C3%ADa+Noblejas+17+28037+Madrid', 'is_external' => 'on' ),
			'video_source' => 'vimeo',
			'vimeo_url'    => 'https://vimeo.com/1201385334',
			'poster'       => blv_be_upload_url( '2026/04/imgbingolasvegas.webp' ),
			'scrim'        => 30,
			'height'       => array( array( 'unit' => 'vh', 'size' => 88 ), array( 'unit' => 'vh', 'size' => 70 ), array( 'unit' => 'vh', 'size' => 64 ) ),
		);
	}
}

class BLV_Page_Hero_Widget extends BLV_Hero_Base_Widget {

	public function get_name() { return 'blv_page_hero'; }
	public function get_title() { return esc_html__( 'Cabecera de página Bingo Las Vegas', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-header'; }
	public function get_keywords() { return array( 'hero', 'cabecera', 'banner', 'video', 'vídeo', 'titulo' ); }

	protected function variant() { return 'page'; }

	protected function defaults() {
		return array(
			'title'        => 'Título de la página',
			'button_text'  => '',
			'button_link'  => array( 'url' => '' ),
			'video_source' => 'none',
			'vimeo_url'    => '',
			'poster'       => blv_be_upload_url( '2026/06/1-scaled.jpg' ),
			'scrim'        => 8,
			'height'       => array( array( 'unit' => 'vh', 'size' => 58 ), array( 'unit' => 'vh', 'size' => 46 ), array( 'unit' => 'vh', 'size' => 46 ) ),
		);
	}
}
