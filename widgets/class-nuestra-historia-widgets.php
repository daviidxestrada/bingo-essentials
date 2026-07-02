<?php
/**
 * Widgets de Elementor: Bingo Las Vegas - Nuestra Historia.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

abstract class BLV_Historia_Base_Widget extends Widget_Base {

	public function get_categories() {
		return array( 'blv-essentials' );
	}

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-history-style' );
	}

	public function get_script_depends() {
		return array( 'blv-de-gsap', 'blv-de-scrolltrigger', 'blv-be-history-init' );
	}

	public function get_keywords() {
		return array( 'bingo', 'historia', 'nuestra historia', 'las vegas' );
	}

	protected function text_control( $id, $label, $default, $type = Controls_Manager::TEXTAREA ) {
		$args = array(
			'label'       => $label,
			'type'        => $type,
			'default'     => $default,
			'label_block' => true,
		);

		if ( Controls_Manager::TEXTAREA === $type ) {
			$args['rows'] = 5;
		}

		$this->add_control( $id, $args );
	}

	protected function media_control( $id, $label, $default_url ) {
		$this->add_control(
			$id,
			array(
				'label'   => $label,
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => $default_url,
				),
			)
		);
	}

	protected function image_url( $settings, $key ) {
		if ( ! empty( $settings[ $key ]['url'] ) ) {
			return $settings[ $key ]['url'];
		}
		return '';
	}

	protected function paragraphs( $raw ) {
		$raw = trim( (string) $raw );
		if ( '' === $raw ) {
			return;
		}
		$parts = preg_split( "/\n\s*\n/", $raw );
		foreach ( $parts as $part ) {
			$part = trim( $part );
			if ( '' !== $part ) {
				echo '<p>' . wp_kses_post( nl2br( esc_html( $part ) ) ) . '</p>';
			}
		}
	}

	protected function render_shell( $classes, $content_callback ) {
		echo '<div class="blv-history-widget" data-blv-history-anim="pending">';
		echo '<section class="' . esc_attr( $classes ) . '">';
		call_user_func( $content_callback );
		echo '</section></div>';
	}
}

class BLV_Historia_Hero_Widget extends BLV_Historia_Base_Widget {

	public function get_name() {
		return 'blv_historia_hero';
	}

	public function get_title() {
		return esc_html__( 'Hero - Nuestra Historia', 'bingo-essentials' );
	}

	public function get_icon() {
		return 'eicon-image-bold';
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Contenido', 'bingo-essentials' ) ) );
		$this->text_control( 'title', esc_html__( 'Titulo', 'bingo-essentials' ), 'Nuestra Historia', Controls_Manager::TEXT );
		$this->text_control( 'subtitle', esc_html__( 'Texto', 'bingo-essentials' ), "Bingo Las Vegas, situado en el distrito madrileño de Ciudad Lineal, es mucho más que una sala de Bingo: es una auténtica institución del ocio en Madrid, famosa por repartir los mayores premios de Madrid, por nuestra oferta gastronómica y por mezclar el juego con el glamour de la televisión, las celebridades y las redes sociales.\n\nEsta es la historia de nuestra sala." );
		$this->media_control( 'image', esc_html__( 'Imagen de fondo', 'bingo-essentials' ), 'https://images.unsplash.com/photo-1596838132731-3301c3fd4317?auto=format&fit=crop&q=80&w=2070' );
		$this->end_controls_section();
	}

	protected function render() {
		$s   = $this->get_settings_for_display();
		$img = $this->image_url( $s, 'image' );
		$this->render_shell(
			'blv-history-hero',
			function () use ( $s, $img ) {
				echo '<div class="blv-history-hero-bg" style="background-image:url(' . esc_url( $img ) . ')"></div>';
				echo '<div class="blv-history-hero-overlay"></div>';
				echo '<div class="blv-history-hero-content blv-history-reveal">';
				echo '<h1>' . esc_html( $s['title'] ) . '</h1>';
				echo '<div class="blv-history-lead">';
				$this->paragraphs( $s['subtitle'] );
				echo '</div></div>';
			}
		);
	}
}

abstract class BLV_Historia_Split_Widget extends BLV_Historia_Base_Widget {

	protected $defaults = array();

	protected function register_controls() {
		$d = $this->defaults;
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Contenido', 'bingo-essentials' ) ) );
		if ( ! empty( $d['tag'] ) ) {
			$this->text_control( 'tag', esc_html__( 'Etiqueta', 'bingo-essentials' ), $d['tag'], Controls_Manager::TEXT );
		}
		$this->text_control( 'title', esc_html__( 'Titulo', 'bingo-essentials' ), $d['title'], Controls_Manager::TEXT );
		$this->text_control( 'body', esc_html__( 'Texto', 'bingo-essentials' ), $d['body'] );
		$this->media_control( 'image', esc_html__( 'Imagen', 'bingo-essentials' ), $d['image'] );
		$this->add_control(
			'alt',
			array(
				'label'       => esc_html__( 'Texto alternativo', 'bingo-essentials' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $d['alt'],
				'label_block' => true,
			)
		);
		$this->end_controls_section();
	}

	protected function render_split( $theme = 'dark', $reverse = false ) {
		$s       = $this->get_settings_for_display();
		$classes = 'blv-history-section blv-history-split-section blv-theme-' . $theme;
		$classes .= $reverse ? ' blv-history-reverse' : '';
		$this->render_shell(
			$classes,
			function () use ( $s, $reverse ) {
				echo '<div class="blv-history-split">';
				echo '<div class="blv-history-copy blv-history-reveal">';
				if ( ! empty( $s['tag'] ) ) {
					echo '<span class="blv-history-tag">' . esc_html( $s['tag'] ) . '</span>';
				}
				echo '<h2>' . esc_html( $s['title'] ) . '</h2>';
				$this->paragraphs( $s['body'] );
				echo '</div>';
				echo '<div class="blv-history-image-wrap blv-history-reveal">';
				echo '<div class="blv-history-image-accent"></div>';
				echo '<figure class="blv-history-image"><img src="' . esc_url( $this->image_url( $s, 'image' ) ) . '" alt="' . esc_attr( $s['alt'] ) . '"></figure>';
				echo '</div></div>';
			}
		);
	}
}

class BLV_Historia_Nacimiento_Widget extends BLV_Historia_Split_Widget {
	protected $defaults = array(
		'title' => 'El Nacimiento (1997)',
		'body'  => "La sala fue fundada en julio de 1997 por Begoña Sierra y Ernesto Albor, la dupla fundadora que no solo levantó una sala de juegos, sino que esculpió un auténtico mito del ocio madrileño.\n\nSu visión desde el primer día fue romper el estereotipo del bingo oscuro y aburrido.\n\nSu legado, cimentado en la generosidad, una oferta gastronómica única, el trato familiar y una hospitalidad inquebrantable, convirtió las luces de este rincón de Ciudad Lineal en un faro de alegría eterna; una obra maestra del entretenimiento que hoy sigue latiendo con fuerza gracias a la imborrable huella humana y el espíritu visionario de sus eternos creadores.",
		'image' => 'https://images.unsplash.com/photo-1605810230434-7631ac76ec81?auto=format&fit=crop&q=80&w=2070',
		'alt'   => 'Interior clasico de la sala',
	);
	public function get_name() { return 'blv_historia_nacimiento'; }
	public function get_title() { return esc_html__( 'El nacimiento', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-clock-o'; }
	protected function render() { $this->render_split( 'dark', false ); }
}

class BLV_Historia_Famosos_Widget extends BLV_Historia_Split_Widget {
	protected $defaults = array(
		'title' => 'El Fenomeno Pop y los Famosos',
		'body'  => "Lo que nos catapultó la fama nacional fue una estrecha relación con el mundo del espectáculo y la televisión. Begoña Sierra forjó grandes amistades con colaboradores de televisión, cantantes y actores.\n\nEl templo del corazón: Figuras televisivas de programas como Sálvame se convirtieron en clientes habituales, embajadores e incluso presentaban sus aniversarios.\n\nCultura Pop: La sala se convirtió en un icono tan arraigado en la cultura popular madrileña que llegó a aparecer y ser mencionada en series de televisión de gran éxito. Además, influencers, directores e iconos de la cultura actual celebran en nuestra sala eventos.",
		'image' => 'https://images.unsplash.com/photo-1566737236500-c8ac43014a67?auto=format&fit=crop&q=80&w=2070',
		'alt'   => 'Evento con celebridades',
	);
	public function get_name() { return 'blv_historia_famosos'; }
	public function get_title() { return esc_html__( 'Fenomeno pop y famosos', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-star'; }
	protected function render() { $this->render_split( 'light', true ); }
}

class BLV_Historia_Revolucion_Widget extends BLV_Historia_Split_Widget {
	protected $defaults = array(
		'title' => 'Revolucion Digital y Nuevas Generaciones',
		'body'  => "A partir de 2014, mientras el sector del juego tradicional sufría para atraer a nuevos públicos, el Bingo Las Vegas lideró una estrategia pionera en redes sociales.\n\nDando los mayores premios, celebrando sorteos, noches temáticas y una comunicación muy fresca llevada por jóvenes profesionales, hemos eliminado el estigma de lo que era el bingo.\n\nLlenamos la sala los fines de semana con grupos de jóvenes donde disfrutar de un plan diferente, en el tomar una copa, cenar y jugar sus primeros cartones antes de salir de fiesta.",
		'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=2070',
		'alt'   => 'Jovenes disfrutando en el local',
	);
	public function get_name() { return 'blv_historia_revolucion'; }
	public function get_title() { return esc_html__( 'Revolucion digital', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-device-desktop'; }
	protected function render() { $this->render_split( 'dark', false ); }
}

class BLV_Historia_Producciones_Widget extends BLV_Historia_Base_Widget {

	public function get_name() { return 'blv_historia_producciones'; }
	public function get_title() { return esc_html__( 'Cine y television', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Contenido', 'bingo-essentials' ) ) );
		$this->text_control( 'title', esc_html__( 'Titulo', 'bingo-essentials' ), 'Seguro que nos has visto en cine y televisión', Controls_Manager::TEXT );
		$this->text_control( 'intro', esc_html__( 'Introduccion', 'bingo-essentials' ), "Nuestra estética kistch, retro y vibrante tan única que ha captado la atención de directores de cine, productores de televisión y creadores de contenido, sirviendo localización real para rodajes.\n\nA continuación, las principales producciones donde la sala ha tenido un papel destacado:" );

		$repeater = new Repeater();
		$repeater->add_control( 'number', array( 'label' => esc_html__( 'Numero', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => '01' ) );
		$repeater->add_control( 'name', array( 'label' => esc_html__( 'Nombre', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Furia', 'label_block' => true ) );
		$repeater->add_control( 'meta', array( 'label' => esc_html__( 'Subtitulo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Serie de HBO Max', 'label_block' => true ) );
		$repeater->add_control( 'description', array( 'label' => esc_html__( 'Descripcion', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 6, 'default' => 'Descripcion de la produccion.' ) );
		$repeater->add_control( 'image', array( 'label' => esc_html__( 'Imagen', 'bingo-essentials' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&q=80&w=1200' ) ) );
		$repeater->add_control( 'alt', array( 'label' => esc_html__( 'Texto alternativo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Produccion audiovisual', 'label_block' => true ) );

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Producciones', 'bingo-essentials' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ number }}} - {{{ name }}}',
				'default'     => $this->default_items(),
			)
		);

		$this->add_control(
			'curiosity_heading',
			array(
				'label'     => esc_html__( 'Dato curioso', 'bingo-essentials' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->text_control( 'curiosity_label', esc_html__( 'Etiqueta', 'bingo-essentials' ), 'Dato curioso fuera de cámaras', Controls_Manager::TEXT );
		$this->text_control( 'curiosity_text', esc_html__( 'Texto', 'bingo-essentials' ), 'Aunque no fuera para rodar, la sala vivió su momento más cinematográfico e internacional cuando un actor Hollywood, protagonista de Los Juegos del Hambre, acudió a jugar cartones y cenar allí junto a su pareja y un elenco de directores de cine madrileños, logrando captar la atención de toda la prensa cinematográfica del país.' );
		$this->end_controls_section();
	}

	private function default_items() {
		return array(
			array( 'number' => '01', 'name' => 'Furia', 'meta' => 'Serie de HBO Max', 'description' => 'La serie original de HBO Max, un thriller dramático protagonizado por rostros icónicos del cine español, eligió expresamente el Bingo Las Vegas como una de sus localizaciones principales en Madrid.', 'image' => array( 'url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&q=80&w=1200' ), 'alt' => 'Furia HBO Max' ),
			array( 'number' => '02', 'name' => 'Paquita Salas', 'meta' => 'Netflix', 'description' => 'Aunque no se grabaron episodios enteros nuestras mesas, el Bingo Las Vegas sobrevuela el universo de la aclamada serie.', 'image' => array( 'url' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&q=80&w=1200' ), 'alt' => 'Paquita Salas Netflix' ),
			array( 'number' => '03', 'name' => 'Universo Mediaset', 'meta' => 'Telecinco / Cuatro', 'description' => 'Más allá de la ficción pura, el Bingo Las Vegas ha funcionado como un plató de televisión exterior en innumerables ocasiones.', 'image' => array( 'url' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&q=80&w=1200' ), 'alt' => 'Telecinco Mediaset' ),
			array( 'number' => '04', 'name' => 'Cameos en Ficcion Nacional', 'meta' => 'Ficción española', 'description' => 'Bingo Las Vegas se ha ganado un hueco en los guiones españoles de la última década como el bingo de los famosos por excelencia.', 'image' => array( 'url' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?auto=format&fit=crop&q=80&w=1200' ), 'alt' => 'Cameos ficcion nacional' ),
		);
	}

	private function production_fallback_image( $number ) {
		$fallbacks = array(
			'01' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&q=80&w=1200',
			'02' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&q=80&w=1200',
			'03' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&q=80&w=1200',
			'04' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?auto=format&fit=crop&q=80&w=1200',
		);
		return $fallbacks[ (string) $number ] ?? $fallbacks['01'];
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$items = ! empty( $s['items'] ) && is_array( $s['items'] ) ? $s['items'] : $this->default_items();
		$this->render_shell(
			'blv-history-section blv-history-productions blv-theme-light',
			function () use ( $s, $items ) {
				echo '<div class="blv-history-center blv-history-reveal"><h2>' . esc_html( $s['title'] ) . '</h2>';
				echo '<div class="blv-history-intro">';
				$this->paragraphs( $s['intro'] );
				echo '</div></div>';
				echo '<div class="blv-history-grid">';
				foreach ( $items as $item ) {
					$fallback_image = $this->production_fallback_image( $item['number'] ?? '' );
					$image          = ! empty( $item['image']['url'] ) ? $item['image']['url'] : $fallback_image;
					echo '<article class="blv-history-card blv-history-reveal">';
					echo '<figure class="blv-history-card-visual' . ( empty( $image ) ? ' is-missing' : '' ) . '">';
					if ( ! empty( $image ) ) {
						echo '<img src="' . esc_url( $image ) . '" data-fallback-src="' . esc_url( $fallback_image ) . '" alt="' . esc_attr( $item['alt'] ?? '' ) . '" loading="lazy" onerror="if (this.dataset.fallbackSrc && this.src !== this.dataset.fallbackSrc) { this.src = this.dataset.fallbackSrc; } else { this.closest(\'.blv-history-card-visual\').classList.add(\'is-missing\'); this.remove(); }">';
					}
					echo '</figure>';
					echo '<div class="blv-history-card-head"><span>' . esc_html( $item['number'] ?? '' ) . '</span><h3>' . esc_html( $item['name'] ?? '' );
					if ( ! empty( $item['meta'] ) ) {
						echo '<small>' . esc_html( $item['meta'] ) . '</small>';
					}
					echo '</h3></div><div class="blv-history-card-copy">';
					$this->paragraphs( $item['description'] ?? '' );
					echo '</div></article>';
				}
				echo '</div>';
				if ( ! empty( $s['curiosity_text'] ) ) {
					echo '<aside class="blv-history-curiosity blv-history-reveal">';
					echo '<div class="blv-history-curiosity-mark">+</div>';
					echo '<div class="blv-history-curiosity-copy">';
					if ( ! empty( $s['curiosity_label'] ) ) {
						echo '<span>' . esc_html( $s['curiosity_label'] ) . '</span>';
					}
					echo '<p>' . wp_kses_post( nl2br( esc_html( $s['curiosity_text'] ) ) ) . '</p>';
					echo '</div></aside>';
				}
			}
		);
	}
}

class BLV_Historia_Cta_Widget extends BLV_Historia_Base_Widget {

	public function get_name() { return 'blv_historia_cta'; }
	public function get_title() { return esc_html__( 'CTA - Nuestra Historia', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-call-to-action'; }

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Contenido', 'bingo-essentials' ) ) );
		$this->text_control( 'eyebrow', esc_html__( 'Etiqueta', 'bingo-essentials' ), 'Ven a vivirlo', Controls_Manager::TEXT );
		$this->text_control( 'title', esc_html__( 'Titulo', 'bingo-essentials' ), 'La historia sigue cada noche', Controls_Manager::TEXT );
		$this->text_control( 'body', esc_html__( 'Texto', 'bingo-essentials' ), 'Después de más de dos décadas encendiendo Madrid, Bingo Las Vegas sigue siendo un lugar para celebrar, cenar, jugar y reconocerse en una sala con carácter propio.' );
		$this->text_control( 'primary_text', esc_html__( 'Boton principal - texto', 'bingo-essentials' ), 'Cómo llegar', Controls_Manager::TEXT );
		$this->add_control(
			'primary_url',
			array(
				'label'       => esc_html__( 'Boton principal - enlace', 'bingo-essentials' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://...',
				'default'     => array( 'url' => 'https://maps.google.com/?q=Calle+Hermanos+Garcia+Noblejas+17+Madrid', 'is_external' => 'on' ),
			)
		);
		$this->text_control( 'secondary_text', esc_html__( 'Boton secundario - texto', 'bingo-essentials' ), 'Ver dónde estamos', Controls_Manager::TEXT );
		$this->add_control(
			'secondary_url',
			array(
				'label'       => esc_html__( 'Boton secundario - enlace', 'bingo-essentials' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://...',
				'default'     => array( 'url' => '#donde-estamos' ),
			)
		);
		$this->media_control( 'image', esc_html__( 'Imagen', 'bingo-essentials' ), 'https://images.unsplash.com/photo-1596838132731-3301c3fd4317?auto=format&fit=crop&q=80&w=1400' );
		$this->add_control(
			'alt',
			array(
				'label'       => esc_html__( 'Texto alternativo', 'bingo-essentials' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Sala Bingo Las Vegas',
				'label_block' => true,
			)
		);
		$this->end_controls_section();
	}

	private function render_link( $settings, $text_key, $url_key, $class_name ) {
		if ( empty( $settings[ $text_key ] ) ) {
			return;
		}
		$url    = $settings[ $url_key ] ?? array();
		$href   = ! empty( $url['url'] ) ? $url['url'] : '#';
		$target = ! empty( $url['is_external'] ) ? ' target="_blank"' : '';
		$rel    = ! empty( $url['is_external'] ) ? ' rel="noopener"' : '';
		echo '<a class="' . esc_attr( $class_name ) . '" href="' . esc_url( $href ) . '"' . $target . $rel . '>' . esc_html( $settings[ $text_key ] ) . '</a>';
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->render_shell(
			'blv-history-section blv-history-cta-section blv-theme-dark',
			function () use ( $s ) {
				echo '<div class="blv-history-cta blv-history-reveal">';
				echo '<div class="blv-history-cta-copy">';
				if ( ! empty( $s['eyebrow'] ) ) {
					echo '<span class="blv-history-tag">' . esc_html( $s['eyebrow'] ) . '</span>';
				}
				echo '<h2>' . esc_html( $s['title'] ) . '</h2>';
				$this->paragraphs( $s['body'] );
				echo '<div class="blv-history-cta-actions">';
				$this->render_link( $s, 'primary_text', 'primary_url', 'blv-history-btn blv-history-btn-primary' );
				$this->render_link( $s, 'secondary_text', 'secondary_url', 'blv-history-btn blv-history-btn-outline' );
				echo '</div></div>';
				echo '<div class="blv-history-cta-media">';
				echo '<div class="blv-history-image-accent"></div>';
				echo '<figure class="blv-history-image"><img src="' . esc_url( $this->image_url( $s, 'image' ) ) . '" alt="' . esc_attr( $s['alt'] ) . '" loading="lazy"></figure>';
				echo '</div></div>';
			}
		);
	}
}
