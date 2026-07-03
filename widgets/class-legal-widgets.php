<?php
/**
 * Widgets legales de Bingo Essentials.
 * Canal Etico, Politica de Privacidad, Politica de Cookies y Aviso Legal.
 *
 * El contenido es texto legal estatico: se renderiza tal cual. El
 * markup ya viene scopeado por prefijo de clase (blv-canal, blv-priv,
 * blv-cookies, blv-aviso) para no colisionar con el resto del tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

	/**
	 * Estos widgets no exponen controles: el contenido legal es fijo.
	 */
	protected function register_controls() {}
}

class BLV_Canal_Etico_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_canal_etico'; }
	public function get_title() { return esc_html__( 'Canal Etico', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-shield'; }

	protected function render() {
		echo <<<'HTML'
<div class="blv-canal">

  <h1 class="blv-canal-h1">Canal Ético</h1>

  <div class="blv-canal-intro">
    <p class="blv-canal-body">
      El Canal Ético es una vía que permite gestionar comunicaciones relacionadas con incumplimientos de la Ley, sospechas de ilícitos penales o vulneraciones de nuestro Código Ético o de las distintas Políticas y Procedimientos internos.
    </p>
    <p class="blv-canal-aviso">
      No es un canal apropiado para presentar quejas, sugerencias o reclamaciones en relación con los servicios prestados.
    </p>
  </div>

  <div class="blv-canal-section blv-canal-grid">
    <div class="blv-canal-img-wrap">
      <img src="https://des.bingolasvegas.es/wp-content/uploads/2026/04/LOGO_CODIGO_ETICO.jpg" alt="Código Ético Bingo Las Vegas" class="blv-canal-img">
    </div>
    <div class="blv-canal-text">
      <h2 class="blv-canal-title">Código Ético</h2>
      <p class="blv-canal-body">La actuación de LAS VEGAS JUEGOS DE ESPAÑA S.A. se rige por el mantenimiento de un comportamiento honesto e íntegro en todas sus actividades, evitando toda forma de corrupción y respetando en todo momento las circunstancias y necesidades particulares de todos los sujetos implicados.</p>
      <p class="blv-canal-body">El Código Ético contiene los principios, criterios y normas de conducta que deben regir su actividad: integridad, legalidad, derechos humanos, igualdad de oportunidades, transparencia y confidencialidad.</p>
      <a class="blv-canal-btn" href="https://des.bingolasvegas.es/wp-content/uploads/2026/04/CODIGO-ETICO-LAS-VEGAS.pdf" target="_blank" rel="noopener">Descargar Código Ético</a>
    </div>
  </div>

  <div class="blv-canal-section">
    <h2 class="blv-canal-title">Compromisos y Cultura Corporativa</h2>
    <p class="blv-canal-body" style="margin-bottom:32px;">LAS VEGAS es una sala pionera que fusiona profesionalidad, pasión y honestidad para redefinir la excelencia en las salas de Bingo.</p>
    <img src="https://des.bingolasvegas.es/wp-content/uploads/2026/04/vegas_sala_2.jpg" alt="Interior sala Bingo Las Vegas Madrid" class="blv-canal-sala-img">
    <div class="blv-canal-compromisos">
      <div class="blv-canal-compromiso">
        <h3 class="blv-canal-compromiso-title">Juego seguro y responsable</h3>
        <p class="blv-canal-body">Prevención, sensibilización y gestión de comportamientos de riesgo, colaborando con organizaciones y gobierno para promover una legislación con las máximas garantías.</p>
      </div>
      <div class="blv-canal-compromiso">
        <h3 class="blv-canal-compromiso-title">Confidencialidad y protección de datos</h3>
        <p class="blv-canal-body">El respeto y la protección de la privacidad y los datos personales de clientes, equipo y proveedores es una cuestión primordial para LAS VEGAS.</p>
      </div>
      <div class="blv-canal-compromiso">
        <h3 class="blv-canal-compromiso-title">Soborno, regalos y atenciones</h3>
        <p class="blv-canal-body">Queda prohibido el ofrecimiento o aceptación de regalos desproporcionados o alejados de los usos y costumbres dentro y fuera de la empresa.</p>
      </div>
      <div class="blv-canal-compromiso">
        <h3 class="blv-canal-compromiso-title">Blanqueo de capitales</h3>
        <p class="blv-canal-body">LAS VEGAS sigue los procedimientos estipulados en la legislación vigente para prevenir pagos irregulares o blanqueo de capitales con origen en actividades ilícitas.</p>
      </div>
      <div class="blv-canal-compromiso">
        <h3 class="blv-canal-compromiso-title">Respeto a las personas</h3>
        <p class="blv-canal-body">Se rechaza cualquier manifestación de acoso físico, psicológico, sexual, moral o abuso de autoridad. Todo el personal debe tratar de forma justa y respetuosa a todas las personas.</p>
      </div>
      <div class="blv-canal-compromiso">
        <h3 class="blv-canal-compromiso-title">Conflicto de interés</h3>
        <p class="blv-canal-body">Ningún interés personal puede interferir en el cumplimiento responsable y ético de los deberes y responsabilidades de las personas empleadas.</p>
      </div>
    </div>
  </div>

  <div class="blv-canal-section blv-canal-grid">
    <div class="blv-canal-text">
      <h2 class="blv-canal-title">Canal Interno de Información y Denuncias</h2>
      <p class="blv-canal-body">LAS VEGAS dispone de un canal interno para la denuncia de posibles infracciones normativas y casos de corrupción, en cumplimiento de la Ley 2/2023, de 20 de febrero, reguladora de la protección de las personas que informen sobre infracciones normativas y lucha contra la corrupción.</p>
      <p class="blv-canal-body">Es muy importante realizar un uso responsable del Canal ético, de acuerdo con el principio de buena fe.</p>
      <a class="blv-canal-btn" href="https://des.bingolasvegas.es/wp-content/uploads/2026/04/POLITICA-DEL-CANAL-VEGAS-2024-.pdf" target="_blank" rel="noopener">Descargar Política del Canal</a>
    </div>
    <div class="blv-canal-img-wrap">
      <img src="https://des.bingolasvegas.es/wp-content/uploads/2026/04/vegas_sala_3.jpg" alt="Sala Bingo Las Vegas Madrid" class="blv-canal-img">
    </div>
  </div>

  <div class="blv-canal-section">
    <h2 class="blv-canal-title">Preguntas frecuentes</h2>
    <ul class="blv-canal-accordion">

      <li class="blv-canal-faq active">
        <button class="blv-canal-faq-btn" type="button">
          <span>¿Qué hechos se pueden comunicar a través de este Canal?</span>
          <div class="blv-canal-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-canal-faq-content">
          <ul class="blv-canal-faq-list">
            <li>Incumplimientos de la Ley</li>
            <li>Sospechas de ilícitos penales</li>
            <li>Infracciones administrativas graves o muy graves</li>
            <li>Infracciones del Derecho de la Unión Europea</li>
            <li>Incumplimientos del Código Ético y normativa interna</li>
          </ul>
        </div>
      </li>

      <li class="blv-canal-faq">
        <button class="blv-canal-faq-btn" type="button">
          <span>¿Quién puede hacer uso del Canal?</span>
          <div class="blv-canal-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-canal-faq-content">
          <ul class="blv-canal-faq-list">
            <li>Empleados/as, exempleados/as, voluntarios/as y personal en prácticas</li>
            <li>Personas con una relación profesional mercantil con LAS VEGAS</li>
            <li>Proveedores</li>
            <li>Partes interesadas</li>
          </ul>
        </div>
      </li>

      <li class="blv-canal-faq">
        <button class="blv-canal-faq-btn" type="button">
          <span>Vías de comunicación</span>
          <div class="blv-canal-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-canal-faq-content">
          <ul class="blv-canal-faq-list">
            <li>Plataforma del Canal ético accesible a través de la web e intranet</li>
            <li>Correo electrónico: canaldeinformacionydenuncias@bingolasvegas.es</li>
            <li>Verbalmente: Dña. Mónica Cid o D. Adolfo Titos</li>
            <li>Correo postal: C/ de los Hermanos García Noblejas 17, 28037 Madrid</li>
          </ul>
        </div>
      </li>

    </ul>
  </div>

</div>
HTML;
	}
}

class BLV_Politica_Privacidad_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_politica_privacidad'; }
	public function get_title() { return esc_html__( 'Política de Privacidad', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-lock-user'; }

	protected function render() {
		echo <<<'HTML'
<div class="blv-priv">

  <h1 class="blv-priv-h1">Política de Privacidad</h1>

  <div class="blv-priv-intro">
    <p class="blv-priv-body">En cumplimiento del Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo (RGPD) y de la Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD), le informamos sobre el tratamiento de sus datos personales.</p>
    <p class="blv-priv-body">BINGO LAS VEGAS se reserva el derecho a modificar o adaptar la presente Política de Privacidad en cualquier momento. Le recomendamos revisarla periódicamente.</p>
  </div>

  <div class="blv-priv-section">
    <h2 class="blv-priv-title">Responsable del Tratamiento</h2>
    <div class="blv-priv-highlight">
      <div class="blv-priv-highlight-grid">
        <div>
          <p class="blv-priv-label">Razón social</p>
          <p class="blv-priv-body" style="margin:0 !important;">LAS VEGAS JUEGOS DE ESPAÑA SA</p>
        </div>
        <div>
          <p class="blv-priv-label">CIF</p>
          <p class="blv-priv-body" style="margin:0 !important;">A81527137</p>
        </div>
        <div>
          <p class="blv-priv-label">Domicilio</p>
          <p class="blv-priv-body" style="margin:0 !important;">Avda. de la Institución Libre de Enseñanza 17, 28037 Madrid</p>
        </div>
        <div>
          <p class="blv-priv-label">Contacto</p>
          <p class="blv-priv-body" style="margin:0 !important;"><a class="blv-priv-link" href="mailto:contacto@bingolasvegas.es">contacto@bingolasvegas.es</a></p>
        </div>
      </div>
    </div>
  </div>

  <div class="blv-priv-section">
    <h2 class="blv-priv-title">Finalidades del Tratamiento</h2>

    <ul class="blv-priv-accordion">

      <li class="blv-priv-faq active">
        <button class="blv-priv-faq-btn" type="button">
          <span>Formularios de contacto y correo electrónico</span>
          <div class="blv-priv-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-priv-faq-content">
          <p class="blv-priv-body"><strong>Datos que tratamos:</strong> Nombre, correo electrónico, teléfono, IP, sistema operativo, navegador y duración de visita (esta última de forma anónima).</p>
          <p class="blv-priv-body"><strong>Finalidad:</strong> Contestar a sus consultas, gestionar el servicio solicitado, tramitar su petición y enviar información por medios electrónicos relacionada con su solicitud. Con autorización expresa, también comunicaciones comerciales o de eventos.</p>
          <p class="blv-priv-body"><strong>Base legal:</strong> Consentimiento del interesado al cumplimentar el formulario y hacer click en enviar.</p>
          <p class="blv-priv-body"><strong>Conservación:</strong> Mientras dure la relación y durante los plazos legalmente previstos (formularios y cupones: 15 años; contratos: 5 años).</p>
        </div>
      </li>

      <li class="blv-priv-faq">
        <button class="blv-priv-faq-btn" type="button">
          <span>Redes sociales</span>
          <div class="blv-priv-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-priv-faq-content">
          <p class="blv-priv-body"><strong>Datos que tratamos:</strong> Los datos de su perfil público en la red social correspondiente y los facilitados en sus comunicaciones con nosotros.</p>
          <p class="blv-priv-body"><strong>Finalidad:</strong> Contestar a sus consultas, gestionar el servicio solicitado y relacionarnos con usted para crear una comunidad de seguidores.</p>
          <p class="blv-priv-body"><strong>Base legal:</strong> Aceptación de la relación contractual en el entorno de la red social correspondiente y conforme a sus políticas de privacidad.</p>
          <p class="blv-priv-body"><strong>Conservación:</strong> Mientras siga siguiéndonos o siendo amigos/seguidores. Cualquier rectificación debe realizarse a través de la configuración de su perfil en la red social.</p>
        </div>
      </li>

      <li class="blv-priv-faq">
        <button class="blv-priv-faq-btn" type="button">
          <span>Demandantes de empleo</span>
          <div class="blv-priv-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-priv-faq-content">
          <p class="blv-priv-body"><strong>Datos que tratamos:</strong> Los contenidos en su currículum vitae y documentación adjunta.</p>
          <p class="blv-priv-body"><strong>Finalidad:</strong> Organizar procesos de selección, citar para entrevistas de trabajo y evaluar candidaturas. Con su consentimiento, ceder su candidatura a empresas colaboradoras o del grupo para ayudarle a encontrar empleo.</p>
          <p class="blv-priv-body"><strong>Base legal:</strong> Consentimiento inequívoco del interesado al enviarnos su CV.</p>
          <p class="blv-priv-body"><strong>Conservación:</strong> Hasta el fin del proceso de selección y 1 año más con su consentimiento. Transcurrido ese plazo procederemos a su destrucción segura.</p>
        </div>
      </li>

      <li class="blv-priv-faq">
        <button class="blv-priv-faq-btn" type="button">
          <span>Clientes y reservas</span>
          <div class="blv-priv-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-priv-faq-content">
          <p class="blv-priv-body"><strong>Datos que tratamos:</strong> Nombre, datos de contacto, datos de pago y los necesarios para gestionar la relación contractual.</p>
          <p class="blv-priv-body"><strong>Finalidad:</strong> Gestionar la reserva o servicio solicitado, tramitar el pago y mantener la relación comercial. Con autorización expresa, enviar comunicaciones sobre productos, servicios y eventos.</p>
          <p class="blv-priv-body"><strong>Base legal:</strong> Ejecución del contrato y, en su caso, consentimiento del interesado para comunicaciones comerciales.</p>
          <p class="blv-priv-body"><strong>Conservación:</strong> Facturas 10 años; contratos 5 años. Mantendremos información relativa a la compra o prestación del servicio mientras duren las garantías, para atender posibles reclamaciones.</p>
        </div>
      </li>

      <li class="blv-priv-faq">
        <button class="blv-priv-faq-btn" type="button">
          <span>Videovigilancia y control de acceso</span>
          <div class="blv-priv-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-priv-faq-content">
          <p class="blv-priv-body"><strong>Datos que tratamos:</strong> Imágenes captadas por las cámaras de videovigilancia instaladas en las instalaciones y registro de visitantes.</p>
          <p class="blv-priv-body"><strong>Finalidad:</strong> Garantizar la seguridad de las personas, instalaciones y bienes, y el cumplimiento de las obligaciones legales en materia de seguridad y juego.</p>
          <p class="blv-priv-body"><strong>Base legal:</strong> Interés legítimo del responsable y cumplimiento de obligaciones legales.</p>
          <p class="blv-priv-body"><strong>Conservación:</strong> Lista de visitantes: 30 días. Vídeos: 30 días en bloqueo, 3 años hasta destrucción.</p>
        </div>
      </li>

    </ul>
  </div>

  <div class="blv-priv-section">
    <h2 class="blv-priv-title">Destinatarios de los Datos</h2>
    <p class="blv-priv-body">Sus datos no se cederán a terceros, salvo obligación legal. En concreto se comunicarán a:</p>
    <ul class="blv-priv-list">
      <li>La <strong>Agencia Estatal de la Administración Tributaria</strong> y bancos y entidades financieras para el cobro del servicio prestado o producto adquirido.</li>
      <li>Los <strong>encargados del tratamiento</strong> necesarios para la ejecución del acuerdo, como la empresa de desarrollo y mantenimiento web o la de hosting, con quienes tenemos firmado un contrato de prestación de servicios que les obliga a mantener el mismo nivel de privacidad.</li>
      <li>En caso de compra o pago online, los datos se cederán a la <strong>plataforma de pago elegida</strong>, siempre con la máxima seguridad.</li>
      <li>Con su consentimiento, en el caso de demandantes de empleo, a <strong>empresas colaboradoras o del grupo</strong> con el objetivo de incluirle en sus procesos de selección.</li>
    </ul>
    <div class="blv-priv-aviso-box">
      <p class="blv-priv-label">Transferencias internacionales</p>
      <p class="blv-priv-body" style="margin:0 !important;">Cualquier transferencia internacional de datos al usar aplicaciones americanas estará adherida al convenio Privacy Shield, que garantiza que las empresas de software americano cumplen las políticas de protección de datos europeas en materia de privacidad.</p>
    </div>
  </div>

  <div class="blv-priv-section">
    <h2 class="blv-priv-title">Sus Derechos</h2>
    <p class="blv-priv-body">En cualquier momento puede ejercer los siguientes derechos dirigiéndose a <a class="blv-priv-link" href="mailto:contacto@bingolasvegas.es">contacto@bingolasvegas.es</a> o por correo postal a Avda. de la Institución Libre de Enseñanza 17, 28037 Madrid:</p>
    <div class="blv-priv-derechos-grid">
      <div class="blv-priv-derecho">
        <h3 class="blv-priv-derecho-title">Acceso</h3>
        <p class="blv-priv-body">A saber si estamos tratando sus datos y acceder a ellos.</p>
      </div>
      <div class="blv-priv-derecho">
        <h3 class="blv-priv-derecho-title">Rectificación</h3>
        <p class="blv-priv-body">A solicitar la corrección de sus datos si son inexactos o incompletos.</p>
      </div>
      <div class="blv-priv-derecho">
        <h3 class="blv-priv-derecho-title">Supresión</h3>
        <p class="blv-priv-body">A solicitar la eliminación de sus datos cuando ya no sean necesarios.</p>
      </div>
      <div class="blv-priv-derecho">
        <h3 class="blv-priv-derecho-title">Limitación</h3>
        <p class="blv-priv-body">A solicitar la limitación del tratamiento de sus datos en determinados supuestos.</p>
      </div>
      <div class="blv-priv-derecho">
        <h3 class="blv-priv-derecho-title">Portabilidad</h3>
        <p class="blv-priv-body">A recibir sus datos en un formato estructurado y de lectura mecánica.</p>
      </div>
      <div class="blv-priv-derecho">
        <h3 class="blv-priv-derecho-title">Revocación</h3>
        <p class="blv-priv-body">A revocar el consentimiento para cualquier tratamiento en cualquier momento.</p>
      </div>
    </div>
    <div class="blv-priv-aviso-box" style="margin-top:32px !important;">
      <p class="blv-priv-label">Reclamaciones</p>
      <p class="blv-priv-body" style="margin:0 !important;">Si considera que no le hemos atendido correctamente, tiene derecho a presentar una reclamación ante la <strong>Agencia Española de Protección de Datos</strong> (<a class="blv-priv-link" href="https://www.aepd.es" target="_blank" rel="noopener">www.aepd.es</a>). Los formularios para el ejercicio de derechos deben ir firmados electrónicamente o acompañados de fotocopia del DNI. Respondemos en un plazo máximo de un mes desde su solicitud.</p>
    </div>
  </div>

  <div class="blv-priv-section">
    <h2 class="blv-priv-title">Menores de Edad</h2>
    <p class="blv-priv-body">No tratamos datos de menores de 14 años. Si es menor de edad o se encuentra incluido en el Registro General de Interdicciones de Acceso al Juego, le rogamos que se abstenga de utilizar nuestros servicios y de proporcionarnos sus datos personales.</p>
    <p class="blv-priv-body">BINGO LAS VEGAS se exime de cualquier responsabilidad por el incumplimiento de esta previsión y se reserva el derecho a verificar el cumplimiento de los requisitos legales y a adoptar las medidas necesarias para cancelar los datos facilitados.</p>
  </div>

  <div class="blv-priv-section">
    <h2 class="blv-priv-title">Medidas de Seguridad</h2>
    <p class="blv-priv-body">Hemos adoptado un nivel óptimo de protección de los Datos Personales que manejamos, y hemos instalado todos los medios y medidas técnicas a nuestra disposición según el estado de la tecnología para evitar la pérdida, mal uso, alteración, acceso no autorizado y robo de los Datos Personales.</p>
    <p class="blv-priv-body">Toda la información y comunicaciones relativas a su compra o a la prestación de nuestro servicio se mantendrán mientras duren las garantías de los productos o servicios, para atender posibles reclamaciones.</p>
  </div>

</div>
HTML;
	}
}

class BLV_Politica_Cookies_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_politica_cookies'; }
	public function get_title() { return esc_html__( 'Política de Cookies', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-cog'; }

	// Sin acordeon: no necesita el JS de los widgets legales.
	public function get_script_depends() {
		return array();
	}

	protected function render() {
		echo <<<'HTML'
<div class="blv-cookies">

  <h1 class="blv-cookies-h1">Política de Cookies</h1>

  <div class="blv-cookies-intro">
    <p class="blv-cookies-body">Nuestra página web utiliza cookies, pequeños ficheros de datos que se generan en el ordenador del usuario y que nos permiten obtener la siguiente información:</p>
    <ul class="blv-cookies-list">
      <li>La fecha y hora de la última vez que el usuario visitó nuestro web.</li>
      <li>Elementos de seguridad que intervienen en el control de acceso a las áreas restringidas.</li>
    </ul>
  </div>

  <div class="blv-cookies-section">
    <h2 class="blv-cookies-title">Tipos de cookies utilizadas</h2>
    <div class="blv-cookies-table-wrap">
      <table class="blv-cookies-table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Finalidad</th>
            <th>Cuándo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Sesión</strong></td>
            <td>Registrar las entradas de datos del usuario en la web. Propietario: Las Vegas Juegos de España, S.A.</td>
            <td>Cuando el usuario rellena un formulario</td>
          </tr>
          <tr>
            <td><strong>Autenticación de usuarios</strong></td>
            <td>Identificarle como usuario registrado y permitirle la navegación por los distintos contenidos. Propietario: Las Vegas Juegos de España, S.A.</td>
            <td>Únicamente mientras dure la sesión</td>
          </tr>
          <tr>
            <td><strong>Plug-in de redes sociales</strong></td>
            <td>Permitir al usuario compartir contenidos con miembros de una determinada red social. Propietario: Red social que pone la cookie (Twitter Inc., Facebook Inc., …)</td>
            <td>Cuando hay algún plugin o botón de compartir en alguna red social</td>
          </tr>
          <tr>
            <td><strong>Google Analytics</strong></td>
            <td>Para realizar las estadísticas de uso de la web y conocer el nivel de recurrencia de los visitantes y los contenidos más interesantes. <a class="blv-cookies-link" href="https://www.google.com/intl/es/policies/privacy/" target="_blank" rel="noopener">Política de privacidad de Google</a>. Propietario: Google Inc.</td>
            <td>Cuando accede a la página</td>
          </tr>
          <tr>
            <td><strong>Google Fonts</strong></td>
            <td>Para una representación uniforme de las fuentes. El navegador carga las fuentes web requeridas estableciendo una conexión directa con los servidores de Google. Más info en <a class="blv-cookies-link" href="https://developers.google.com/fonts/faq" target="_blank" rel="noopener">developers.google.com/fonts/faq</a> y en la <a class="blv-cookies-link" href="https://www.google.com/policies/privacy/" target="_blank" rel="noopener">política de privacidad de Google</a>.</td>
            <td>Cuando accede a la página</td>
          </tr>
          <tr>
            <td><strong>iThemes Security</strong></td>
            <td>Algunos formularios requieren el servicio reCAPTCHA de Google. Si acepta su uso, se crea una cookie que almacena su consentimiento durante treinta días. Visitar la página de inicio de sesión establece una cookie temporal de compatibilidad que caduca tras 1 hora.</td>
            <td>Cuando accede a la página</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="blv-cookies-section">
    <h2 class="blv-cookies-title">Registros de seguridad</h2>
    <p class="blv-cookies-body">La dirección IP de los visitantes, la identificación de usuario de los usuarios que iniciaron sesión y el nombre de usuario de los intentos de inicio de sesión se registran de forma condicional para detectar actividad maliciosa y proteger el sitio. Esta información se conserva durante <strong>180 días</strong>.</p>
  </div>

  <div class="blv-cookies-section">
    <h2 class="blv-cookies-title">Con quién compartimos tus datos</h2>
    <ul class="blv-cookies-list">
      <li>Algunos formularios requieren el servicio <strong>reCAPTCHA de Google</strong>, sujeto a su política de privacidad y términos de uso.</li>
      <li>El <strong>SiteCheck de Sucuri</strong> analiza el sitio en busca de malware y vulnerabilidades. No se envía información personal a Sucuri.</li>
      <li><strong>iThemes Security</strong> extrae datos de wordpress.org, ithemes.com y amazonaws.com para garantizar la integridad del archivo. No se envían datos personales.</li>
      <li>Al ejecutar Security Check, se contacta a ithemes.com para determinar si el sitio admite TLS/SSL. Las solicitudes incluyen únicamente la URL del sitio.</li>
    </ul>
  </div>

  <div class="blv-cookies-section blv-cookies-highlight">
    <div class="blv-cookies-highlight-grid">
      <div>
        <p class="blv-cookies-label">Cuánto tiempo conservamos tus datos</p>
        <p class="blv-cookies-body" style="margin:0 !important;">Los registros de seguridad se conservan durante <strong>180 días</strong>.</p>
      </div>
      <div>
        <p class="blv-cookies-label">Dónde enviamos tus datos</p>
        <p class="blv-cookies-body" style="margin:0 !important;">La dirección IP de los visitantes que intentan iniciar sesión se comparte con un servicio de ithemes.com para proteger el sitio contra ataques distribuidos de fuerza bruta.</p>
      </div>
    </div>
  </div>

  <div class="blv-cookies-section">
    <h2 class="blv-cookies-title">Cómo gestionar las cookies</h2>
    <p class="blv-cookies-body">El usuario puede impedir la generación de cookies mediante la configuración de su navegador. Sin embargo, la empresa no se responsabiliza de que la desactivación impida el buen funcionamiento de la página.</p>
    <p class="blv-cookies-body">Para permitir, conocer, bloquear o eliminar las cookies instaladas en tu equipo:</p>
    <ul class="blv-cookies-browsers">
      <li><a class="blv-cookies-link" href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener">Firefox</a></li>
      <li><a class="blv-cookies-link" href="https://support.google.com/chrome/bin/answer.py?hl=es&answer=95647" target="_blank" rel="noopener">Chrome</a></li>
      <li><a class="blv-cookies-link" href="https://support.microsoft.com/es-es/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank" rel="noopener">Internet Explorer</a></li>
      <li><a class="blv-cookies-link" href="https://privacy.microsoft.com/es-es/windows-10-microsoft-edge-and-privacy" target="_blank" rel="noopener">Edge</a></li>
      <li><a class="blv-cookies-link" href="https://support.apple.com/kb/ph21411?locale=es_ES" target="_blank" rel="noopener">Safari</a></li>
      <li><a class="blv-cookies-link" href="http://help.opera.com/Windows/12.10/es-ES/cookies.html" target="_blank" rel="noopener">Opera</a></li>
    </ul>
  </div>

</div>
HTML;
	}
}

class BLV_Aviso_Legal_Widget extends BLV_Legal_Base_Widget {

	public function get_name() { return 'blv_aviso_legal'; }
	public function get_title() { return esc_html__( 'Aviso Legal', 'bingo-essentials' ); }
	public function get_icon() { return 'eicon-document-file'; }

	protected function render() {
		echo <<<'HTML'
<div class="blv-aviso">

  <h1 class="blv-aviso-h1">Aviso Legal</h1>

  <div class="blv-aviso-intro">
    <p class="blv-aviso-body">El acceso y la navegación en el sitio web, o el uso de los servicios del mismo, implican la aceptación expresa e íntegra de todas y cada una de las presentes Condiciones Generales, incluidas tanto las Condiciones Particulares fijadas para ciertas promociones como la Política de Privacidad y Cookies.</p>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">1. Información Legal</h2>
    <p class="blv-aviso-body">En cumplimiento de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico, los datos identificativos del titular del Portal Web son:</p>
    <div class="blv-aviso-highlight">
      <div class="blv-aviso-highlight-grid">
        <div>
          <p class="blv-aviso-label">Razón social</p>
          <p class="blv-aviso-body" style="margin:0 !important;">LAS VEGAS JUEGOS DE ESPAÑA SA</p>
        </div>
        <div>
          <p class="blv-aviso-label">Domicilio</p>
          <p class="blv-aviso-body" style="margin:0 !important;">C/ Vizconde de los Asilos 4, Bajo B — 28027 Madrid</p>
        </div>
        <div>
          <p class="blv-aviso-label">CIF</p>
          <p class="blv-aviso-body" style="margin:0 !important;">A81527137</p>
        </div>
        <div>
          <p class="blv-aviso-label">Registro Mercantil de Madrid</p>
          <p class="blv-aviso-body" style="margin:0 !important;">Tomo 11.371, Libro 0, Sección 8, Folio 9, Hoja M-178634, Inscripción 1</p>
        </div>
        <div>
          <p class="blv-aviso-label">Registro del Juego</p>
          <p class="blv-aviso-body" style="margin:0 !important;">Nº JC-0099 — Comunidad Autónoma de Madrid</p>
        </div>
        <div>
          <p class="blv-aviso-label">Contacto</p>
          <p class="blv-aviso-body" style="margin:0 !important;"><a class="blv-aviso-link" href="mailto:contacto@bingolasvegas.es">contacto@bingolasvegas.es</a><br>Avda. de la Institución Libre de Enseñanza 17, 28037 Madrid</p>
        </div>
      </div>
    </div>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">2. Condiciones Generales de Uso</h2>
    <p class="blv-aviso-body">Las siguientes Condiciones Generales regulan el uso y acceso al portal Web, cuya finalidad es ser puerta de entrada a BINGO LAS VEGAS, ofreciendo a los usuarios información, servicios y contenidos vía Web.</p>
    <p class="blv-aviso-body">El Usuario se compromete a hacer un uso adecuado de los contenidos, servicios y herramientas accesibles, con sujeción a la Ley y a las presentes Condiciones Generales. En caso de incumplimiento, BINGO LAS VEGAS se reserva el derecho de denegar el acceso sin previo aviso.</p>
    <div class="blv-aviso-aviso-box">
      <p class="blv-aviso-label">Protección de menores y otros</p>
      <p class="blv-aviso-body" style="margin:0 !important;">Si Vd. es menor de edad, está incapacitado o se encuentra incluido en el Registro General de Interdicciones de Acceso al Juego o en el Registro de Personas Vinculadas a Operadores de Juego, no puede acceder a nuestra Sala de Bingo ni hacer uso de los servicios ofrecidos a través de este sitio web.</p>
    </div>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">3. Obligaciones Generales del Usuario</h2>
    <p class="blv-aviso-body">El Usuario, al aceptar las presentes Condiciones Generales de Uso, se obliga expresamente a:</p>
    <ul class="blv-aviso-list">
      <li>No realizar ninguna acción destinada a perjudicar, bloquear, dañar o inutilizar las funcionalidades, herramientas o infraestructura de la página web.</li>
      <li>Custodiar y mantener la confidencialidad de las claves de acceso asociadas a su nombre de Usuario.</li>
      <li>No introducir contenidos injuriosos o calumniosos, tanto de otros Usuarios como de terceras empresas.</li>
      <li>No utilizar los materiales e informaciones contenidos en este Sitio Web con fines ilícitos o contrarios a los derechos de BINGO LAS VEGAS, sus usuarios y/o terceros.</li>
      <li>No ofertar ni distribuir productos y servicios, ni realizar publicidad o comunicaciones comerciales no solicitadas a otros Usuarios.</li>
    </ul>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">4. Propiedad Intelectual e Industrial</h2>
    <p class="blv-aviso-body">El sitio web, las páginas que comprende y la información o elementos contenidos en las mismas (incluyendo textos, documentos, fotografías, dibujos, representaciones gráficas), así como logotipos, marcas y nombres comerciales, se encuentran protegidos por derechos de propiedad intelectual o industrial de los que BINGO LAS VEGAS es titular.</p>
    <p class="blv-aviso-body">BINGO LAS VEGAS autoriza al Usuario para visualizar la información contenida en este sitio y para efectuar reproducciones privadas destinadas exclusivamente al uso personal. El Usuario no está autorizado para distribuir, modificar, ceder o comunicar públicamente dicha información.</p>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">5. Enlaces</h2>
    <p class="blv-aviso-body">Las conexiones y enlaces a sitios o páginas Web de terceros se han establecido únicamente como una utilidad para el Usuario. BINGO LAS VEGAS no es responsable de las mismas ni de su contenido, y tales enlaces tienen una finalidad exclusivamente informativa.</p>
    <p class="blv-aviso-body">Para realizar enlaces con la página Web será necesaria la autorización expresa y por escrito de los titulares del portal.</p>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">6. Responsabilidad</h2>
    <p class="blv-aviso-body">BINGO LAS VEGAS no garantiza el acceso continuado ni la correcta visualización de los elementos contenidos en las páginas del portal, que pueden verse impedidos por factores fuera de su control. BINGO LAS VEGAS no asume responsabilidad alguna por daños producidos por:</p>
    <ul class="blv-aviso-list">
      <li>Interferencias, interrupciones, fallos, omisiones o retrasos motivados por errores en líneas y redes de telecomunicaciones.</li>
      <li>Intromisiones ilegítimas mediante el uso de programas malignos, virus informáticos o cualesquiera otros.</li>
      <li>Uso indebido o inadecuado de la página web de BINGO LAS VEGAS.</li>
      <li>Errores de seguridad o navegación producidos por un mal funcionamiento del navegador o uso de versiones no actualizadas.</li>
    </ul>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">7. Protección de Datos de Carácter Personal</h2>

    <ul class="blv-aviso-accordion">

      <li class="blv-aviso-faq active">
        <button class="blv-aviso-faq-btn" type="button">
          <span>Contactos a través de formularios o correo electrónico</span>
          <div class="blv-aviso-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-aviso-faq-content">
          <p class="blv-aviso-body">Podemos tratar su IP, sistema operativo, navegador y duración de visita de forma anónima. Tratamos los datos para contestar sus consultas, gestionar el servicio solicitado, enviar información por medios electrónicos sobre su solicitud y realizar análisis y mejoras en la Web.</p>
          <p class="blv-aviso-body">La aceptación se produce al cumplimentar un formulario y hacer click en enviar. Los campos obligatorios están marcados con *. No tratamos datos de menores de 14 años.</p>
        </div>
      </li>

      <li class="blv-aviso-faq">
        <button class="blv-aviso-faq-btn" type="button">
          <span>Contactos en redes sociales</span>
          <div class="blv-aviso-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-aviso-faq-content">
          <p class="blv-aviso-body">Utilizamos los datos para contestar consultas, gestionar el servicio solicitado y relacionarnos con usted creando una comunidad de seguidores. Los trataremos mientras siga siguiéndonos o siendo amigos en la red social correspondiente.</p>
          <div class="blv-aviso-redes">
            <a class="blv-aviso-link" href="http://www.facebook.com/policy.php" target="_blank" rel="noopener">Facebook</a>
            <a class="blv-aviso-link" href="https://help.instagram.com/155833707900388" target="_blank" rel="noopener">Instagram</a>
            <a class="blv-aviso-link" href="http://twitter.com/privacy" target="_blank" rel="noopener">Twitter</a>
            <a class="blv-aviso-link" href="http://www.linkedin.com/legal/privacy-policy" target="_blank" rel="noopener">LinkedIn</a>
            <a class="blv-aviso-link" href="https://about.pinterest.com/es/privacy-policy" target="_blank" rel="noopener">Pinterest</a>
            <a class="blv-aviso-link" href="http://www.google.com/intl/es/policies/privacy/" target="_blank" rel="noopener">Google</a>
          </div>
        </div>
      </li>

      <li class="blv-aviso-faq">
        <button class="blv-aviso-faq-btn" type="button">
          <span>Demandantes de empleo</span>
          <div class="blv-aviso-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-aviso-faq-content">
          <p class="blv-aviso-body">Los datos del CV se utilizan para organizar procesos de selección, citar para entrevistas de trabajo y evaluar candidaturas. Con su consentimiento, podremos cederlos a empresas colaboradoras para ayudarle a encontrar empleo.</p>
          <p class="blv-aviso-body">Transcurrido un año desde la recepción del currículum vitae, procederemos a su destrucción segura. La base legal es el consentimiento inequívoco del interesado al enviarnos su CV.</p>
        </div>
      </li>

      <li class="blv-aviso-faq">
        <button class="blv-aviso-faq-btn" type="button">
          <span>Sus derechos</span>
          <div class="blv-aviso-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-aviso-faq-content">
          <ul class="blv-aviso-list" style="margin-top:0 !important;">
            <li>A saber si estamos tratando sus datos o no.</li>
            <li>A acceder a sus datos personales.</li>
            <li>A solicitar la rectificación de sus datos si son inexactos.</li>
            <li>A solicitar la supresión de sus datos si ya no son necesarios.</li>
            <li>A solicitar la limitación del tratamiento de sus datos.</li>
            <li>A portar sus datos en un formato estructurado y de lectura mecánica.</li>
            <li>A presentar una reclamación ante la Agencia Española de Protección de Datos.</li>
            <li>A revocar el consentimiento para cualquier tratamiento en cualquier momento.</li>
          </ul>
          <p class="blv-aviso-body">Disponemos de formularios para el ejercicio de sus derechos. Puede solicitarlos por email o usar los elaborados por la AEPD. Los formularios deben ir firmados electrónicamente o acompañados de fotocopia del DNI.</p>
        </div>
      </li>

      <li class="blv-aviso-faq">
        <button class="blv-aviso-faq-btn" type="button">
          <span>Conservación de datos — tabla de plazos</span>
          <div class="blv-aviso-plus" aria-hidden="true"></div>
        </button>
        <div class="blv-aviso-faq-content">
          <div class="blv-aviso-table-wrap">
            <table class="blv-aviso-table">
              <thead>
                <tr>
                  <th>Fichero</th>
                  <th>Documento</th>
                  <th>Conservación</th>
                </tr>
              </thead>
              <tbody>
                <tr><td><strong>Clientes</strong></td><td>Facturas</td><td>10 años</td></tr>
                <tr><td></td><td>Formularios y cupones</td><td>15 años</td></tr>
                <tr><td></td><td>Contratos</td><td>5 años</td></tr>
                <tr><td><strong>Recursos Humanos</strong></td><td>Nóminas, TC1, TC2, etc.</td><td>10 años</td></tr>
                <tr><td></td><td>Currículums</td><td>Fin del proceso + 1 año</td></tr>
                <tr><td></td><td>Contratos e indemnizaciones</td><td>4 años</td></tr>
                <tr><td></td><td>Expediente del trabajador</td><td>Hasta 5 años tras la baja</td></tr>
                <tr><td><strong>Márketing</strong></td><td>Bases de datos / visitantes web</td><td>Mientras dure el tratamiento</td></tr>
                <tr><td><strong>Proveedores</strong></td><td>Facturas</td><td>10 años</td></tr>
                <tr><td></td><td>Contratos</td><td>5 años</td></tr>
                <tr><td><strong>Control de acceso</strong></td><td>Lista de visitantes</td><td>30 días</td></tr>
                <tr><td></td><td>Vídeos</td><td>30 días bloqueo / 3 años destrucción</td></tr>
                <tr><td><strong>Contabilidad</strong></td><td>Libros y documentos contables</td><td>6 años</td></tr>
                <tr><td><strong>Fiscal</strong></td><td>Administración y pago de impuestos</td><td>10 años</td></tr>
                <tr><td><strong>Seguridad y Salud</strong></td><td>Registros médicos de trabajadores</td><td>5 años</td></tr>
                <tr><td><strong>Seguros</strong></td><td>Pólizas (regla general)</td><td>6 años</td></tr>
                <tr><td><strong>Jurídico</strong></td><td>Contratos y acuerdos</td><td>5 años</td></tr>
                <tr><td></td><td>Permisos y licencias</td><td>6 años desde expiración</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </li>

    </ul>
  </div>

  <div class="blv-aviso-section">
    <h2 class="blv-aviso-title">8. Legislación</h2>
    <p class="blv-aviso-body">El presente Aviso Legal y sus términos y condiciones se regirán e interpretarán de acuerdo con la Legislación Española. El usuario, por el solo hecho de acceder a la página web, otorga de forma irrevocable su consentimiento a que los Tribunales competentes puedan conocer de cualquier acción judicial derivada de las presentes condiciones.</p>
    <p class="blv-aviso-body">Si alguna cláusula de las presentes Condiciones Generales es declarada nula o inaplicable, la validez de las restantes cláusulas no se verá afectada.</p>
  </div>

</div>
HTML;
	}
}
