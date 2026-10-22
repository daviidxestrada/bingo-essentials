<?php
/**
 * Widget "Pie de página" de Bingo Las Vegas.
 *
 * Todo el footer en un solo widget: franja de juego responsable, logo,
 * enlaces legales, redes, copyright (con año automático) y créditos.
 * Mismo sistema visual que el widget de cabecera.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class BLV_Site_Footer_Widget extends Widget_Base {

	public function get_name() { return 'blv_site_footer'; }
	public function get_title() { return esc_html__( 'Pie de página Bingo Las Vegas', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-footer'; }
	public function get_categories() { return array( 'blv-essentials' ); }
	public function get_keywords() { return array( 'footer', 'pie', 'legal', 'copyright', 'redes' ); }

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-site-footer' );
	}

	// El enlace activo depende de la página y el año cambia solo.
	protected function is_dynamic_content(): bool {
		return true;
	}

	private function default_links() {
		return array(
			array( 'text' => 'Política de Privacidad', 'link' => array( 'url' => home_url( '/politica-de-privacidad-2/' ) ) ),
			array( 'text' => 'Política de Cookies', 'link' => array( 'url' => home_url( '/politica-de-cookies-2/' ) ) ),
			array( 'text' => 'Aviso Legal', 'link' => array( 'url' => home_url( '/aviso-legal-2/' ) ) ),
			array( 'text' => 'Canal Ético', 'link' => array( 'url' => home_url( '/canal-etico/' ) ) ),
			array( 'text' => 'Trabaja con nosotros', 'link' => array( 'url' => home_url( '/trabaja-con-nosotros/' ) ) ),
		);
	}

	private function default_social() {
		return array(
			array( 'label' => 'Instagram', 'icon' => array( 'value' => 'ph-fill ph-instagram-logo', 'library' => 'ph-fill' ), 'link' => array( 'url' => 'https://www.instagram.com/bingolasvegas/?hl=es', 'is_external' => 'on' ), 'color' => '#262626' ),
			array( 'label' => 'Facebook', 'icon' => array( 'value' => 'ph-fill ph-facebook-logo', 'library' => 'ph-fill' ), 'link' => array( 'url' => 'https://www.facebook.com/BingoLasVegas/?locale=es_LA', 'is_external' => 'on' ), 'color' => '#3B5998' ),
			array( 'label' => 'YouTube', 'icon' => array( 'value' => 'ph-fill ph-youtube-logo', 'library' => 'ph-fill' ), 'link' => array( 'url' => 'https://www.youtube.com/@bingolasvegas1248', 'is_external' => 'on' ), 'color' => '#CD201F' ),
		);
	}

	private function default_credits() {
		return array(
			array( 'text' => 'Powered by Cloudari', 'link' => array( 'url' => '' ) ),
			array( 'text' => 'Host with ♥ by Cloudari', 'link' => array( 'url' => 'https://www.cloudari.com/', 'is_external' => 'on' ) ),
		);
	}

	private function switcher( $id, $label, $default = 'yes' ) {
		$this->add_control(
			$id,
			array(
				'label'        => $label,
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Sí', 'bingo-essentials' ),
				'label_off'    => esc_html__( 'No', 'bingo-essentials' ),
				'return_value' => 'yes',
				'default'      => $default,
			)
		);
	}

	protected function register_controls() {

		// ---- Juego responsable ----
		$this->start_controls_section( 'section_rg', array( 'label' => esc_html__( 'Juego responsable', 'bingo-essentials' ) ) );
		$this->switcher( 'show_rg', esc_html__( 'Mostrar franja', 'bingo-essentials' ) );
		$this->add_control( 'rg_badge', array( 'label' => esc_html__( 'Sello', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => '+18', 'condition' => array( 'show_rg' => 'yes' ) ) );
		$this->add_control( 'rg_text', array( 'label' => esc_html__( 'Mensaje', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Juega con responsabilidad, solo si puedes y eres mayor de 18 años', 'condition' => array( 'show_rg' => 'yes' ) ) );
		$this->add_control( 'rg_link', array( 'label' => esc_html__( 'Enlace (opcional)', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'placeholder' => 'https://www.jugarbien.es/', 'condition' => array( 'show_rg' => 'yes' ) ) );
		$this->end_controls_section();

		// ---- Logo ----
		$this->start_controls_section( 'section_logo', array( 'label' => esc_html__( 'Logo', 'bingo-essentials' ) ) );
		$this->switcher( 'show_logo', esc_html__( 'Mostrar logo', 'bingo-essentials' ) );
		$this->add_control( 'logo', array( 'label' => esc_html__( 'Logo', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'media_types' => array( 'image', 'svg' ), 'default' => array( 'url' => blv_be_upload_url( '2026/03/LOGOBINGOMATRIZ.svg' ) ), 'condition' => array( 'show_logo' => 'yes' ) ) );
		$this->add_control( 'logo_alt', array( 'label' => esc_html__( 'Texto alternativo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bingo Las Vegas', 'condition' => array( 'show_logo' => 'yes' ) ) );
		$this->end_controls_section();

		// ---- Enlaces ----
		$this->start_controls_section( 'section_links', array( 'label' => esc_html__( 'Enlaces', 'bingo-essentials' ) ) );
		$this->add_control(
			'links_source',
			array(
				'label'   => esc_html__( 'Enlaces del pie', 'bingo-essentials' ),
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
		$repeater->add_control( 'link', array( 'label' => esc_html__( 'Enlace', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '' ) ) );

		$this->add_control(
			'links',
			array(
				'label'       => esc_html__( 'Enlaces', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => $this->default_links(),
				'condition'   => array( 'links_source' => 'custom' ),
			)
		);

		$menus = array();
		foreach ( wp_get_nav_menus() as $menu ) {
			$menus[ $menu->slug ] = $menu->name;
		}
		$this->add_control( 'wp_menu', array( 'label' => esc_html__( 'Menú de WordPress', 'bingo-essentials' ), 'type' => Controls_Manager::SELECT, 'options' => $menus, 'default' => 'legal', 'condition' => array( 'links_source' => 'wp' ) ) );
		$this->end_controls_section();

		// ---- Redes ----
		$this->start_controls_section( 'section_social', array( 'label' => esc_html__( 'Redes sociales', 'bingo-essentials' ) ) );
		$this->switcher( 'show_social', esc_html__( 'Mostrar redes', 'bingo-essentials' ) );

		$social = new Repeater();
		$social->add_control( 'label', array( 'label' => esc_html__( 'Nombre', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Instagram' ) );
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
				'condition'   => array( 'show_social' => 'yes' ),
			)
		);
		$this->end_controls_section();

		// ---- Copyright y créditos ----
		$this->start_controls_section( 'section_bottom', array( 'label' => esc_html__( 'Copyright y créditos', 'bingo-essentials' ) ) );
		$this->add_control(
			'copyright',
			array(
				'label'       => esc_html__( 'Copyright', 'bingo-essentials' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '© {year} Bingo Las Vegas. Todos los derechos reservados.',
				'label_block' => true,
				'description' => esc_html__( '{year} se sustituye por el año actual.', 'bingo-essentials' ),
			)
		);

		$credits = new Repeater();
		$credits->add_control( 'text', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => '', 'label_block' => true ) );
		$credits->add_control( 'link', array( 'label' => esc_html__( 'Enlace (opcional)', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '' ) ) );

		$this->add_control(
			'credits',
			array(
				'label'       => esc_html__( 'Créditos', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $credits->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => $this->default_credits(),
			)
		);
		$this->end_controls_section();
	}

	/* =========================================================
	 *  RENDER
	 * ========================================================= */

	private function link_attrs( $link ) {
		$url = $link['url'] ?? '';
		return ' href="' . esc_url( $url ) . '"' . ( ! empty( $link['is_external'] ) ? ' target="_blank" rel="noopener"' : '' );
	}

	private function current_path() {
		$path = isset( $_SERVER['REQUEST_URI'] ) ? strtok( wp_unslash( $_SERVER['REQUEST_URI'] ), '?' ) : '/';
		return trailingslashit( strtolower( $path ) );
	}

	private function is_current( $url ) {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		return $path && trailingslashit( strtolower( $path ) ) === $this->current_path();
	}

	private function footer_links( $s ) {
		$links = array();
		if ( 'wp' === ( $s['links_source'] ?? 'custom' ) && ! empty( $s['wp_menu'] ) ) {
			foreach ( (array) wp_get_nav_menu_items( $s['wp_menu'] ) as $item ) {
				if ( ! (int) $item->menu_item_parent ) {
					$links[] = array( 'text' => $item->title, 'link' => array( 'url' => $item->url, 'is_external' => '_blank' === $item->target ) );
				}
			}
			return $links;
		}
		foreach ( (array) ( $s['links'] ?? array() ) as $item ) {
			if ( '' !== trim( (string) ( $item['text'] ?? '' ) ) && ! empty( $item['link']['url'] ) ) {
				$links[] = $item;
			}
		}
		return $links;
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$links = $this->footer_links( $s );

		echo '<div class="blv-ft">';

		// Juego responsable.
		if ( 'yes' === ( $s['show_rg'] ?? 'yes' ) && '' !== trim( (string) ( $s['rg_text'] ?? '' ) ) ) {
			$has_link = ! empty( $s['rg_link']['url'] );
			echo '<div class="blv-ft__rg">';
			echo $has_link ? '<a class="blv-ft__rg-inner"' . $this->link_attrs( $s['rg_link'] ) . '>' : '<p class="blv-ft__rg-inner">';
			if ( '' !== trim( (string) ( $s['rg_badge'] ?? '' ) ) ) {
				echo '<span class="blv-ft__badge" aria-hidden="true">' . esc_html( $s['rg_badge'] ) . '</span>';
			}
			echo '<span class="blv-ft__rg-text">' . esc_html( $s['rg_text'] ) . '</span>';
			echo $has_link ? '</a>' : '</p>';
			echo '</div>';
		}

		// Logo, enlaces y redes.
		$show_logo   = 'yes' === ( $s['show_logo'] ?? 'yes' );
		$show_social = 'yes' === ( $s['show_social'] ?? 'yes' ) && ! empty( $s['social_items'] );
		echo '<div class="blv-ft__main' . ( $show_logo ? '' : ' no-logo' ) . ( $show_social ? '' : ' no-social' ) . '"><div class="blv-ft__main-inner">';

		if ( $show_logo ) {
			$logo = ! empty( $s['logo']['url'] ) ? $s['logo']['url'] : blv_be_upload_url( '2026/03/LOGOBINGOMATRIZ.svg' );
			echo '<a class="blv-ft__logo" href="' . esc_url( home_url( '/' ) ) . '" aria-label="' . esc_attr__( 'Bingo Las Vegas, ir al inicio', 'bingo-essentials' ) . '"><img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $s['logo_alt'] ?? 'Bingo Las Vegas' ) . '" width="140" height="71" loading="lazy" decoding="async"></a>';
		}

		if ( $links ) {
			echo '<nav class="blv-ft__nav" aria-label="' . esc_attr__( 'Enlaces legales', 'bingo-essentials' ) . '"><ul class="blv-ft__links">';
			foreach ( $links as $item ) {
				$current = $this->is_current( $item['link']['url'] );
				echo '<li><a class="blv-ft__link' . ( $current ? ' is-active' : '' ) . '"' . $this->link_attrs( $item['link'] ) . ( $current ? ' aria-current="page"' : '' ) . '>' . esc_html( $item['text'] ) . '</a></li>';
			}
			echo '</ul></nav>';
		}

		if ( $show_social ) {
			echo '<ul class="blv-ft__social">';
			foreach ( $s['social_items'] as $item ) {
				if ( empty( $item['link']['url'] ) ) {
					continue;
				}
				$color = ! empty( $item['color'] ) ? $item['color'] : '#262626';
				echo '<li><a class="blv-ft__social-link"' . $this->link_attrs( $item['link'] ) . ' style="--blv-ft-social:' . esc_attr( $color ) . '" aria-label="' . esc_attr( sprintf( __( 'Bingo Las Vegas en %s', 'bingo-essentials' ), $item['label'] ?? '' ) ) . '">';
				echo blv_be_render_icon( $item['icon'] ?? array() );
				echo '</a></li>';
			}
			echo '</ul>';
		}

		echo '</div></div>';

		// Copyright y créditos.
		$copyright = str_replace( '{year}', wp_date( 'Y' ), (string) ( $s['copyright'] ?? '' ) );
		$credits   = array_filter( (array) ( $s['credits'] ?? array() ), function ( $c ) { return '' !== trim( (string) ( $c['text'] ?? '' ) ); } );
		echo '<div class="blv-ft__bottom"><div class="blv-ft__bottom-inner">';
		if ( '' !== trim( $copyright ) ) {
			echo '<p class="blv-ft__copy">' . esc_html( $copyright ) . '</p>';
		}
		if ( $credits ) {
			echo '<ul class="blv-ft__credits">';
			foreach ( $credits as $c ) {
				echo '<li>';
				echo ! empty( $c['link']['url'] ) ? '<a' . $this->link_attrs( $c['link'] ) . '>' . esc_html( $c['text'] ) . '</a>' : '<span>' . esc_html( $c['text'] ) . '</span>';
				echo '</li>';
			}
			echo '</ul>';
		}
		echo '</div></div>';

		echo '</div>';
	}
}
