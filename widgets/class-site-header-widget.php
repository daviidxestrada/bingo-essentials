<?php
/**
 * Widget "Cabecera" de Bingo Las Vegas.
 *
 * Toda la cabecera del sitio en un solo widget: logo, menú y redes.
 * El menú pasa a modo hamburguesa por sí solo cuando los enlaces no
 * caben en la barra, así que se pueden añadir o quitar enlaces y redes
 * sin romper el diseño en ninguna resolución.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class BLV_Site_Header_Widget extends Widget_Base {

	public function get_name() { return 'blv_site_header'; }
	public function get_title() { return esc_html__( 'Cabecera Bingo Las Vegas', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-header'; }
	public function get_categories() { return array( 'blv-essentials' ); }
	public function get_keywords() { return array( 'header', 'cabecera', 'menu', 'menú', 'logo', 'redes' ); }

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-site-header' );
	}

	public function get_script_depends() {
		return array( 'blv-be-site-header' );
	}

	// El enlace activo depende de la página que se está viendo.
	protected function is_dynamic_content(): bool {
		return true;
	}

	private function default_menu() {
		return array(
			array( 'text' => 'Dónde Estamos', 'link' => array( 'url' => home_url( '/donde-estamos/' ) ) ),
			array( 'text' => 'Carta', 'link' => array( 'url' => home_url( '/carta/' ) ) ),
			array( 'text' => 'Nuestra Historia', 'link' => array( 'url' => home_url( '/nuestra-historia/' ) ) ),
			array( 'text' => 'Trabaja con nosotros', 'link' => array( 'url' => home_url( '/trabaja-con-nosotros/' ) ) ),
			array( 'text' => 'Contacto', 'link' => array( 'url' => home_url( '/contacto/' ) ) ),
		);
	}

	private function default_social() {
		return array(
			array(
				'label' => 'Instagram',
				'icon'  => array( 'value' => 'ph-fill ph-instagram-logo', 'library' => 'ph-fill' ),
				'link'  => array( 'url' => 'https://www.instagram.com/bingolasvegas/?hl=es', 'is_external' => 'on' ),
				'color' => '#262626',
			),
			array(
				'label' => 'Facebook',
				'icon'  => array( 'value' => 'ph-fill ph-facebook-logo', 'library' => 'ph-fill' ),
				'link'  => array( 'url' => 'https://www.facebook.com/BingoLasVegas/?locale=es_LA', 'is_external' => 'on' ),
				'color' => '#3B5998',
			),
			array(
				'label' => 'YouTube',
				'icon'  => array( 'value' => 'ph-fill ph-youtube-logo', 'library' => 'ph-fill' ),
				'link'  => array( 'url' => 'https://www.youtube.com/@bingolasvegas1248', 'is_external' => 'on' ),
				'color' => '#CD201F',
			),
		);
	}

	private function menu_options() {
		$options = array();
		foreach ( wp_get_nav_menus() as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
	}

	protected function register_controls() {

		// ---- Logo ----
		$this->start_controls_section( 'section_logo', array( 'label' => esc_html__( 'Logo', 'bingo-essentials' ) ) );
		$this->add_control(
			'logo',
			array(
				'label'       => esc_html__( 'Logo', 'bingo-essentials' ),
				'type'        => Controls_Manager::MEDIA,
				'media_types' => array( 'image', 'svg' ),
				'default'     => array( 'url' => blv_be_upload_url( '2026/03/LOGOBINGOMATRIZ.svg' ) ),
			)
		);
		$this->add_control(
			'logo_alt',
			array(
				'label'       => esc_html__( 'Texto alternativo', 'bingo-essentials' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Bingo Las Vegas',
				'label_block' => true,
			)
		);
		$this->add_control(
			'logo_link',
			array(
				'label'       => esc_html__( 'Enlace del logo', 'bingo-essentials' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => home_url( '/' ),
				'description' => esc_html__( 'Vacío: lleva a la página de inicio.', 'bingo-essentials' ),
			)
		);
		$this->add_responsive_control(
			'logo_width',
			array(
				'label'          => esc_html__( 'Ancho del logo', 'bingo-essentials' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array( 'px' => array( 'min' => 60, 'max' => 260 ) ),
				'default'        => array( 'unit' => 'px', 'size' => 150 ),
				'tablet_default' => array( 'unit' => 'px', 'size' => 128 ),
				'mobile_default' => array( 'unit' => 'px', 'size' => 112 ),
				'selectors'      => array( '{{WRAPPER}} .blv-hd' => '--blv-hd-logo: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->end_controls_section();

		// ---- Menú ----
		$this->start_controls_section( 'section_menu', array( 'label' => esc_html__( 'Menú', 'bingo-essentials' ) ) );
		$this->add_control(
			'menu_source',
			array(
				'label'   => esc_html__( 'Enlaces del menú', 'bingo-essentials' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'custom' => esc_html__( 'Los de este widget', 'bingo-essentials' ),
					'wp'     => esc_html__( 'Un menú de WordPress (Apariencia → Menús)', 'bingo-essentials' ),
				),
			)
		);

		$repeater = new Repeater();
		$repeater->add_control( 'text', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Nuevo enlace', 'bingo-essentials' ), 'label_block' => true ) );
		$repeater->add_control( 'link', array( 'label' => esc_html__( 'Enlace', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'placeholder' => home_url( '/pagina/' ), 'default' => array( 'url' => '' ) ) );

		$this->add_control(
			'menu_items',
			array(
				'label'       => esc_html__( 'Enlaces', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => $this->default_menu(),
				'condition'   => array( 'menu_source' => 'custom' ),
			)
		);

		$this->add_control(
			'wp_menu',
			array(
				'label'     => esc_html__( 'Menú de WordPress', 'bingo-essentials' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->menu_options(),
				'default'   => 'menu-principal',
				'condition' => array( 'menu_source' => 'wp' ),
			)
		);

		$this->add_control(
			'collapse',
			array(
				'label'       => esc_html__( 'Menú hamburguesa', 'bingo-essentials' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'auto',
				'options'     => array(
					'auto'   => esc_html__( 'Automático: cuando los enlaces no caben', 'bingo-essentials' ),
					'tablet' => esc_html__( 'Siempre en tablet y móvil', 'bingo-essentials' ),
					'mobile' => esc_html__( 'Siempre en móvil', 'bingo-essentials' ),
				),
				'description' => esc_html__( 'En cualquier opción, si los enlaces no caben en la barra el menú se recoge solo.', 'bingo-essentials' ),
				'separator'   => 'before',
			)
		);
		$this->end_controls_section();

		// ---- Redes ----
		$this->start_controls_section( 'section_social', array( 'label' => esc_html__( 'Redes sociales', 'bingo-essentials' ) ) );

		$social = new Repeater();
		$social->add_control( 'label', array( 'label' => esc_html__( 'Nombre', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Instagram', 'description' => esc_html__( 'Lo leen los lectores de pantalla: "Bingo Las Vegas en Instagram".', 'bingo-essentials' ) ) );
		$social->add_control( 'icon', array( 'label' => esc_html__( 'Icono', 'bingo-essentials' ), 'type' => Controls_Manager::ICONS, 'default' => array( 'value' => 'ph-fill ph-instagram-logo', 'library' => 'ph-fill' ), 'recommended' => array( 'ph-fill' => array( 'instagram-logo', 'facebook-logo', 'youtube-logo', 'tiktok-logo', 'x-logo', 'whatsapp-logo', 'linkedin-logo', 'spotify-logo', 'phone', 'envelope-simple', 'map-pin' ) ) ) );
		$social->add_control( 'link', array( 'label' => esc_html__( 'Enlace', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '', 'is_external' => 'on' ) ) );
		$social->add_control( 'color', array( 'label' => esc_html__( 'Color del círculo', 'bingo-essentials' ), 'type' => Controls_Manager::COLOR, 'default' => '#262626' ) );

		$this->add_control(
			'social_items',
			array(
				'label'       => esc_html__( 'Botones', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => $this->default_social(),
			)
		);
		$this->end_controls_section();

		// ---- Comportamiento ----
		$this->start_controls_section( 'section_behaviour', array( 'label' => esc_html__( 'Comportamiento', 'bingo-essentials' ) ) );
		$this->add_control(
			'fixed_header',
			array(
				'label'        => esc_html__( 'Fija al hacer scroll', 'bingo-essentials' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Sí', 'bingo-essentials' ),
				'label_off'    => esc_html__( 'No', 'bingo-essentials' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$this->end_controls_section();
	}

	/* =========================================================
	 *  RENDER
	 * ========================================================= */

	private function normalize_url( $url ) {
		$parts = wp_parse_url( $url );
		$path  = isset( $parts['path'] ) ? trailingslashit( $parts['path'] ) : '/';
		return strtolower( ( $parts['host'] ?? '' ) . $path );
	}

	private function current_url() {
		$host = wp_parse_url( home_url(), PHP_URL_HOST );
		$path = isset( $_SERVER['REQUEST_URI'] ) ? strtok( wp_unslash( $_SERVER['REQUEST_URI'] ), '?' ) : '/';
		return strtolower( $host . trailingslashit( $path ) );
	}

	/**
	 * Lista de enlaces normalizada: [ text, url, external, active, children[] ].
	 */
	private function menu_links( $s ) {
		$current = $this->current_url();
		$links   = array();

		if ( 'wp' === ( $s['menu_source'] ?? 'custom' ) && ! empty( $s['wp_menu'] ) ) {
			$items = wp_get_nav_menu_items( $s['wp_menu'] );
			$by_id = array();
			foreach ( (array) $items as $item ) {
				$by_id[ $item->ID ] = array(
					'text'     => $item->title,
					'url'      => $item->url,
					'external' => '_blank' === $item->target,
					'active'   => $this->normalize_url( $item->url ) === $current,
					'children' => array(),
					'parent'   => (int) $item->menu_item_parent,
				);
			}
			foreach ( $by_id as $id => $link ) {
				if ( $link['parent'] && isset( $by_id[ $link['parent'] ] ) ) {
					$by_id[ $link['parent'] ]['children'][] = $link;
					if ( $link['active'] ) {
						$by_id[ $link['parent'] ]['active'] = true;
					}
				}
			}
			foreach ( $by_id as $link ) {
				if ( ! $link['parent'] ) {
					$links[] = $link;
				}
			}
			return $links;
		}

		$items = ! empty( $s['menu_items'] ) && is_array( $s['menu_items'] ) ? $s['menu_items'] : array();
		foreach ( $items as $item ) {
			$text = trim( (string) ( $item['text'] ?? '' ) );
			$url  = $item['link']['url'] ?? '';
			if ( '' === $text || '' === $url ) {
				continue;
			}
			$links[] = array(
				'text'     => $text,
				'url'      => $url,
				'external' => ! empty( $item['link']['is_external'] ),
				'active'   => $this->normalize_url( $url ) === $current,
				'children' => array(),
			);
		}
		return $links;
	}

	private function render_links( $links, $class, $caret = false ) {
		echo '<ul class="' . esc_attr( $class ) . '">';
		foreach ( $links as $link ) {
			$has_children = ! empty( $link['children'] );
			echo '<li class="blv-hd__item' . ( $has_children ? ' has-children' : '' ) . '">';
			echo '<a class="blv-hd__link' . ( $link['active'] ? ' is-active' : '' ) . '" href="' . esc_url( $link['url'] ) . '"' . ( $link['active'] ? ' aria-current="page"' : '' ) . ( $link['external'] ? ' target="_blank" rel="noopener"' : '' ) . '><span>' . esc_html( $link['text'] ) . '</span>' . ( $caret ? blv_be_icon( 'caret-right', 'blv-hd__caret' ) : '' ) . '</a>';
			if ( $has_children ) {
				$this->render_links( $link['children'], 'blv-hd__sub', $caret );
			}
			echo '</li>';
		}
		echo '</ul>';
	}

	private function render_social( $items, $class ) {
		if ( ! $items ) {
			return;
		}
		echo '<ul class="' . esc_attr( $class ) . '">';
		foreach ( $items as $item ) {
			$url = $item['link']['url'] ?? '';
			if ( '' === $url ) {
				continue;
			}
			$label = trim( (string) ( $item['label'] ?? '' ) );
			$color = ! empty( $item['color'] ) ? $item['color'] : '#262626';
			echo '<li><a class="blv-hd__social-link" href="' . esc_url( $url ) . '"' . ( ! empty( $item['link']['is_external'] ) ? ' target="_blank" rel="noopener"' : '' ) . ' style="--blv-hd-social:' . esc_attr( $color ) . '" aria-label="' . esc_attr( sprintf( __( 'Bingo Las Vegas en %s', 'bingo-essentials' ), $label ) ) . '">';
			echo blv_be_render_icon( $item['icon'] ?? array() );
			echo '</a></li>';
		}
		echo '</ul>';
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$uid      = 'blv-hd-' . $this->get_id();
		$links    = $this->menu_links( $s );
		$social   = ! empty( $s['social_items'] ) && is_array( $s['social_items'] ) ? $s['social_items'] : array();
		$logo     = ! empty( $s['logo']['url'] ) ? $s['logo']['url'] : blv_be_upload_url( '2026/03/LOGOBINGOMATRIZ.svg' );
		$home     = ! empty( $s['logo_link']['url'] ) ? $s['logo_link']['url'] : home_url( '/' );
		$collapse = in_array( $s['collapse'] ?? 'auto', array( 'auto', 'tablet', 'mobile' ), true ) ? $s['collapse'] : 'auto';
		$sticky   = 'yes' === ( $s['fixed_header'] ?? 'yes' ) ? 'yes' : 'no';

		echo '<div class="blv-hd" data-blv-hd data-collapse="' . esc_attr( $collapse ) . '" data-sticky="' . esc_attr( $sticky ) . '">';
		echo '<div class="blv-hd__bar">';

		echo '<a class="blv-hd__logo" href="' . esc_url( $home ) . '" aria-label="' . esc_attr__( 'Bingo Las Vegas, ir al inicio', 'bingo-essentials' ) . '">';
		echo '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $s['logo_alt'] ?? 'Bingo Las Vegas' ) . '" width="150" height="76" decoding="async">';
		echo '</a>';

		echo '<nav class="blv-hd__nav" aria-label="' . esc_attr__( 'Menú principal', 'bingo-essentials' ) . '" data-blv-hd-nav>';
		$this->render_links( $links, 'blv-hd__menu' );
		echo '</nav>';

		echo '<div class="blv-hd__end">';
		$this->render_social( $social, 'blv-hd__social' );
		echo '<button class="blv-hd__toggle" type="button" aria-expanded="false" aria-controls="' . esc_attr( $uid ) . '-drawer" data-blv-hd-toggle>';
		echo '<span class="blv-hd__burger" aria-hidden="true">' . blv_be_icon( 'list', 'blv-hd__burger-open' ) . blv_be_icon( 'x', 'blv-hd__burger-close' ) . '</span>';
		echo '<span class="blv-hd__toggle-text" data-blv-hd-toggle-text>' . esc_html__( 'Menú', 'bingo-essentials' ) . '</span>';
		echo '</button>';
		echo '</div>';

		echo '</div>';

		echo '<div class="blv-hd__drawer" id="' . esc_attr( $uid ) . '-drawer" data-blv-hd-drawer>';
		echo '<nav class="blv-hd__drawer-nav" aria-label="' . esc_attr__( 'Menú principal', 'bingo-essentials' ) . '">';
		$this->render_links( $links, 'blv-hd__drawer-menu', true );
		echo '</nav>';
		$this->render_social( $social, 'blv-hd__social blv-hd__social--drawer' );
		echo '</div>';

		echo '</div>';

		/*
		 * Decide el modo antes del primer pintado para que no "salte":
		 *  - centrado: logo | menú centrado | redes
		 *  - is-tight: el menú no cabe centrado y se pega al logo
		 *  - is-compact: no cabe ni así (o la pantalla es pequeña) → hamburguesa
		 * assets/js/site-header.js reutiliza esta función al redimensionar.
		 */
		echo '<script>(function(h){var f=window.BLVHeaderFit=window.BLVHeaderFit||function(h){var b=h.querySelector(".blv-hd__bar"),l=h.querySelector(".blv-hd__logo"),m=h.querySelector(".blv-hd__menu"),s=h.querySelector(".blv-hd__bar .blv-hd__social");if(!b||!l||!m)return;var w=window.innerWidth,c=h.getAttribute("data-collapse"),cs=getComputedStyle(b),g=parseFloat(cs.columnGap)||32,a=b.clientWidth-parseFloat(cs.paddingLeft)-parseFloat(cs.paddingRight),lw=l.offsetWidth,sw=s?s.offsetWidth:0,mw=m.scrollWidth,force=w<=767||(c==="tablet"&&w<=1024);var center=!force&&mw+2*Math.max(lw,sw)+2*g<=a,tight=!force&&!center&&lw+mw+sw+2*g<=a;h.classList.toggle("is-tight",tight);h.classList.toggle("is-compact",!center&&!tight);h.classList.add("is-fitted");};f(h);})(document.currentScript&&document.currentScript.previousElementSibling);</script>';
	}
}
