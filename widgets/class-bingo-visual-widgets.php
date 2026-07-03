<?php
/**
 * Widgets visuales reutilizables de Bingo Essentials.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

abstract class BLV_Visual_Base_Widget extends Widget_Base {

	public function get_categories() {
		return array( 'blv-essentials' );
	}

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-visual-widgets-style' );
	}

	public function get_keywords() {
		return array( 'bingo', 'las vegas', 'cards', 'promociones', 'cta' );
	}

	public function get_script_depends() {
		return array( 'blv-be-visual-widgets-init' );
	}

	protected function media_url( $item, $key = 'image' ) {
		return ! empty( $item[ $key ]['url'] ) ? $item[ $key ]['url'] : '';
	}

	protected function lucide_arrow_right() {
		return '<svg class="blv26-lucide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>';
	}

	protected function link_attrs( $url ) {
		$href   = ! empty( $url['url'] ) ? $url['url'] : '#';
		$target = ! empty( $url['is_external'] ) ? ' target="_blank"' : '';
		$rel    = ! empty( $url['is_external'] ) ? ' rel="noopener"' : '';
		return ' href="' . esc_url( $href ) . '"' . $target . $rel;
	}
}

class BLV_Experiencias_Cards_Widget extends BLV_Visual_Base_Widget {

	public function get_name() { return 'blv_experiencias_cards'; }
	public function get_title() { return esc_html__( 'Cards experiencias', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Experiencias', 'bingo-essentials' ) ) );

		$repeater = new Repeater();
		$repeater->add_control( 'title', array( 'label' => esc_html__( 'Titulo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Sala del bingo', 'label_block' => true ) );
		$repeater->add_control( 'text', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Donde vive la máxima emoción y se cantan los premios más altos de Madrid.' ) );
		$repeater->add_control( 'image', array( 'label' => esc_html__( 'Imagen', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/1-scaled.jpg' ) ) );
		$repeater->add_control( 'alt', array( 'label' => esc_html__( 'Texto alternativo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Experiencia Bingo Las Vegas', 'label_block' => true ) );

		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Cards', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => $this->default_cards(),
			)
		);
		$this->end_controls_section();
	}

	private function default_cards() {
		return array(
			array( 'title' => 'Sala del bingo', 'text' => 'Donde vive la máxima emoción y se cantan los premios más altos de Madrid. Estate atento a nuestras partidas de 20.000€.', 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/1-scaled.jpg' ), 'alt' => 'Sala del bingo de Bingo Las Vegas' ),
			array( 'title' => 'Slots & Roulette Lounge', 'text' => 'Sala exclusiva con tus máquinas favoritas, la ruleta más viva: el pulso de la diversión.', 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/2-scaled.jpg' ), 'alt' => 'Slots y roulette lounge en Bingo Las Vegas' ),
			array( 'title' => 'Gastronomía', 'text' => 'Sorprendente fusión de alta gastronomía y platos tradicionales ejecutados con maestría.', 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/8.jpg' ), 'alt' => 'Gastronomía en Bingo Las Vegas' ),
			array( 'title' => 'Terraza', 'text' => 'Contamos de forma exclusiva con una terraza con techo retráctil para que en verano puedas jugar al bingo disfrutando del cielo de Madrid.', 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/4-scaled.jpg' ), 'alt' => 'Terraza de Bingo Las Vegas' ),
			array( 'title' => 'Servicios exclusivos jugadores', 'text' => 'Parking gratuito con servicio de aparca coches y más cosas que descubrirás visitándonos.', 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/5-scaled.jpg' ), 'alt' => 'Servicios exclusivos para jugadores de Bingo Las Vegas' ),
		);
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$cards = ! empty( $s['cards'] ) && is_array( $s['cards'] ) ? $s['cards'] : $this->default_cards();

		echo '<section class="blv26-exp-widget" aria-label="' . esc_attr__( 'Experiencias de Bingo Las Vegas', 'bingo-essentials' ) . '"><div class="blv26-exp-grid">';
		foreach ( $cards as $card ) {
			echo '<article class="blv26-exp-card" tabindex="0">';
			$image = $this->media_url( $card );
			if ( $image ) {
				echo '<img class="blv26-exp-image" src="' . esc_url( $image ) . '" alt="' . esc_attr( $card['alt'] ?? '' ) . '" loading="lazy" decoding="async">';
			}
			echo '<div class="blv26-exp-content">';
			echo '<h3 class="blv26-exp-title">' . esc_html( $card['title'] ?? '' ) . '</h3>';
			echo '<p class="blv26-exp-text">' . esc_html( $card['text'] ?? '' ) . '</p>';
			echo '</div></article>';
		}
		echo '</div></section>';
	}
}

class BLV_Sorteos_Promos_Widget extends BLV_Visual_Base_Widget {

	public function get_name() { return 'blv_sorteos_promos'; }
	public function get_title() { return esc_html__( 'Carrusel cards sorteos/promos', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-carousel'; }

	public function get_script_depends() {
		return array( 'blv-be-visual-widgets-init', 'blv-be-promos-lightbox' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Promociones', 'bingo-essentials' ) ) );

		$repeater = new Repeater();
		$repeater->add_control( 'image', array( 'label' => esc_html__( 'Imagen', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/L-DE-JUNIO-600X600.jpg' ) ) );
		$repeater->add_control( 'alt', array( 'label' => esc_html__( 'Texto alternativo / aria-label', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Promoción Bingo Las Vegas', 'label_block' => true ) );

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Cards', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ alt }}}',
				'default'     => $this->default_items(),
			)
		);
		$this->end_controls_section();
	}

	private function default_items() {
		return array(
			array( 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/L-DE-JUNIO-600X600.jpg' ), 'alt' => 'Promoción Bingo Las Vegas lunes de junio' ),
			array( 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/2X1-JUNIO26-Pant_Web-600x600_.jpg' ), 'alt' => 'Promoción Bingo Las Vegas 2x1 junio' ),
			array( 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/J-JUL-26__P_Web-600x600-1.jpg' ), 'alt' => 'Promoción Bingo Las Vegas jueves de julio' ),
			array( 'image' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/X-DE-JUNIO-600X600.jpg' ), 'alt' => 'Promoción Bingo Las Vegas miércoles de junio' ),
		);
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['items'] ) && is_array( $s['items'] ) ? $s['items'] : $this->default_items();

		echo '<section class="blv26-sp-widget" data-blv26-sp-widget aria-label="' . esc_attr__( 'Sorteos y promociones de Bingo Las Vegas', 'bingo-essentials' ) . '"><div class="blv26-sp-grid">';
		foreach ( $items as $item ) {
			$image = $this->media_url( $item );
			if ( ! $image ) {
				continue;
			}
			$alt = $item['alt'] ?? '';
			echo '<button class="blv26-sp-card" type="button" data-blv26-sp-src="' . esc_url( $image ) . '" data-blv26-sp-alt="' . esc_attr( $alt ) . '" aria-label="' . esc_attr( sprintf( __( 'Ver %s', 'bingo-essentials' ), $alt ) ) . '">';
			echo '<img class="blv26-sp-image" src="' . esc_url( $image ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async">';
			echo '</button>';
		}
		echo '</div><div class="blv26-sp-lightbox" data-blv26-sp-lightbox role="dialog" aria-modal="true" aria-hidden="true"><div class="blv26-sp-lightbox-dialog"><button class="blv26-sp-lightbox-close" type="button" data-blv26-sp-close aria-label="' . esc_attr__( 'Cerrar imagen', 'bingo-essentials' ) . '">&times;</button><img class="blv26-sp-lightbox-image" data-blv26-sp-image src="" alt=""></div></div></section>';
	}
}

class BLV_Arrow_Link_Widget extends BLV_Visual_Base_Widget {

	public function get_name() { return 'blv_arrow_link'; }
	public function get_title() { return esc_html__( 'Enlace con flecha underline', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-link'; }

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Enlace', 'bingo-essentials' ) ) );
		$this->add_control( 'text', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Descubre Bingo Las Vegas', 'label_block' => true ) );
		$this->add_control(
			'url',
			array(
				'label'       => esc_html__( 'URL', 'bingo-essentials' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://...',
				'default'     => array( 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Bingo+Las+Vegas+C.+de+los+Hermanos+Garc%C3%ADa+Noblejas+17+28037+Madrid', 'is_external' => 'on' ),
			)
		);
		$this->add_control(
			'tone',
			array(
				'label'   => esc_html__( 'Color', 'bingo-essentials' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'green',
				'options' => array(
					'green'   => esc_html__( 'Verde', 'bingo-essentials' ),
					'gold'    => esc_html__( 'Oro', 'bingo-essentials' ),
					'fuchsia' => esc_html__( 'Fucsia', 'bingo-essentials' ),
					'white'   => esc_html__( 'Blanco', 'bingo-essentials' ),
				),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$tone = ! empty( $s['tone'] ) ? $s['tone'] : 'green';

		echo '<a class="blv26-arrow-link blv26-arrow-link--' . esc_attr( $tone ) . '"' . $this->link_attrs( $s['url'] ?? array() ) . '>';
		echo '<span>' . esc_html( $s['text'] ?? '' ) . '</span>' . $this->lucide_arrow_right();
		echo '</a>';
	}
}

class BLV_Partidas_Especiales_Widget extends BLV_Visual_Base_Widget {

	public function get_name() { return 'blv_partidas_especiales'; }
	public function get_title() { return esc_html__( 'Partidas especiales', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-image-rollover'; }

	public function get_script_depends() {
		return array( 'blv-be-visual-widgets-init', 'blv-be-premios-lightbox' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Contenido', 'bingo-essentials' ) ) );
		$this->add_control( 'eyebrow', array( 'label' => esc_html__( 'Etiqueta superior', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bingo Las Vegas', 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Titulo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Partidas especiales', 'label_block' => true ) );
		$this->add_control( 'poster', array( 'label' => esc_html__( 'Cartel', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/premios.jpg' ) ) );
		$this->add_control( 'poster_alt', array( 'label' => esc_html__( 'Texto alternativo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Cartel de partidas especiales de Bingo Las Vegas', 'label_block' => true ) );
		$this->add_control( 'lightbox_label', array( 'label' => esc_html__( 'Etiqueta del visor', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Cartel ampliado de partidas especiales', 'label_block' => true ) );
		$this->end_controls_section();
	}

	protected function render() {
		$s              = $this->get_settings_for_display();
		$title_id       = 'blv26-premios-title-' . $this->get_id();
		$image          = ! empty( $s['poster']['url'] ) ? $s['poster']['url'] : 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/premios.jpg';
		$alt            = ! empty( $s['poster_alt'] ) ? $s['poster_alt'] : __( 'Cartel de partidas especiales de Bingo Las Vegas', 'bingo-essentials' );
		$lightbox_label = ! empty( $s['lightbox_label'] ) ? $s['lightbox_label'] : __( 'Cartel ampliado de partidas especiales', 'bingo-essentials' );

		echo '<section class="blv26-premios-widget" data-blv26-premios-widget aria-labelledby="' . esc_attr( $title_id ) . '">';
		echo '<div class="blv26-premios-container">';
		echo '<div class="blv26-premios-content">';
		echo '<span class="blv26-premios-eyebrow">' . esc_html( $s['eyebrow'] ?? '' ) . '</span>';
		echo '<h2 id="' . esc_attr( $title_id ) . '" class="blv26-premios-title">' . esc_html( $s['title'] ?? '' ) . '</h2>';
		echo '<div class="blv26-premios-line" aria-hidden="true"></div>';
		echo '</div>';
		echo '<figure class="blv26-premios-poster-wrap"><div class="blv26-premios-poster-stage">';
		echo '<button class="blv26-premios-poster-button" type="button" data-blv26-premios-open aria-label="' . esc_attr__( 'Ampliar cartel de partidas especiales', 'bingo-essentials' ) . '">';
		echo '<img class="blv26-premios-poster" src="' . esc_url( $image ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async">';
		echo '</button>';
		echo '</div></figure>';
		echo '</div>';
		echo '<div class="blv26-premios-lightbox" data-blv26-premios-lightbox role="dialog" aria-modal="true" aria-hidden="true" aria-label="' . esc_attr( $lightbox_label ) . '">';
		echo '<div class="blv26-premios-lightbox-dialog">';
		echo '<button class="blv26-premios-lightbox-close" type="button" data-blv26-premios-close aria-label="' . esc_attr__( 'Cerrar imagen', 'bingo-essentials' ) . '">&times;</button>';
		echo '<img class="blv26-premios-lightbox-image" data-blv26-premios-image src="" alt="' . esc_attr( $alt ) . '">';
		echo '</div></div>';
		echo '</section>';
	}
}

class BLV_Carta_Widget extends BLV_Visual_Base_Widget {

	public function get_name() { return 'blv_carta'; }
	public function get_title() { return esc_html__( 'Carta', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-document-file'; }

	public function get_script_depends() {
		return array( 'blv-be-carta-pdf-viewer' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Contenido', 'bingo-essentials' ) ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Titulo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Descubre nuestra oferta gastronómica', 'label_block' => true ) );
		$this->add_control( 'intro', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Consulta nuestra carta, las bebidas y la información de alérgenos directamente desde la página.' ) );
		$this->add_control( 'note', array( 'label' => esc_html__( 'Nota inferior', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Según Reglamento 1169/2011 sobre la información alimentaria facilitada al consumidor. En todos los platos, pueden existir trazas accidentales de alérgenos debido a haber sido elaborados en el mismo espacio físico.' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'pdfs', array( 'label' => esc_html__( 'PDFs', 'bingo-essentials' ) ) );
		$this->add_control( 'carta_label', array( 'label' => esc_html__( 'Pestaña carta', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Carta', 'label_block' => true ) );
		$this->add_control( 'carta_title', array( 'label' => esc_html__( 'Titulo carta', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Carta', 'label_block' => true ) );
		$this->add_control( 'carta_pdf', array( 'label' => esc_html__( 'PDF carta', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/Carta.BINGO_.2026.pdf' ) ) );
		$this->add_control( 'bebidas_label', array( 'label' => esc_html__( 'Pestaña bebidas', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bebidas', 'label_block' => true, 'separator' => 'before' ) );
		$this->add_control( 'bebidas_title', array( 'label' => esc_html__( 'Titulo bebidas', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Carta de bebidas', 'label_block' => true ) );
		$this->add_control( 'bebidas_pdf', array( 'label' => esc_html__( 'PDF bebidas', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/Bebidas.BINGO_.2026.pdf' ) ) );
		$this->add_control( 'alergenos_label', array( 'label' => esc_html__( 'Pestaña alérgenos', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Alérgenos', 'label_block' => true, 'separator' => 'before' ) );
		$this->add_control( 'alergenos_title', array( 'label' => esc_html__( 'Titulo alérgenos', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Carta de alérgenos', 'label_block' => true ) );
		$this->add_control( 'alergenos_pdf', array( 'label' => esc_html__( 'PDF alérgenos', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://des.bingolasvegas.es/wp-content/uploads/2026/06/carta.alergenos.2026.pdf' ) ) );
		$this->add_control( 'skip_alergenos_first_page', array( 'label' => esc_html__( 'Ocultar primera página de alérgenos', 'bingo-essentials' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Sí', 'bingo-essentials' ), 'label_off' => esc_html__( 'No', 'bingo-essentials' ), 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->end_controls_section();
	}

	private function pdf_url( $settings, $key ) {
		return ! empty( $settings[ $key ]['url'] ) ? $settings[ $key ]['url'] : '';
	}

	private function doc_icon() {
		return '<svg class="blv26pdf-tab-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>';
	}

	private function drink_icon() {
		return '<svg class="blv26pdf-tab-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M8 22h8"></path><path d="M7 10h10"></path><path d="M12 15v7"></path><path d="M12 15a5 5 0 0 0 5-5c0-2-2-6-2-6H9s-2 4-2 6a5 5 0 0 0 5 5Z"></path></svg>';
	}

	private function warning_icon() {
		return '<svg class="blv26pdf-tab-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>';
	}

	private function close_icon() {
		return '<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>';
	}

	private function render_tab( $kind, $label, $icon, $active, $uid ) {
		echo '<button class="blv26pdf-tab' . ( $active ? ' is-active' : '' ) . '" type="button" id="blv26pdf-tab-' . esc_attr( $kind . '-' . $uid ) . '" aria-current="' . ( $active ? 'true' : 'false' ) . '" aria-controls="blv26pdf-panel-' . esc_attr( $kind . '-' . $uid ) . '" data-blv26pdf-tab data-pdf-kind="' . esc_attr( $kind ) . '">';
		echo $icon . esc_html( $label );
		echo '</button>';
	}

	private function render_panel( $kind, $title, $fallback, $active, $uid, $skip_first = false ) {
		echo '<article class="blv26pdf-panel is-loading' . ( $active ? ' is-active' : '' ) . '" id="blv26pdf-panel-' . esc_attr( $kind . '-' . $uid ) . '" aria-labelledby="blv26pdf-tab-' . esc_attr( $kind . '-' . $uid ) . '" data-pdf-panel="' . esc_attr( $kind ) . '"' . ( $active ? '' : ' hidden' ) . '>';
		echo '<div class="blv26pdf-toolbar"><div><h3>' . esc_html( $title ) . '</h3></div></div>';
		echo '<div class="blv26pdf-pages" data-pdf-pages="' . esc_attr( $kind ) . '"' . ( $skip_first ? ' data-skip-first-page="true"' : '' ) . ' aria-label="' . esc_attr( sprintf( __( 'Páginas de %s', 'bingo-essentials' ), $title ) ) . '">';
		echo '<p class="blv26pdf-fallback">' . esc_html( $fallback ) . '</p>';
		echo '</div></article>';
	}

	protected function render() {
		$s   = $this->get_settings_for_display();
		$uid = $this->get_id();

		echo '<section class="blv26pdf-widget" data-blv26pdf-widget data-pdf-carta-url="' . esc_url( $this->pdf_url( $s, 'carta_pdf' ) ) . '" data-pdf-bebidas-url="' . esc_url( $this->pdf_url( $s, 'bebidas_pdf' ) ) . '" data-pdf-alergenos-url="' . esc_url( $this->pdf_url( $s, 'alergenos_pdf' ) ) . '">';
		echo '<div class="blv26pdf-shell">';
		echo '<div class="blv26pdf-head"><h2 class="blv26pdf-title">' . esc_html( $s['title'] ?? '' ) . '</h2><p class="blv26pdf-text">' . esc_html( $s['intro'] ?? '' ) . '</p></div>';
		echo '<div class="blv26pdf-tabs" role="navigation" aria-label="' . esc_attr__( 'Cartas disponibles', 'bingo-essentials' ) . '">';
		$this->render_tab( 'carta', $s['carta_label'] ?? 'Carta', $this->doc_icon(), true, $uid );
		$this->render_tab( 'bebidas', $s['bebidas_label'] ?? 'Bebidas', $this->drink_icon(), false, $uid );
		$this->render_tab( 'alergenos', $s['alergenos_label'] ?? 'Alérgenos', $this->warning_icon(), false, $uid );
		echo '</div><div class="blv26pdf-panels">';
		$this->render_panel( 'carta', $s['carta_title'] ?? 'Carta', __( 'No se ha podido cargar la carta.', 'bingo-essentials' ), true, $uid );
		$this->render_panel( 'bebidas', $s['bebidas_title'] ?? 'Carta de bebidas', __( 'No se ha podido cargar la carta de bebidas.', 'bingo-essentials' ), false, $uid );
		$this->render_panel( 'alergenos', $s['alergenos_title'] ?? 'Carta de alérgenos', __( 'No se ha podido cargar la carta de alérgenos.', 'bingo-essentials' ), false, $uid, ( 'yes' === ( $s['skip_alergenos_first_page'] ?? '' ) ) );
		echo '</div>';
		if ( ! empty( $s['note'] ) ) {
			echo '<p class="blv26pdf-note">' . esc_html( $s['note'] ) . '</p>';
		}
		echo '</div>';
		echo '<div class="blv26pdf-zoom" data-pdf-zoom aria-hidden="true"><button class="blv26pdf-zoom-close" type="button" data-pdf-zoom-close aria-label="' . esc_attr__( 'Cerrar imagen ampliada', 'bingo-essentials' ) . '">' . $this->close_icon() . '</button><img src="" alt="" data-pdf-zoom-img></div>';
		echo '</section>';
	}
}
