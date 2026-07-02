/* =============================================================
   BINGO LAS VEGAS – Animaciones del widget "Dónde Estamos"
   REGLA DE ORO: el contenido SIEMPRE se muestra. Las animaciones
   son un extra; si GSAP falla, no carga o da error, el contenido
   se revela igualmente (failsafe incondicional + try/catch).
   ============================================================= */
(function () {
    'use strict';

    // Revela (quita el gate CSS) todos los widgets aún "pending".
    function revealAll( scope ) {
        var root = ( scope && scope.querySelectorAll ) ? scope : document;
        var ws = root.querySelectorAll( '.blv-widget[data-blv-anim="pending"]' );
        for ( var i = 0; i < ws.length; i++ ) {
            ws[ i ].setAttribute( 'data-blv-anim', 'ready' );
        }
    }

    // Anima un widget concreto. Si algo va mal, lo revela sin animar.
    function animateWidget( w ) {
        if ( w.__blvInit ) { return; }   // ya procesado
        w.__blvInit = true;

        var gsap = window.gsap, ScrollTrigger = window.ScrollTrigger;
        var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

        // Sin GSAP o con movimiento reducido: mostrar sin animar.
        if ( ! gsap || ! ScrollTrigger || reduce ) {
            w.setAttribute( 'data-blv-anim', 'ready' );
            return;
        }

        try {
            gsap.registerPlugin( ScrollTrigger );

            w.querySelectorAll( '.location-section' ).forEach( function ( sec, i ) {
                var isReverse = sec.classList.contains( 'blv-reverse' );
                var card = sec.querySelector( '.location-info-card' );
                var mapWrap = sec.querySelector( '.map-legal-wrapper' );
                var cardKids = sec.querySelectorAll( '.loc-badge, .loc-title, .loc-address, .loc-details, .actions' );

                var onLoad = i === 0;
                var tl = gsap.timeline( {
                    defaults: { ease: 'power2.out' },
                    delay: onLoad ? 0.2 : 0,
                    scrollTrigger: onLoad ? undefined : { trigger: sec, start: 'top 80%', once: true }
                } );
                if ( card ) {
                    tl.from( card, { autoAlpha: 0, x: isReverse ? 50 : -50, duration: 0.6 } );
                }
                if ( cardKids.length ) {
                    tl.from( cardKids, { y: 18, duration: 0.45, stagger: 0.06 }, '-=0.4' );
                }
                if ( mapWrap ) {
                    tl.from( mapWrap, { autoAlpha: 0, x: isReverse ? -50 : 50, duration: 0.6 }, '-=0.55' );
                }
            } );

            w.querySelectorAll( '.section-divider' ).forEach( function ( d ) {
                gsap.from( d, {
                    scaleX: 0, transformOrigin: 'center', duration: 0.7, ease: 'power2.out',
                    scrollTrigger: { trigger: d, start: 'top 90%', once: true }
                } );
            } );

            // Estados iniciales ya aplicados por GSAP -> quitar el gate CSS.
            w.setAttribute( 'data-blv-anim', 'ready' );
        } catch ( e ) {
            // Pase lo que pase, mostrar el contenido.
            w.setAttribute( 'data-blv-anim', 'ready' );
        }
    }

    function initAll( scope ) {
        var root = ( scope && scope.querySelectorAll ) ? scope : document;
        var ws = root.querySelectorAll( '.blv-widget' );
        for ( var i = 0; i < ws.length; i++ ) {
            animateWidget( ws[ i ] );
        }
    }

    // --- FAILSAFE INCONDICIONAL: pase lo que pase, el contenido se ve. ---
    setTimeout( function () { revealAll( document ); }, 2000 );

    // --- Init normal (front-end) ---
    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', function () { initAll( document ); } );
    } else {
        initAll( document );
    }
    // Reintento al terminar de cargar (por si GSAP llegó tarde).
    window.addEventListener( 'load', function () { initAll( document ); } );

    // --- Editor / preview de Elementor ---
    if ( window.jQuery ) {
        jQuery( window ).on( 'elementor/frontend/init', function () {
            if ( window.elementorFrontend && elementorFrontend.hooks ) {
                elementorFrontend.hooks.addAction( 'frontend/element_ready/blv_donde_estamos.default', function ( $scope ) {
                    var el = ( $scope && $scope[ 0 ] ) ? $scope[ 0 ] : document;
                    setTimeout( function () { initAll( el ); }, 50 );
                } );
            }
        } );
    }
})();
