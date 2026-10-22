# Bingo Essentials

Plugin de WordPress para Elementor con los widgets esenciales de Bingo Las Vegas.

## Widgets incluidos

- **Dónde Estamos**: conserva el widget anterior de sala y aparcamiento.
- **Hero - Nuestra Historia**.
- **El nacimiento**.
- **Fenomeno pop y famosos**.
- **Cine y television**.
- **Revolucion digital**.
- **CTA - Nuestra Historia**.
- **Cards experiencias**.
- **Carrusel cards sorteos/promos**.
- **Enlace con flecha underline**.
- **Partidas especiales**.
- **Carta**.
- **Canal Etico**.
- **Politica de Privacidad**.
- **Politica de Cookies**.
- **Aviso Legal**.
- **Cabecera Bingo Las Vegas**: logo, enlaces y redes editables; el menú pasa a hamburguesa solo cuando los enlaces no caben.
- **Pie de página Bingo Las Vegas**: juego responsable, logo, enlaces legales, redes, copyright y créditos editables.

Todos aparecen en la categoria **Bingo Essentials** de Elementor.

## Panel "Fotos Home"

En el escritorio de WordPress, **Fotos Home** permite cambiar el cartel de Partidas
especiales y las imágenes de Promociones de la Home sin entrar en Elementor. El rol
**Marketing (Fotos Home)** solo da acceso a ese panel y a la biblioteca de medios.

## Iconos

Todos los iconos son [Phosphor](https://phosphoricons.com/) (MIT). Los fijos del plugin se
pintan como SVG en línea (`blv_be_icon()`); en Elementor aparecen las bibliotecas
**Phosphor** y **Phosphor (relleno)** en el selector de iconos.

## Actualizaciones

Incluye `YahnisElsts/plugin-update-checker` en `vendor/plugin-update-checker`
y revisa actualizaciones desde:

`https://github.com/daviidxestrada/bingo-essentials/`

La rama estable configurada es `main`.

## Edicion en Elementor

Los widgets de **Nuestra Historia**, los bloques visuales y las paginas legales
exponen textos, listas, acordeones, tablas, imagenes y PDFs desde el panel de
contenido. El diseno queda encapsulado en el plugin y los medios usan controles
`MEDIA` filtrados por tipo para elegir imagenes o documentos desde WordPress.

## Instalacion

1. Comprime o sube la carpeta `bingo-essentials`.
2. En WordPress ve a **Plugins -> Anadir nuevo -> Subir plugin**.
3. Sube `bingo-essentials.zip`, instala y activa.
4. Edita la pagina con Elementor y busca la categoria **Bingo Essentials**.

## Estructura

```
bingo-essentials/
├── bingo-essentials.php
├── widgets/
│   ├── class-donde-estamos-widget.php
│   └── class-nuestra-historia-widgets.php
└── assets/
    ├── css/
    │   ├── donde-estamos.css
    │   └── nuestra-historia.css
    ├── js/
    │   ├── donde-estamos.js
    │   ├── nuestra-historia.js
    │   ├── gsap.min.js
    │   └── ScrollTrigger.min.js
    └── fonts/
```

El plugin mantiene fuentes, GSAP, ScrollTrigger y PDF.js en local, igual que el
plugin anterior.
