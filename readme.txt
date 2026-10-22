=== Bingo Essentials ===
Contributors: bingolasvegas
Tags: elementor, widgets, bingo
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.28
License: GPLv2 or later

Widgets esenciales de Elementor para Bingo Las Vegas.

== Description ==

Bingo Essentials incluye widgets de Elementor para las secciones "Dónde Estamos"
y "Nuestra Historia" de Bingo Las Vegas.

== Changelog ==

= 1.0.28 =
* Cabecera: el botón de menú ya no se vuelve rosa (#c36 de Hello Elementor) al recibir el foco o pulsarlo.
* Visor de la carta y preguntas legales: estados blindados frente al tema y foco visible con teclado.

= 1.0.27 =
* Cabecera de página: corrige la imagen en modo "imagen arriba" en móvil (quedaba con alto 0).

= 1.0.26 =
* Cabecera de página: opción "Móvil: imagen arriba y texto debajo" para fotos cuyo elemento principal no debe quedar tapado.
* Formularios: el botón de enviar ocupa todo el ancho de la tarjeta.

= 1.0.25 =
* Nuestra Historia: secciones alineadas a la rejilla común.

= 1.0.24 =
* Clase .blv-section para alinear cualquier sección de Elementor a la rejilla común.

= 1.0.23 =
* Nuevo widget "Mapa con dirección": mapa de Google en el marco de la casa con tarjeta de dirección, horario, aparcamiento y "Cómo llegar".
* Formularios: tarjeta, campos, foco, casilla y botón comunes (.blv-form-card) para Contacto y Trabaja con nosotros.
* Rejilla común: un ancho de contenido (1240 px) y un margen lateral para cabecera, heroes, secciones y pie.
* Heroes: la imagen de fondo cubre siempre la sección (Elementor forzaba height:auto en móvil), encuadre vertical ajustable y oscurecido solo donde está el texto.

= 1.0.22 =
* Nuevo widget "Hero portada": vídeo a sangre completa; la línea manuscrita se escribe letra a letra con un trazo dorado y se enciende como un neón, después entran titular, filete y botón.
* Nuevo widget "Cabecera de página": banda con vídeo o foto, texto apoyado abajo o centrado, titular letra a letra (o palabra a palabra en frases), filete, texto y botón.
* Ambos respetan "reducir movimiento" y se ven completos aunque falle el JavaScript.

= 1.0.21 =
* La hoja de la fuente Phosphor solo se carga cuando algún icono no está incluido como SVG.

= 1.0.20 =
* Iconos Phosphor en todo el plugin (SVG en línea): menú hamburguesa y cerrar, flechas del desplegable, redes de cabecera y pie, enlace con flecha, pestañas de la carta, botones de cerrar de los visores, Nuestra Historia y panel Fotos Home.
* Phosphor y Phosphor (relleno) disponibles en el selector de iconos de Elementor (fuentes locales, solo woff2).

= 1.0.19 =
* Nuevo widget "Pie de página Bingo Las Vegas": franja de juego responsable con sello +18, logo, enlaces legales, redes, copyright con año automático y créditos; todo editable y responsive.
* Cabecera: el bloqueo de scroll del menú móvil ya no desactiva la cabecera fija (era lo que dejaba ver la página por encima del menú).

= 1.0.18 =
* Cabecera: el menú desplegable cubre toda la pantalla bajo la barra (ya no asoma la página por encima), se coloca según la posición real de la barra y bloquea el scroll de fondo también en iOS. En móvil la cabecera fija ignora la barra de administración, que allí no es fija.

= 1.0.17 =
* Partidas especiales: título y cartel más juntos y centrados en escritorio.

= 1.0.16 =
* Cabecera: los iconos de redes mantienen el blanco aunque el kit tenga color de enlace propio. Control "Fija al hacer scroll" renombrado para no chocar con el sticky de Elementor Pro.

= 1.0.15 =
* Nuevo widget "Cabecera Bingo Las Vegas": logo, enlaces y redes editables; el menú pasa a hamburguesa solo cuando los enlaces no caben, con panel desplegable accesible (teclado, Escape, foco).
* Partidas especiales: el bloque de título se ajusta a su contenido para acercar el cartel al centro.

= 1.0.14 =
* Panel "Fotos Home" en el escritorio de WordPress y rol "Marketing (Fotos Home)" para cambiar el cartel de Partidas especiales y las imágenes de Promociones sin entrar en Elementor.
* Filtro anti-spam para los formularios de Elementor (enlaces en el nombre, alfabetos no latinos, teléfonos imposibles).
* Estilos globales: titulares sobre vídeo con rótulo manuscrito (Yellowtail, local) y sombras en capas; estilos de la página Trabaja con nosotros.
* Nuevo verde de fondo del sitio (#052000) en todos los widgets.
* Partidas especiales: composición centrada en escritorio.
* Dónde Estamos: la descripción de cada detalle admite varias líneas (horarios).

= 1.0.13 =
* Corrige las URLs por defecto de imagenes y PDFs de los widgets, que apuntaban al dominio de desarrollo. Ahora se resuelven contra el dominio de la instalacion.

= 1.0.12 =
* Actualiza compatibilidad probada hasta Elementor 4.1.4.

= 1.0.11 =
* Refuerza la UX de edicion filtrando selectores de imagen por tipo y evitando renders vacios cuando una imagen se elimina.

= 1.0.10 =
* Añade controles editables seguros a los widgets legales: textos, listas, acordeones, tablas, imágenes y PDFs desde Elementor.

= 1.0.9 =
* Añade widgets legales: Canal Ético, Política de Privacidad, Política de Cookies y Aviso Legal.

= 1.0.8 =
* Permite seleccionar PDFs desde la biblioteca de medios en el widget Carta.

= 1.0.7 =
* Añade widget Carta con visor PDF para carta, bebidas y alérgenos.

= 1.0.6 =
* Añade animaciones de entrada sutiles a los widgets visuales sin animacion propia.

= 1.0.5 =
* Añade widget Partidas especiales con cartel editable desde medios y visor ampliado.

= 1.0.4 =
* Añade widgets Cards experiencias, Carrusel cards sorteos/promos y Enlace con flecha underline.
* Sustituye el icono del dato curioso por un icono Lucide y elimina el adorno rosa lateral.

= 1.0.3 =
* Añade bloque editable de dato curioso al widget Cine y television.

= 1.0.2 =
* Evita que las cards de producciones queden ocultas si ScrollTrigger no dispara.
* Añade fallback real de imagen para URLs antiguas guardadas en Elementor.

= 1.0.1 =
* Añade widget CTA final para Nuestra Historia.
* Mejora el fallback visual de cards de producciones.
* Ajusta espaciado responsive en acentos de imagen.

= 1.0.0 =
* Version inicial.
