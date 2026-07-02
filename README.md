# Bingo Essentials

Plugin de WordPress para Elementor con los widgets esenciales de Bingo Las Vegas.

## Widgets incluidos

- **Dónde Estamos**: conserva el widget anterior de sala y aparcamiento.
- **Hero - Nuestra Historia**.
- **El nacimiento**.
- **Fenomeno pop y famosos**.
- **Cine y television**.
- **Revolucion digital**.

Todos aparecen en la categoria **Bingo Essentials** de Elementor.

## Actualizaciones

Incluye `YahnisElsts/plugin-update-checker` en `vendor/plugin-update-checker`
y revisa actualizaciones desde:

`https://github.com/daviidxestrada/bingo-essentials/`

La rama estable configurada es `main`.

## Edicion en Elementor

Los widgets de **Nuestra Historia** exponen textos e imagenes desde el panel de
contenido. Todas las imagenes usan el control `MEDIA`, asi que se pueden elegir
desde la biblioteca de medios de WordPress.

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

El plugin mantiene fuentes, GSAP y ScrollTrigger en local, igual que el plugin
anterior.
