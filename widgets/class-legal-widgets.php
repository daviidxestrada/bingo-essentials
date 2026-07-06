<?php
/**
 * Widgets legales de Bingo Essentials.
 * Canal Etico, Politica de Privacidad, Politica de Cookies y Aviso Legal.
 *
 * El cliente edita contenido desde controles seguros de Elementor. El diseno,
 * clases y estructura quedan bloqueados para evitar romper la maquetacion.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

abstract class BLV_Legal_Base_Widget extends Widget_Base {

	public function get_categories() {
		return array( 'blv-essentials' );
	}

	public function get_style_depends() {
		return array( 'blv-de-fonts', 'blv-be-legal-style' );
	}

	public function get_script_depends() {
		return array( 'blv-be-legal-init' );
	}

	public function get_keywords() {
		return array( 'bingo', 'las vegas', 'legal', 'privacidad', 'cookies', 'aviso', 'canal etico' );
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

	protected function media_control( $id, $label, $default_url, $alt_id = '', $default_alt = '' ) {
		$this->add_control(
			$id,
			array(
				'label'       => $label,
				'type'        => Controls_Manager::MEDIA,
				'media_types' => array( 'image' ),
				'default'     => array( 'url' => $default_url ),
			)
		);

		if ( $alt_id ) {
			$this->add_control(
				$alt_id,
				array(
					'label'       => esc_html__( 'Texto alternativo', 'bingo-essentials' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => $default_alt,
					'label_block' => true,
				)
			);
		}
	}

	protected function pdf_control( $id, $label, $default_url ) {
		$this->add_control(
			$id,
			array(
				'label'       => $label,
				'type'        => Controls_Manager::MEDIA,
				'media_types' => array( 'application/pdf' ),
				'default'     => array( 'url' => $default_url ),
			)
		);
	}

	protected function media_url( $settings, $key ) {
		return ! empty( $settings[ $key ]['url'] ) ? $settings[ $key ]['url'] : '';
	}

	protected function paragraphs( $raw, $class_name ) {
		$raw = trim( (string) $raw );
		if ( '' === $raw ) {
			return;
		}

		$parts = preg_split( "/\n\s*\n/", $raw );
		foreach ( $parts as $part ) {
			$part = trim( $part );
			if ( '' !== $part ) {
				echo '<p class="' . esc_attr( $class_name ) . '">' . wp_kses_post( nl2br( $part ) ) . '</p>';
			}
		}
	}

	protected function list_from_lines( $raw, $ul_class, $li_class = '' ) {
		$lines = preg_split( '/\r\n|\r|\n/', trim( (string) $raw ) );
		$items = array_filter( array_map( 'trim', $lines ) );
		if ( empty( $items ) ) {
			return;
		}

		echo '<ul class="' . esc_attr( $ul_class ) . '">';
		foreach ( $items as $item ) {
			echo '<li' . ( $li_class ? ' class="' . esc_attr( $li_class ) . '"' : '' ) . '>' . wp_kses_post( $item ) . '</li>';
		}
		echo '</ul>';
	}

	protected function external_link_attrs( $url ) {
		$href = ! empty( $url ) ? $url : '#';
		return ' href="' . esc_url( $href ) . '" target="_blank" rel="noopener"';
	}

	protected function render_info_grid( $items, $prefix ) {
		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}

		echo '<div class="' . esc_attr( $prefix . '-highlight' ) . '"><div class="' . esc_attr( $prefix . '-highlight-grid' ) . '">';
		foreach ( $items as $item ) {
			echo '<div>';
			echo '<p class="' . esc_attr( $prefix . '-label' ) . '">' . esc_html( $item['label'] ?? '' ) . '</p>';
			echo '<p class="' . esc_attr( $prefix . '-body' ) . '" style="margin:0 !important;">' . wp_kses_post( nl2br( $item['value'] ?? '' ) ) . '</p>';
			echo '</div>';
		}
		echo '</div></div>';
	}
}

class BLV_Canal_Etico_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_canal_etico'; }
	public function get_title() { return esc_html__( 'Canal Etico', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-shield'; }

	private function default_commitments() {
		return array(
			array( 'title' => 'Juego seguro y responsable', 'text' => 'Prevención, sensibilización y gestión de comportamientos de riesgo, colaborando con organizaciones y gobierno para promover una legislación con las máximas garantías.' ),
			array( 'title' => 'Confidencialidad y protección de datos', 'text' => 'El respeto y la protección de la privacidad y los datos personales de clientes, equipo y proveedores es una cuestión primordial para LAS VEGAS.' ),
			array( 'title' => 'Soborno, regalos y atenciones', 'text' => 'Queda prohibido el ofrecimiento o aceptación de regalos desproporcionados o alejados de los usos y costumbres dentro y fuera de la empresa.' ),
			array( 'title' => 'Blanqueo de capitales', 'text' => 'LAS VEGAS sigue los procedimientos estipulados en la legislación vigente para prevenir pagos irregulares o blanqueo de capitales con origen en actividades ilícitas.' ),
			array( 'title' => 'Respeto a las personas', 'text' => 'Se rechaza cualquier manifestación de acoso físico, psicológico, sexual, moral o abuso de autoridad. Todo el personal debe tratar de forma justa y respetuosa a todas las personas.' ),
			array( 'title' => 'Conflicto de interés', 'text' => 'Ningún interés personal puede interferir en el cumplimiento responsable y ético de los deberes y responsabilidades de las personas empleadas.' ),
		);
	}

	private function default_faqs() {
		return array(
			array( 'question' => '¿Qué hechos se pueden comunicar a través de este Canal?', 'items' => "Incumplimientos de la Ley\nSospechas de ilícitos penales\nInfracciones administrativas graves o muy graves\nInfracciones del Derecho de la Unión Europea\nIncumplimientos del Código Ético y normativa interna" ),
			array( 'question' => '¿Quién puede hacer uso del Canal?', 'items' => "Empleados/as, exempleados/as, voluntarios/as y personal en prácticas\nPersonas con una relación profesional mercantil con LAS VEGAS\nProveedores\nPartes interesadas" ),
			array( 'question' => 'Vías de comunicación', 'items' => "Plataforma del Canal ético accesible a través de la web e intranet\nCorreo electrónico: canaldeinformacionydenuncias@bingolasvegas.es\nVerbalmente: Dña. Mónica Cid o D. Adolfo Titos\nCorreo postal: C/ de los Hermanos García Noblejas 17, 28037 Madrid" ),
		);
	}

	protected function register_controls() {
		$this->start_controls_section( 'intro', array( 'label' => esc_html__( 'Cabecera e intro', 'bingo-essentials' ) ) );
		$this->text_control( 'title', esc_html__( 'Título principal', 'bingo-essentials' ), 'Canal Ético', Controls_Manager::TEXT );
		$this->text_control( 'intro_text', esc_html__( 'Texto introductorio', 'bingo-essentials' ), 'El Canal Ético es una vía que permite gestionar comunicaciones relacionadas con incumplimientos de la Ley, sospechas de ilícitos penales o vulneraciones de nuestro Código Ético o de las distintas Políticas y Procedimientos internos.' );
		$this->text_control( 'warning_text', esc_html__( 'Aviso destacado', 'bingo-essentials' ), 'No es un canal apropiado para presentar quejas, sugerencias o reclamaciones en relación con los servicios prestados.' );
		$this->end_controls_section();

		$this->start_controls_section( 'codigo', array( 'label' => esc_html__( 'Código ético', 'bingo-essentials' ) ) );
		$this->media_control( 'codigo_image', esc_html__( 'Imagen', 'bingo-essentials' ), 'https://des.bingolasvegas.es/wp-content/uploads/2026/04/LOGO_CODIGO_ETICO.jpg', 'codigo_alt', 'Código Ético Bingo Las Vegas' );
		$this->text_control( 'codigo_title', esc_html__( 'Título', 'bingo-essentials' ), 'Código Ético', Controls_Manager::TEXT );
		$this->text_control( 'codigo_text', esc_html__( 'Texto', 'bingo-essentials' ), "La actuación de LAS VEGAS JUEGOS DE ESPAÑA S.A. se rige por el mantenimiento de un comportamiento honesto e íntegro en todas sus actividades, evitando toda forma de corrupción y respetando en todo momento las circunstancias y necesidades particulares de todos los sujetos implicados.\n\nEl Código Ético contiene los principios, criterios y normas de conducta que deben regir su actividad: integridad, legalidad, derechos humanos, igualdad de oportunidades, transparencia y confidencialidad." );
		$this->text_control( 'codigo_btn_text', esc_html__( 'Botón - texto', 'bingo-essentials' ), 'Descargar Código Ético', Controls_Manager::TEXT );
		$this->pdf_control( 'codigo_pdf', esc_html__( 'Botón - PDF', 'bingo-essentials' ), 'https://des.bingolasvegas.es/wp-content/uploads/2026/04/CODIGO-ETICO-LAS-VEGAS.pdf' );
		$this->end_controls_section();

		$this->start_controls_section( 'compromisos', array( 'label' => esc_html__( 'Compromisos', 'bingo-essentials' ) ) );
		$this->text_control( 'commitments_title', esc_html__( 'Título', 'bingo-essentials' ), 'Compromisos y Cultura Corporativa', Controls_Manager::TEXT );
		$this->text_control( 'commitments_intro', esc_html__( 'Texto', 'bingo-essentials' ), 'LAS VEGAS es una sala pionera que fusiona profesionalidad, pasión y honestidad para redefinir la excelencia en las salas de Bingo.' );
		$this->media_control( 'commitments_image', esc_html__( 'Imagen', 'bingo-essentials' ), 'https://des.bingolasvegas.es/wp-content/uploads/2026/04/vegas_sala_2.jpg', 'commitments_alt', 'Interior sala Bingo Las Vegas Madrid' );
		$rep = new Repeater();
		$rep->add_control( 'title', array( 'label' => esc_html__( 'Título', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Compromiso', 'label_block' => true ) );
		$rep->add_control( 'text', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Texto del compromiso.' ) );
		$this->add_control( 'commitments', array( 'label' => esc_html__( 'Cards de compromiso', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $this->default_commitments() ) );
		$this->end_controls_section();

		$this->start_controls_section( 'canal', array( 'label' => esc_html__( 'Canal interno', 'bingo-essentials' ) ) );
		$this->text_control( 'canal_title', esc_html__( 'Título', 'bingo-essentials' ), 'Canal Interno de Información y Denuncias', Controls_Manager::TEXT );
		$this->text_control( 'canal_text', esc_html__( 'Texto', 'bingo-essentials' ), "LAS VEGAS dispone de un canal interno para la denuncia de posibles infracciones normativas y casos de corrupción, en cumplimiento de la Ley 2/2023, de 20 de febrero, reguladora de la protección de las personas que informen sobre infracciones normativas y lucha contra la corrupción.\n\nEs muy importante realizar un uso responsable del Canal ético, de acuerdo con el principio de buena fe." );
		$this->text_control( 'canal_btn_text', esc_html__( 'Botón - texto', 'bingo-essentials' ), 'Descargar Política del Canal', Controls_Manager::TEXT );
		$this->pdf_control( 'canal_pdf', esc_html__( 'Botón - PDF', 'bingo-essentials' ), 'https://des.bingolasvegas.es/wp-content/uploads/2026/04/POLITICA-DEL-CANAL-VEGAS-2024-.pdf' );
		$this->media_control( 'canal_image', esc_html__( 'Imagen', 'bingo-essentials' ), 'https://des.bingolasvegas.es/wp-content/uploads/2026/04/vegas_sala_3.jpg', 'canal_alt', 'Sala Bingo Las Vegas Madrid' );
		$this->end_controls_section();

		$this->start_controls_section( 'faqs_section', array( 'label' => esc_html__( 'Preguntas frecuentes', 'bingo-essentials' ) ) );
		$this->text_control( 'faqs_title', esc_html__( 'Título', 'bingo-essentials' ), 'Preguntas frecuentes', Controls_Manager::TEXT );
		$faq = new Repeater();
		$faq->add_control( 'question', array( 'label' => esc_html__( 'Pregunta', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Pregunta', 'label_block' => true ) );
		$faq->add_control( 'items', array( 'label' => esc_html__( 'Respuesta en lista', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 5, 'default' => "Punto uno\nPunto dos", 'description' => esc_html__( 'Una línea por punto.', 'bingo-essentials' ) ) );
		$this->add_control( 'faqs', array( 'label' => esc_html__( 'FAQs', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $faq->get_controls(), 'title_field' => '{{{ question }}}', 'default' => $this->default_faqs() ) );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$codigo_image = $this->media_url( $s, 'codigo_image' );
		$commitments_image = $this->media_url( $s, 'commitments_image' );
		$canal_image = $this->media_url( $s, 'canal_image' );

		echo '<div class="blv-canal">';
		echo '<h1 class="blv-canal-h1">' . esc_html( $s['title'] ?? '' ) . '</h1>';
		echo '<div class="blv-canal-intro">';
		$this->paragraphs( $s['intro_text'] ?? '', 'blv-canal-body' );
		if ( ! empty( $s['warning_text'] ) ) {
			echo '<p class="blv-canal-aviso">' . wp_kses_post( $s['warning_text'] ) . '</p>';
		}
		echo '</div>';

		echo '<div class="blv-canal-section blv-canal-grid">';
		if ( $codigo_image ) {
			echo '<div class="blv-canal-img-wrap"><img src="' . esc_url( $codigo_image ) . '" alt="' . esc_attr( $s['codigo_alt'] ?? '' ) . '" class="blv-canal-img"></div>';
		}
		echo '<div class="blv-canal-text"><h2 class="blv-canal-title">' . esc_html( $s['codigo_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['codigo_text'] ?? '', 'blv-canal-body' );
		if ( ! empty( $s['codigo_btn_text'] ) ) {
			echo '<a class="blv-canal-btn"' . $this->external_link_attrs( $this->media_url( $s, 'codigo_pdf' ) ) . '>' . esc_html( $s['codigo_btn_text'] ) . '</a>';
		}
		echo '</div></div>';

		echo '<div class="blv-canal-section"><h2 class="blv-canal-title">' . esc_html( $s['commitments_title'] ?? '' ) . '</h2>';
		if ( ! empty( $s['commitments_intro'] ) ) {
			echo '<p class="blv-canal-body" style="margin-bottom:32px;">' . wp_kses_post( $s['commitments_intro'] ) . '</p>';
		}
		if ( $commitments_image ) {
			echo '<img src="' . esc_url( $commitments_image ) . '" alt="' . esc_attr( $s['commitments_alt'] ?? '' ) . '" class="blv-canal-sala-img">';
		}
		echo '<div class="blv-canal-compromisos">';
		foreach ( ( $s['commitments'] ?? $this->default_commitments() ) as $item ) {
			echo '<div class="blv-canal-compromiso"><h3 class="blv-canal-compromiso-title">' . esc_html( $item['title'] ?? '' ) . '</h3><p class="blv-canal-body">' . wp_kses_post( $item['text'] ?? '' ) . '</p></div>';
		}
		echo '</div></div>';

		echo '<div class="blv-canal-section blv-canal-grid"><div class="blv-canal-text"><h2 class="blv-canal-title">' . esc_html( $s['canal_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['canal_text'] ?? '', 'blv-canal-body' );
		if ( ! empty( $s['canal_btn_text'] ) ) {
			echo '<a class="blv-canal-btn"' . $this->external_link_attrs( $this->media_url( $s, 'canal_pdf' ) ) . '>' . esc_html( $s['canal_btn_text'] ) . '</a>';
		}
		echo '</div>';
		if ( $canal_image ) {
			echo '<div class="blv-canal-img-wrap"><img src="' . esc_url( $canal_image ) . '" alt="' . esc_attr( $s['canal_alt'] ?? '' ) . '" class="blv-canal-img"></div>';
		}
		echo '</div>';

		echo '<div class="blv-canal-section"><h2 class="blv-canal-title">' . esc_html( $s['faqs_title'] ?? '' ) . '</h2><ul class="blv-canal-accordion">';
		foreach ( ( $s['faqs'] ?? $this->default_faqs() ) as $index => $faq ) {
			echo '<li class="blv-canal-faq' . ( 0 === $index ? ' active' : '' ) . '"><button class="blv-canal-faq-btn" type="button"><span>' . esc_html( $faq['question'] ?? '' ) . '</span><div class="blv-canal-plus" aria-hidden="true"></div></button><div class="blv-canal-faq-content">';
			$this->list_from_lines( $faq['items'] ?? '', 'blv-canal-faq-list' );
			echo '</div></li>';
		}
		echo '</ul></div></div>';
	}
}

class BLV_Politica_Privacidad_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_politica_privacidad'; }
	public function get_title() { return esc_html__( 'Política de Privacidad', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-lock-user'; }

	private function defaults( $key ) {
		$data = array(
			'responsable' => array(
				array( 'label' => 'Razón social', 'value' => 'LAS VEGAS JUEGOS DE ESPAÑA SA' ),
				array( 'label' => 'CIF', 'value' => 'A81527137' ),
				array( 'label' => 'Domicilio', 'value' => 'Avda. de la Institución Libre de Enseñanza 17, 28037 Madrid' ),
				array( 'label' => 'Contacto', 'value' => '<a class="blv-priv-link" href="mailto:contacto@bingolasvegas.es">contacto@bingolasvegas.es</a>' ),
			),
			'finalidades' => array(
				array( 'question' => 'Formularios de contacto y correo electrónico', 'body' => '<strong>Datos que tratamos:</strong> Nombre, correo electrónico, teléfono, IP, sistema operativo, navegador y duración de visita (esta última de forma anónima).' . "\n\n" . '<strong>Finalidad:</strong> Contestar a sus consultas, gestionar el servicio solicitado, tramitar su petición y enviar información por medios electrónicos relacionada con su solicitud. Con autorización expresa, también comunicaciones comerciales o de eventos.' . "\n\n" . '<strong>Base legal:</strong> Consentimiento del interesado al cumplimentar el formulario y hacer click en enviar.' . "\n\n" . '<strong>Conservación:</strong> Mientras dure la relación y durante los plazos legalmente previstos (formularios y cupones: 15 años; contratos: 5 años).' ),
				array( 'question' => 'Redes sociales', 'body' => '<strong>Datos que tratamos:</strong> Los datos de su perfil público en la red social correspondiente y los facilitados en sus comunicaciones con nosotros.' . "\n\n" . '<strong>Finalidad:</strong> Contestar a sus consultas, gestionar el servicio solicitado y relacionarnos con usted para crear una comunidad de seguidores.' . "\n\n" . '<strong>Base legal:</strong> Aceptación de la relación contractual en el entorno de la red social correspondiente y conforme a sus políticas de privacidad.' . "\n\n" . '<strong>Conservación:</strong> Mientras siga siguiéndonos o siendo amigos/seguidores. Cualquier rectificación debe realizarse a través de la configuración de su perfil en la red social.' ),
				array( 'question' => 'Demandantes de empleo', 'body' => '<strong>Datos que tratamos:</strong> Los contenidos en su currículum vitae y documentación adjunta.' . "\n\n" . '<strong>Finalidad:</strong> Organizar procesos de selección, citar para entrevistas de trabajo y evaluar candidaturas. Con su consentimiento, ceder su candidatura a empresas colaboradoras o del grupo para ayudarle a encontrar empleo.' . "\n\n" . '<strong>Base legal:</strong> Consentimiento inequívoco del interesado al enviarnos su CV.' . "\n\n" . '<strong>Conservación:</strong> Hasta el fin del proceso de selección y 1 año más con su consentimiento. Transcurrido ese plazo procederemos a su destrucción segura.' ),
				array( 'question' => 'Clientes y reservas', 'body' => '<strong>Datos que tratamos:</strong> Nombre, datos de contacto, datos de pago y los necesarios para gestionar la relación contractual.' . "\n\n" . '<strong>Finalidad:</strong> Gestionar la reserva o servicio solicitado, tramitar el pago y mantener la relación comercial. Con autorización expresa, enviar comunicaciones sobre productos, servicios y eventos.' . "\n\n" . '<strong>Base legal:</strong> Ejecución del contrato y, en su caso, consentimiento del interesado para comunicaciones comerciales.' . "\n\n" . '<strong>Conservación:</strong> Facturas 10 años; contratos 5 años. Mantendremos información relativa a la compra o prestación del servicio mientras duren las garantías, para atender posibles reclamaciones.' ),
				array( 'question' => 'Videovigilancia y control de acceso', 'body' => '<strong>Datos que tratamos:</strong> Imágenes captadas por las cámaras de videovigilancia instaladas en las instalaciones y registro de visitantes.' . "\n\n" . '<strong>Finalidad:</strong> Garantizar la seguridad de las personas, instalaciones y bienes, y el cumplimiento de las obligaciones legales en materia de seguridad y juego.' . "\n\n" . '<strong>Base legal:</strong> Interés legítimo del responsable y cumplimiento de obligaciones legales.' . "\n\n" . '<strong>Conservación:</strong> Lista de visitantes: 30 días. Vídeos: 30 días en bloqueo, 3 años hasta destrucción.' ),
			),
			'derechos' => array(
				array( 'title' => 'Acceso', 'text' => 'A saber si estamos tratando sus datos y acceder a ellos.' ),
				array( 'title' => 'Rectificación', 'text' => 'A solicitar la corrección de sus datos si son inexactos o incompletos.' ),
				array( 'title' => 'Supresión', 'text' => 'A solicitar la eliminación de sus datos cuando ya no sean necesarios.' ),
				array( 'title' => 'Limitación', 'text' => 'A solicitar la limitación del tratamiento de sus datos en determinados supuestos.' ),
				array( 'title' => 'Portabilidad', 'text' => 'A recibir sus datos en un formato estructurado y de lectura mecánica.' ),
				array( 'title' => 'Revocación', 'text' => 'A revocar el consentimiento para cualquier tratamiento en cualquier momento.' ),
			),
		);
		return $data[ $key ] ?? array();
	}

	protected function register_controls() {
		$this->start_controls_section( 'intro', array( 'label' => esc_html__( 'Cabecera e intro', 'bingo-essentials' ) ) );
		$this->text_control( 'title', esc_html__( 'Título principal', 'bingo-essentials' ), 'Política de Privacidad', Controls_Manager::TEXT );
		$this->text_control( 'intro_text', esc_html__( 'Intro', 'bingo-essentials' ), "En cumplimiento del Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo (RGPD) y de la Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD), le informamos sobre el tratamiento de sus datos personales.\n\nBINGO LAS VEGAS se reserva el derecho a modificar o adaptar la presente Política de Privacidad en cualquier momento. Le recomendamos revisarla periódicamente." );
		$this->end_controls_section();

		$this->start_controls_section( 'responsable', array( 'label' => esc_html__( 'Responsable', 'bingo-essentials' ) ) );
		$this->text_control( 'responsable_title', esc_html__( 'Título', 'bingo-essentials' ), 'Responsable del Tratamiento', Controls_Manager::TEXT );
		$info = new Repeater();
		$info->add_control( 'label', array( 'label' => esc_html__( 'Etiqueta', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Etiqueta', 'label_block' => true ) );
		$info->add_control( 'value', array( 'label' => esc_html__( 'Valor', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Valor' ) );
		$this->add_control( 'responsable_items', array( 'label' => esc_html__( 'Datos', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $info->get_controls(), 'title_field' => '{{{ label }}}', 'default' => $this->defaults( 'responsable' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'finalidades', array( 'label' => esc_html__( 'Finalidades', 'bingo-essentials' ) ) );
		$this->text_control( 'finalidades_title', esc_html__( 'Título', 'bingo-essentials' ), 'Finalidades del Tratamiento', Controls_Manager::TEXT );
		$faq = new Repeater();
		$faq->add_control( 'question', array( 'label' => esc_html__( 'Título acordeón', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Finalidad', 'label_block' => true ) );
		$faq->add_control( 'body', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 8, 'default' => 'Texto de la finalidad.' ) );
		$this->add_control( 'finalidades_items', array( 'label' => esc_html__( 'Acordeones', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $faq->get_controls(), 'title_field' => '{{{ question }}}', 'default' => $this->defaults( 'finalidades' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'destinatarios', array( 'label' => esc_html__( 'Destinatarios', 'bingo-essentials' ) ) );
		$this->text_control( 'dest_title', esc_html__( 'Título', 'bingo-essentials' ), 'Destinatarios de los Datos', Controls_Manager::TEXT );
		$this->text_control( 'dest_intro', esc_html__( 'Intro', 'bingo-essentials' ), 'Sus datos no se cederán a terceros, salvo obligación legal. En concreto se comunicarán a:' );
		$this->text_control( 'dest_list', esc_html__( 'Lista', 'bingo-essentials' ), "La <strong>Agencia Estatal de la Administración Tributaria</strong> y bancos y entidades financieras para el cobro del servicio prestado o producto adquirido.\nLos <strong>encargados del tratamiento</strong> necesarios para la ejecución del acuerdo, como la empresa de desarrollo y mantenimiento web o la de hosting.\nEn caso de compra o pago online, los datos se cederán a la <strong>plataforma de pago elegida</strong>, siempre con la máxima seguridad.\nCon su consentimiento, en el caso de demandantes de empleo, a <strong>empresas colaboradoras o del grupo</strong>." );
		$this->text_control( 'transfer_label', esc_html__( 'Caja - etiqueta', 'bingo-essentials' ), 'Transferencias internacionales', Controls_Manager::TEXT );
		$this->text_control( 'transfer_text', esc_html__( 'Caja - texto', 'bingo-essentials' ), 'Cualquier transferencia internacional de datos al usar aplicaciones americanas estará adherida al convenio Privacy Shield, que garantiza que las empresas de software americano cumplen las políticas de protección de datos europeas en materia de privacidad.' );
		$this->end_controls_section();

		$this->start_controls_section( 'derechos', array( 'label' => esc_html__( 'Derechos', 'bingo-essentials' ) ) );
		$this->text_control( 'rights_title', esc_html__( 'Título', 'bingo-essentials' ), 'Sus Derechos', Controls_Manager::TEXT );
		$this->text_control( 'rights_intro', esc_html__( 'Intro', 'bingo-essentials' ), 'En cualquier momento puede ejercer los siguientes derechos dirigiéndose a <a class="blv-priv-link" href="mailto:contacto@bingolasvegas.es">contacto@bingolasvegas.es</a> o por correo postal a Avda. de la Institución Libre de Enseñanza 17, 28037 Madrid:' );
		$rights = new Repeater();
		$rights->add_control( 'title', array( 'label' => esc_html__( 'Derecho', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Derecho', 'label_block' => true ) );
		$rights->add_control( 'text', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Texto.' ) );
		$this->add_control( 'rights_items', array( 'label' => esc_html__( 'Cards de derechos', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $rights->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $this->defaults( 'derechos' ) ) );
		$this->text_control( 'claim_label', esc_html__( 'Reclamaciones - etiqueta', 'bingo-essentials' ), 'Reclamaciones', Controls_Manager::TEXT );
		$this->text_control( 'claim_text', esc_html__( 'Reclamaciones - texto', 'bingo-essentials' ), 'Si considera que no le hemos atendido correctamente, tiene derecho a presentar una reclamación ante la <strong>Agencia Española de Protección de Datos</strong> (<a class="blv-priv-link" href="https://www.aepd.es" target="_blank" rel="noopener">www.aepd.es</a>). Los formularios para el ejercicio de derechos deben ir firmados electrónicamente o acompañados de fotocopia del DNI. Respondemos en un plazo máximo de un mes desde su solicitud.' );
		$this->end_controls_section();

		$this->start_controls_section( 'extra', array( 'label' => esc_html__( 'Secciones finales', 'bingo-essentials' ) ) );
		$this->text_control( 'minor_title', esc_html__( 'Menores - título', 'bingo-essentials' ), 'Menores de Edad', Controls_Manager::TEXT );
		$this->text_control( 'minor_text', esc_html__( 'Menores - texto', 'bingo-essentials' ), "No tratamos datos de menores de 14 años. Si es menor de edad o se encuentra incluido en el Registro General de Interdicciones de Acceso al Juego, le rogamos que se abstenga de utilizar nuestros servicios y de proporcionarnos sus datos personales.\n\nBINGO LAS VEGAS se exime de cualquier responsabilidad por el incumplimiento de esta previsión y se reserva el derecho a verificar el cumplimiento de los requisitos legales y a adoptar las medidas necesarias para cancelar los datos facilitados." );
		$this->text_control( 'security_title', esc_html__( 'Seguridad - título', 'bingo-essentials' ), 'Medidas de Seguridad', Controls_Manager::TEXT );
		$this->text_control( 'security_text', esc_html__( 'Seguridad - texto', 'bingo-essentials' ), "Hemos adoptado un nivel óptimo de protección de los Datos Personales que manejamos, y hemos instalado todos los medios y medidas técnicas a nuestra disposición según el estado de la tecnología para evitar la pérdida, mal uso, alteración, acceso no autorizado y robo de los Datos Personales.\n\nToda la información y comunicaciones relativas a su compra o a la prestación de nuestro servicio se mantendrán mientras duren las garantías de los productos o servicios, para atender posibles reclamaciones." );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<div class="blv-priv"><h1 class="blv-priv-h1">' . esc_html( $s['title'] ?? '' ) . '</h1>';
		echo '<div class="blv-priv-intro">';
		$this->paragraphs( $s['intro_text'] ?? '', 'blv-priv-body' );
		echo '</div>';
		echo '<div class="blv-priv-section"><h2 class="blv-priv-title">' . esc_html( $s['responsable_title'] ?? '' ) . '</h2>';
		$this->render_info_grid( $s['responsable_items'] ?? $this->defaults( 'responsable' ), 'blv-priv' );
		echo '</div>';
		echo '<div class="blv-priv-section"><h2 class="blv-priv-title">' . esc_html( $s['finalidades_title'] ?? '' ) . '</h2><ul class="blv-priv-accordion">';
		foreach ( ( $s['finalidades_items'] ?? $this->defaults( 'finalidades' ) ) as $index => $item ) {
			echo '<li class="blv-priv-faq' . ( 0 === $index ? ' active' : '' ) . '"><button class="blv-priv-faq-btn" type="button"><span>' . esc_html( $item['question'] ?? '' ) . '</span><div class="blv-priv-plus" aria-hidden="true"></div></button><div class="blv-priv-faq-content">';
			$this->paragraphs( $item['body'] ?? '', 'blv-priv-body' );
			echo '</div></li>';
		}
		echo '</ul></div>';
		echo '<div class="blv-priv-section"><h2 class="blv-priv-title">' . esc_html( $s['dest_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['dest_intro'] ?? '', 'blv-priv-body' );
		$this->list_from_lines( $s['dest_list'] ?? '', 'blv-priv-list' );
		echo '<div class="blv-priv-aviso-box"><p class="blv-priv-label">' . esc_html( $s['transfer_label'] ?? '' ) . '</p><p class="blv-priv-body" style="margin:0 !important;">' . wp_kses_post( $s['transfer_text'] ?? '' ) . '</p></div></div>';
		echo '<div class="blv-priv-section"><h2 class="blv-priv-title">' . esc_html( $s['rights_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['rights_intro'] ?? '', 'blv-priv-body' );
		echo '<div class="blv-priv-derechos-grid">';
		foreach ( ( $s['rights_items'] ?? $this->defaults( 'derechos' ) ) as $item ) {
			echo '<div class="blv-priv-derecho"><h3 class="blv-priv-derecho-title">' . esc_html( $item['title'] ?? '' ) . '</h3><p class="blv-priv-body">' . wp_kses_post( $item['text'] ?? '' ) . '</p></div>';
		}
		echo '</div><div class="blv-priv-aviso-box" style="margin-top:32px !important;"><p class="blv-priv-label">' . esc_html( $s['claim_label'] ?? '' ) . '</p><p class="blv-priv-body" style="margin:0 !important;">' . wp_kses_post( $s['claim_text'] ?? '' ) . '</p></div></div>';
		echo '<div class="blv-priv-section"><h2 class="blv-priv-title">' . esc_html( $s['minor_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['minor_text'] ?? '', 'blv-priv-body' );
		echo '</div><div class="blv-priv-section"><h2 class="blv-priv-title">' . esc_html( $s['security_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['security_text'] ?? '', 'blv-priv-body' );
		echo '</div></div>';
	}
}

class BLV_Politica_Cookies_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_politica_cookies'; }
	public function get_title() { return esc_html__( 'Política de Cookies', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-cog'; }
	public function get_script_depends() { return array(); }

	private function default_rows() {
		return array(
			array( 'name' => 'Sesión', 'purpose' => 'Registrar las entradas de datos del usuario en la web. Propietario: Las Vegas Juegos de España, S.A.', 'when' => 'Cuando el usuario rellena un formulario' ),
			array( 'name' => 'Autenticación de usuarios', 'purpose' => 'Identificarle como usuario registrado y permitirle la navegación por los distintos contenidos. Propietario: Las Vegas Juegos de España, S.A.', 'when' => 'Únicamente mientras dure la sesión' ),
			array( 'name' => 'Plug-in de redes sociales', 'purpose' => 'Permitir al usuario compartir contenidos con miembros de una determinada red social. Propietario: Red social que pone la cookie (Twitter Inc., Facebook Inc., …)', 'when' => 'Cuando hay algún plugin o botón de compartir en alguna red social' ),
			array( 'name' => 'Google Analytics', 'purpose' => 'Para realizar las estadísticas de uso de la web y conocer el nivel de recurrencia de los visitantes y los contenidos más interesantes.', 'when' => 'Cuando accede a la página' ),
			array( 'name' => 'Google Fonts', 'purpose' => 'Para una representación uniforme de las fuentes. El navegador carga las fuentes web requeridas estableciendo una conexión directa con los servidores de Google.', 'when' => 'Cuando accede a la página' ),
			array( 'name' => 'iThemes Security', 'purpose' => 'Algunos formularios requieren el servicio reCAPTCHA de Google. Si acepta su uso, se crea una cookie que almacena su consentimiento durante treinta días.', 'when' => 'Cuando accede a la página' ),
		);
	}

	protected function register_controls() {
		$this->start_controls_section( 'intro', array( 'label' => esc_html__( 'Cabecera e intro', 'bingo-essentials' ) ) );
		$this->text_control( 'title', esc_html__( 'Título principal', 'bingo-essentials' ), 'Política de Cookies', Controls_Manager::TEXT );
		$this->text_control( 'intro_text', esc_html__( 'Intro', 'bingo-essentials' ), 'Nuestra página web utiliza cookies, pequeños ficheros de datos que se generan en el ordenador del usuario y que nos permiten obtener la siguiente información:' );
		$this->text_control( 'intro_list', esc_html__( 'Lista intro', 'bingo-essentials' ), "La fecha y hora de la última vez que el usuario visitó nuestro web.\nElementos de seguridad que intervienen en el control de acceso a las áreas restringidas." );
		$this->end_controls_section();

		$this->start_controls_section( 'table', array( 'label' => esc_html__( 'Tabla de cookies', 'bingo-essentials' ) ) );
		$this->text_control( 'table_title', esc_html__( 'Título', 'bingo-essentials' ), 'Tipos de cookies utilizadas', Controls_Manager::TEXT );
		$rep = new Repeater();
		$rep->add_control( 'name', array( 'label' => esc_html__( 'Nombre', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Cookie', 'label_block' => true ) );
		$rep->add_control( 'purpose', array( 'label' => esc_html__( 'Finalidad', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Finalidad.' ) );
		$rep->add_control( 'when', array( 'label' => esc_html__( 'Cuándo', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Cuando accede a la página', 'label_block' => true ) );
		$this->add_control( 'cookie_rows', array( 'label' => esc_html__( 'Cookies', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ name }}}', 'default' => $this->default_rows() ) );
		$this->end_controls_section();

		$this->start_controls_section( 'sections', array( 'label' => esc_html__( 'Secciones', 'bingo-essentials' ) ) );
		$this->text_control( 'security_title', esc_html__( 'Registros - título', 'bingo-essentials' ), 'Registros de seguridad', Controls_Manager::TEXT );
		$this->text_control( 'security_text', esc_html__( 'Registros - texto', 'bingo-essentials' ), 'La dirección IP de los visitantes, la identificación de usuario de los usuarios que iniciaron sesión y el nombre de usuario de los intentos de inicio de sesión se registran de forma condicional para detectar actividad maliciosa y proteger el sitio. Esta información se conserva durante <strong>180 días</strong>.' );
		$this->text_control( 'share_title', esc_html__( 'Compartimos - título', 'bingo-essentials' ), 'Con quién compartimos tus datos', Controls_Manager::TEXT );
		$this->text_control( 'share_list', esc_html__( 'Compartimos - lista', 'bingo-essentials' ), "Algunos formularios requieren el servicio <strong>reCAPTCHA de Google</strong>, sujeto a su política de privacidad y términos de uso.\nEl <strong>SiteCheck de Sucuri</strong> analiza el sitio en busca de malware y vulnerabilidades. No se envía información personal a Sucuri.\n<strong>iThemes Security</strong> extrae datos de wordpress.org, ithemes.com y amazonaws.com para garantizar la integridad del archivo. No se envían datos personales.\nAl ejecutar Security Check, se contacta a ithemes.com para determinar si el sitio admite TLS/SSL. Las solicitudes incluyen únicamente la URL del sitio." );
		$this->text_control( 'manage_title', esc_html__( 'Gestión - título', 'bingo-essentials' ), 'Cómo gestionar las cookies', Controls_Manager::TEXT );
		$this->text_control( 'manage_text', esc_html__( 'Gestión - texto', 'bingo-essentials' ), "El usuario puede impedir la generación de cookies mediante la configuración de su navegador. Sin embargo, la empresa no se responsabiliza de que la desactivación impida el buen funcionamiento de la página.\n\nPara permitir, conocer, bloquear o eliminar las cookies instaladas en tu equipo:" );
		$this->end_controls_section();

		$this->start_controls_section( 'highlight', array( 'label' => esc_html__( 'Caja destacada', 'bingo-essentials' ) ) );
		$this->text_control( 'highlight_1_label', esc_html__( 'Bloque 1 - etiqueta', 'bingo-essentials' ), 'Cuánto tiempo conservamos tus datos', Controls_Manager::TEXT );
		$this->text_control( 'highlight_1_text', esc_html__( 'Bloque 1 - texto', 'bingo-essentials' ), 'Los registros de seguridad se conservan durante <strong>180 días</strong>.' );
		$this->text_control( 'highlight_2_label', esc_html__( 'Bloque 2 - etiqueta', 'bingo-essentials' ), 'Dónde enviamos tus datos', Controls_Manager::TEXT );
		$this->text_control( 'highlight_2_text', esc_html__( 'Bloque 2 - texto', 'bingo-essentials' ), 'La dirección IP de los visitantes que intentan iniciar sesión se comparte con un servicio de ithemes.com para proteger el sitio contra ataques distribuidos de fuerza bruta.' );
		$this->end_controls_section();

		$this->start_controls_section( 'browsers', array( 'label' => esc_html__( 'Enlaces navegadores', 'bingo-essentials' ) ) );
		$link = new Repeater();
		$link->add_control( 'label', array( 'label' => esc_html__( 'Nombre', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Navegador', 'label_block' => true ) );
		$link->add_control( 'url', array( 'label' => esc_html__( 'URL', 'bingo-essentials' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'browser_links', array( 'label' => esc_html__( 'Enlaces', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $link->get_controls(), 'title_field' => '{{{ label }}}', 'default' => array(
			array( 'label' => 'Firefox', 'url' => array( 'url' => 'https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias' ) ),
			array( 'label' => 'Chrome', 'url' => array( 'url' => 'https://support.google.com/chrome/bin/answer.py?hl=es&answer=95647' ) ),
			array( 'label' => 'Internet Explorer', 'url' => array( 'url' => 'https://support.microsoft.com/es-es/help/17442/windows-internet-explorer-delete-manage-cookies' ) ),
			array( 'label' => 'Edge', 'url' => array( 'url' => 'https://privacy.microsoft.com/es-es/windows-10-microsoft-edge-and-privacy' ) ),
			array( 'label' => 'Safari', 'url' => array( 'url' => 'https://support.apple.com/kb/ph21411?locale=es_ES' ) ),
			array( 'label' => 'Opera', 'url' => array( 'url' => 'http://help.opera.com/Windows/12.10/es-ES/cookies.html' ) ),
		) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<div class="blv-cookies"><h1 class="blv-cookies-h1">' . esc_html( $s['title'] ?? '' ) . '</h1>';
		echo '<div class="blv-cookies-intro">';
		$this->paragraphs( $s['intro_text'] ?? '', 'blv-cookies-body' );
		$this->list_from_lines( $s['intro_list'] ?? '', 'blv-cookies-list' );
		echo '</div><div class="blv-cookies-section"><h2 class="blv-cookies-title">' . esc_html( $s['table_title'] ?? '' ) . '</h2><div class="blv-cookies-table-wrap"><table class="blv-cookies-table"><thead><tr><th>Nombre</th><th>Finalidad</th><th>Cuándo</th></tr></thead><tbody>';
		foreach ( ( $s['cookie_rows'] ?? $this->default_rows() ) as $row ) {
			echo '<tr><td><strong>' . esc_html( $row['name'] ?? '' ) . '</strong></td><td>' . wp_kses_post( $row['purpose'] ?? '' ) . '</td><td>' . wp_kses_post( $row['when'] ?? '' ) . '</td></tr>';
		}
		echo '</tbody></table></div></div>';
		echo '<div class="blv-cookies-section"><h2 class="blv-cookies-title">' . esc_html( $s['security_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['security_text'] ?? '', 'blv-cookies-body' );
		echo '</div><div class="blv-cookies-section"><h2 class="blv-cookies-title">' . esc_html( $s['share_title'] ?? '' ) . '</h2>';
		$this->list_from_lines( $s['share_list'] ?? '', 'blv-cookies-list' );
		echo '</div><div class="blv-cookies-section blv-cookies-highlight"><div class="blv-cookies-highlight-grid"><div><p class="blv-cookies-label">' . esc_html( $s['highlight_1_label'] ?? '' ) . '</p><p class="blv-cookies-body" style="margin:0 !important;">' . wp_kses_post( $s['highlight_1_text'] ?? '' ) . '</p></div><div><p class="blv-cookies-label">' . esc_html( $s['highlight_2_label'] ?? '' ) . '</p><p class="blv-cookies-body" style="margin:0 !important;">' . wp_kses_post( $s['highlight_2_text'] ?? '' ) . '</p></div></div></div>';
		echo '<div class="blv-cookies-section"><h2 class="blv-cookies-title">' . esc_html( $s['manage_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['manage_text'] ?? '', 'blv-cookies-body' );
		echo '<ul class="blv-cookies-browsers">';
		foreach ( ( $s['browser_links'] ?? array() ) as $link ) {
			$url = $link['url']['url'] ?? '#';
			echo '<li><a class="blv-cookies-link"' . $this->external_link_attrs( $url ) . '>' . esc_html( $link['label'] ?? '' ) . '</a></li>';
		}
		echo '</ul></div></div>';
	}
}

class BLV_Aviso_Legal_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_aviso_legal'; }
	public function get_title() { return esc_html__( 'Aviso Legal', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-document-file'; }

	private function info_defaults() {
		return array(
			array( 'label' => 'Razón social', 'value' => 'LAS VEGAS JUEGOS DE ESPAÑA SA' ),
			array( 'label' => 'Domicilio', 'value' => 'C/ Vizconde de los Asilos 4, Bajo B — 28027 Madrid' ),
			array( 'label' => 'CIF', 'value' => 'A81527137' ),
			array( 'label' => 'Registro Mercantil de Madrid', 'value' => 'Tomo 11.371, Libro 0, Sección 8, Folio 9, Hoja M-178634, Inscripción 1' ),
			array( 'label' => 'Registro del Juego', 'value' => 'Nº JC-0099 — Comunidad Autónoma de Madrid' ),
			array( 'label' => 'Contacto', 'value' => '<a class="blv-aviso-link" href="mailto:contacto@bingolasvegas.es">contacto@bingolasvegas.es</a><br>Avda. de la Institución Libre de Enseñanza 17, 28037 Madrid' ),
		);
	}

	private function faq_defaults() {
		return array(
			array( 'question' => 'Contactos a través de formularios o correo electrónico', 'body' => "Podemos tratar su IP, sistema operativo, navegador y duración de visita de forma anónima. Tratamos los datos para contestar sus consultas, gestionar el servicio solicitado, enviar información por medios electrónicos sobre su solicitud y realizar análisis y mejoras en la Web.\n\nLa aceptación se produce al cumplimentar un formulario y hacer click en enviar. Los campos obligatorios están marcados con *. No tratamos datos de menores de 14 años.", 'list' => '' ),
			array( 'question' => 'Contactos en redes sociales', 'body' => 'Utilizamos los datos para contestar consultas, gestionar el servicio solicitado y relacionarnos con usted creando una comunidad de seguidores. Los trataremos mientras siga siguiéndonos o siendo amigos en la red social correspondiente.', 'list' => '' ),
			array( 'question' => 'Demandantes de empleo', 'body' => "Los datos del CV se utilizan para organizar procesos de selección, citar para entrevistas de trabajo y evaluar candidaturas. Con su consentimiento, podremos cederlos a empresas colaboradoras para ayudarle a encontrar empleo.\n\nTranscurrido un año desde la recepción del currículum vitae, procederemos a su destrucción segura. La base legal es el consentimiento inequívoco del interesado al enviarnos su CV.", 'list' => '' ),
			array( 'question' => 'Sus derechos', 'body' => 'Disponemos de formularios para el ejercicio de sus derechos. Puede solicitarlos por email o usar los elaborados por la AEPD. Los formularios deben ir firmados electrónicamente o acompañados de fotocopia del DNI.', 'list' => "A saber si estamos tratando sus datos o no.\nA acceder a sus datos personales.\nA solicitar la rectificación de sus datos si son inexactos.\nA solicitar la supresión de sus datos si ya no son necesarios.\nA solicitar la limitación del tratamiento de sus datos.\nA portar sus datos en un formato estructurado y de lectura mecánica.\nA presentar una reclamación ante la Agencia Española de Protección de Datos.\nA revocar el consentimiento para cualquier tratamiento en cualquier momento." ),
		);
	}

	private function table_defaults() {
		return array(
			array( 'file' => 'Clientes', 'doc' => 'Facturas', 'keep' => '10 años' ),
			array( 'file' => '', 'doc' => 'Formularios y cupones', 'keep' => '15 años' ),
			array( 'file' => '', 'doc' => 'Contratos', 'keep' => '5 años' ),
			array( 'file' => 'Recursos Humanos', 'doc' => 'Nóminas, TC1, TC2, etc.', 'keep' => '10 años' ),
			array( 'file' => '', 'doc' => 'Currículums', 'keep' => 'Fin del proceso + 1 año' ),
			array( 'file' => 'Control de acceso', 'doc' => 'Lista de visitantes', 'keep' => '30 días' ),
			array( 'file' => '', 'doc' => 'Vídeos', 'keep' => '30 días bloqueo / 3 años destrucción' ),
			array( 'file' => 'Fiscal', 'doc' => 'Administración y pago de impuestos', 'keep' => '10 años' ),
		);
	}

	protected function register_controls() {
		$this->start_controls_section( 'intro', array( 'label' => esc_html__( 'Cabecera e intro', 'bingo-essentials' ) ) );
		$this->text_control( 'title', esc_html__( 'Título principal', 'bingo-essentials' ), 'Aviso Legal', Controls_Manager::TEXT );
		$this->text_control( 'intro_text', esc_html__( 'Intro', 'bingo-essentials' ), 'El acceso y la navegación en el sitio web, o el uso de los servicios del mismo, implican la aceptación expresa e íntegra de todas y cada una de las presentes Condiciones Generales, incluidas tanto las Condiciones Particulares fijadas para ciertas promociones como la Política de Privacidad y Cookies.' );
		$this->end_controls_section();

		$this->start_controls_section( 'legal_info', array( 'label' => esc_html__( 'Información legal', 'bingo-essentials' ) ) );
		$this->text_control( 'info_title', esc_html__( 'Título', 'bingo-essentials' ), '1. Información Legal', Controls_Manager::TEXT );
		$this->text_control( 'info_intro', esc_html__( 'Texto', 'bingo-essentials' ), 'En cumplimiento de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico, los datos identificativos del titular del Portal Web son:' );
		$info = new Repeater();
		$info->add_control( 'label', array( 'label' => esc_html__( 'Etiqueta', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Etiqueta', 'label_block' => true ) );
		$info->add_control( 'value', array( 'label' => esc_html__( 'Valor', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Valor' ) );
		$this->add_control( 'info_items', array( 'label' => esc_html__( 'Datos legales', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $info->get_controls(), 'title_field' => '{{{ label }}}', 'default' => $this->info_defaults() ) );
		$this->end_controls_section();

		$this->start_controls_section( 'sections', array( 'label' => esc_html__( 'Secciones principales', 'bingo-essentials' ) ) );
		$this->text_control( 'terms_title', esc_html__( 'Uso - título', 'bingo-essentials' ), '2. Condiciones Generales de Uso', Controls_Manager::TEXT );
		$this->text_control( 'terms_text', esc_html__( 'Uso - texto', 'bingo-essentials' ), "Las siguientes Condiciones Generales regulan el uso y acceso al portal Web, cuya finalidad es ser puerta de entrada a BINGO LAS VEGAS, ofreciendo a los usuarios información, servicios y contenidos vía Web.\n\nEl Usuario se compromete a hacer un uso adecuado de los contenidos, servicios y herramientas accesibles, con sujeción a la Ley y a las presentes Condiciones Generales. En caso de incumplimiento, BINGO LAS VEGAS se reserva el derecho de denegar el acceso sin previo aviso." );
		$this->text_control( 'minor_label', esc_html__( 'Caja menores - etiqueta', 'bingo-essentials' ), 'Protección de menores y otros', Controls_Manager::TEXT );
		$this->text_control( 'minor_text', esc_html__( 'Caja menores - texto', 'bingo-essentials' ), 'Si Vd. es menor de edad, está incapacitado o se encuentra incluido en el Registro General de Interdicciones de Acceso al Juego o en el Registro de Personas Vinculadas a Operadores de Juego, no puede acceder a nuestra Sala de Bingo ni hacer uso de los servicios ofrecidos a través de este sitio web.' );
		$this->text_control( 'oblig_title', esc_html__( 'Obligaciones - título', 'bingo-essentials' ), '3. Obligaciones Generales del Usuario', Controls_Manager::TEXT );
		$this->text_control( 'oblig_intro', esc_html__( 'Obligaciones - intro', 'bingo-essentials' ), 'El Usuario, al aceptar las presentes Condiciones Generales de Uso, se obliga expresamente a:' );
		$this->text_control( 'oblig_list', esc_html__( 'Obligaciones - lista', 'bingo-essentials' ), "No realizar ninguna acción destinada a perjudicar, bloquear, dañar o inutilizar las funcionalidades, herramientas o infraestructura de la página web.\nCustodiar y mantener la confidencialidad de las claves de acceso asociadas a su nombre de Usuario.\nNo introducir contenidos injuriosos o calumniosos, tanto de otros Usuarios como de terceras empresas.\nNo utilizar los materiales e informaciones contenidos en este Sitio Web con fines ilícitos o contrarios a los derechos de BINGO LAS VEGAS, sus usuarios y/o terceros.\nNo ofertar ni distribuir productos y servicios, ni realizar publicidad o comunicaciones comerciales no solicitadas a otros Usuarios." );
		$this->text_control( 'ip_title', esc_html__( 'Propiedad intelectual - título', 'bingo-essentials' ), '4. Propiedad Intelectual e Industrial', Controls_Manager::TEXT );
		$this->text_control( 'ip_text', esc_html__( 'Propiedad intelectual - texto', 'bingo-essentials' ), "El sitio web, las páginas que comprende y la información o elementos contenidos en las mismas (incluyendo textos, documentos, fotografías, dibujos, representaciones gráficas), así como logotipos, marcas y nombres comerciales, se encuentran protegidos por derechos de propiedad intelectual o industrial de los que BINGO LAS VEGAS es titular.\n\nBINGO LAS VEGAS autoriza al Usuario para visualizar la información contenida en este sitio y para efectuar reproducciones privadas destinadas exclusivamente al uso personal. El Usuario no está autorizado para distribuir, modificar, ceder o comunicar públicamente dicha información." );
		$this->text_control( 'links_title', esc_html__( 'Enlaces - título', 'bingo-essentials' ), '5. Enlaces', Controls_Manager::TEXT );
		$this->text_control( 'links_text', esc_html__( 'Enlaces - texto', 'bingo-essentials' ), "Las conexiones y enlaces a sitios o páginas Web de terceros se han establecido únicamente como una utilidad para el Usuario. BINGO LAS VEGAS no es responsable de las mismas ni de su contenido, y tales enlaces tienen una finalidad exclusivamente informativa.\n\nPara realizar enlaces con la página Web será necesaria la autorización expresa y por escrito de los titulares del portal." );
		$this->text_control( 'resp_title', esc_html__( 'Responsabilidad - título', 'bingo-essentials' ), '6. Responsabilidad', Controls_Manager::TEXT );
		$this->text_control( 'resp_text', esc_html__( 'Responsabilidad - texto', 'bingo-essentials' ), 'BINGO LAS VEGAS no garantiza el acceso continuado ni la correcta visualización de los elementos contenidos en las páginas del portal, que pueden verse impedidos por factores fuera de su control. BINGO LAS VEGAS no asume responsabilidad alguna por daños producidos por:' );
		$this->text_control( 'resp_list', esc_html__( 'Responsabilidad - lista', 'bingo-essentials' ), "Interferencias, interrupciones, fallos, omisiones o retrasos motivados por errores en líneas y redes de telecomunicaciones.\nIntromisiones ilegítimas mediante el uso de programas malignos, virus informáticos o cualesquiera otros.\nUso indebido o inadecuado de la página web de BINGO LAS VEGAS.\nErrores de seguridad o navegación producidos por un mal funcionamiento del navegador o uso de versiones no actualizadas." );
		$this->end_controls_section();

		$this->start_controls_section( 'data', array( 'label' => esc_html__( 'Protección de datos', 'bingo-essentials' ) ) );
		$this->text_control( 'data_title', esc_html__( 'Título', 'bingo-essentials' ), '7. Protección de Datos de Carácter Personal', Controls_Manager::TEXT );
		$faq = new Repeater();
		$faq->add_control( 'question', array( 'label' => esc_html__( 'Título acordeón', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Acordeón', 'label_block' => true ) );
		$faq->add_control( 'body', array( 'label' => esc_html__( 'Texto', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 5, 'default' => 'Texto.' ) );
		$faq->add_control( 'list', array( 'label' => esc_html__( 'Lista opcional', 'bingo-essentials' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 5, 'default' => '', 'description' => esc_html__( 'Una línea por punto. Se mostrará antes del texto.', 'bingo-essentials' ) ) );
		$this->add_control( 'data_faqs', array( 'label' => esc_html__( 'Acordeones', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $faq->get_controls(), 'title_field' => '{{{ question }}}', 'default' => $this->faq_defaults() ) );
		$this->text_control( 'table_question', esc_html__( 'Tabla plazos - título acordeón', 'bingo-essentials' ), 'Conservación de datos — tabla de plazos', Controls_Manager::TEXT );
		$row = new Repeater();
		$row->add_control( 'file', array( 'label' => esc_html__( 'Fichero', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Fichero', 'label_block' => true ) );
		$row->add_control( 'doc', array( 'label' => esc_html__( 'Documento', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Documento', 'label_block' => true ) );
		$row->add_control( 'keep', array( 'label' => esc_html__( 'Conservación', 'bingo-essentials' ), 'type' => Controls_Manager::TEXT, 'default' => 'Plazo', 'label_block' => true ) );
		$this->add_control( 'table_rows', array( 'label' => esc_html__( 'Filas de tabla', 'bingo-essentials' ), 'type' => Controls_Manager::REPEATER, 'fields' => $row->get_controls(), 'title_field' => '{{{ file }}} {{{ doc }}}', 'default' => $this->table_defaults() ) );
		$this->end_controls_section();

		$this->start_controls_section( 'legislation', array( 'label' => esc_html__( 'Legislación', 'bingo-essentials' ) ) );
		$this->text_control( 'leg_title', esc_html__( 'Título', 'bingo-essentials' ), '8. Legislación', Controls_Manager::TEXT );
		$this->text_control( 'leg_text', esc_html__( 'Texto', 'bingo-essentials' ), "El presente Aviso Legal y sus términos y condiciones se regirán e interpretarán de acuerdo con la Legislación Española. El usuario, por el solo hecho de acceder a la página web, otorga de forma irrevocable su consentimiento a que los Tribunales competentes puedan conocer de cualquier acción judicial derivada de las presentes condiciones.\n\nSi alguna cláusula de las presentes Condiciones Generales es declarada nula o inaplicable, la validez de las restantes cláusulas no se verá afectada." );
		$this->end_controls_section();
	}

	private function render_basic_section( $title, $body, $list = '' ) {
		echo '<div class="blv-aviso-section"><h2 class="blv-aviso-title">' . esc_html( $title ) . '</h2>';
		$this->paragraphs( $body, 'blv-aviso-body' );
		if ( $list ) {
			$this->list_from_lines( $list, 'blv-aviso-list' );
		}
		echo '</div>';
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<div class="blv-aviso"><h1 class="blv-aviso-h1">' . esc_html( $s['title'] ?? '' ) . '</h1>';
		echo '<div class="blv-aviso-intro">';
		$this->paragraphs( $s['intro_text'] ?? '', 'blv-aviso-body' );
		echo '</div>';
		echo '<div class="blv-aviso-section"><h2 class="blv-aviso-title">' . esc_html( $s['info_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['info_intro'] ?? '', 'blv-aviso-body' );
		$this->render_info_grid( $s['info_items'] ?? $this->info_defaults(), 'blv-aviso' );
		echo '</div>';
		echo '<div class="blv-aviso-section"><h2 class="blv-aviso-title">' . esc_html( $s['terms_title'] ?? '' ) . '</h2>';
		$this->paragraphs( $s['terms_text'] ?? '', 'blv-aviso-body' );
		echo '<div class="blv-aviso-aviso-box"><p class="blv-aviso-label">' . esc_html( $s['minor_label'] ?? '' ) . '</p><p class="blv-aviso-body" style="margin:0 !important;">' . wp_kses_post( $s['minor_text'] ?? '' ) . '</p></div></div>';
		$this->render_basic_section( $s['oblig_title'] ?? '', $s['oblig_intro'] ?? '', $s['oblig_list'] ?? '' );
		$this->render_basic_section( $s['ip_title'] ?? '', $s['ip_text'] ?? '' );
		$this->render_basic_section( $s['links_title'] ?? '', $s['links_text'] ?? '' );
		$this->render_basic_section( $s['resp_title'] ?? '', $s['resp_text'] ?? '', $s['resp_list'] ?? '' );
		echo '<div class="blv-aviso-section"><h2 class="blv-aviso-title">' . esc_html( $s['data_title'] ?? '' ) . '</h2><ul class="blv-aviso-accordion">';
		foreach ( ( $s['data_faqs'] ?? $this->faq_defaults() ) as $index => $item ) {
			echo '<li class="blv-aviso-faq' . ( 0 === $index ? ' active' : '' ) . '"><button class="blv-aviso-faq-btn" type="button"><span>' . esc_html( $item['question'] ?? '' ) . '</span><div class="blv-aviso-plus" aria-hidden="true"></div></button><div class="blv-aviso-faq-content">';
			if ( ! empty( $item['list'] ) ) {
				$this->list_from_lines( $item['list'], 'blv-aviso-list' );
			}
			$this->paragraphs( $item['body'] ?? '', 'blv-aviso-body' );
			echo '</div></li>';
		}
		echo '<li class="blv-aviso-faq"><button class="blv-aviso-faq-btn" type="button"><span>' . esc_html( $s['table_question'] ?? '' ) . '</span><div class="blv-aviso-plus" aria-hidden="true"></div></button><div class="blv-aviso-faq-content"><div class="blv-aviso-table-wrap"><table class="blv-aviso-table"><thead><tr><th>Fichero</th><th>Documento</th><th>Conservación</th></tr></thead><tbody>';
		foreach ( ( $s['table_rows'] ?? $this->table_defaults() ) as $row ) {
			echo '<tr><td>' . ( ! empty( $row['file'] ) ? '<strong>' . esc_html( $row['file'] ) . '</strong>' : '' ) . '</td><td>' . esc_html( $row['doc'] ?? '' ) . '</td><td>' . esc_html( $row['keep'] ?? '' ) . '</td></tr>';
		}
		echo '</tbody></table></div></div></li></ul></div>';
		$this->render_basic_section( $s['leg_title'] ?? '', $s['leg_text'] ?? '' );
		echo '</div>';
	}
}
