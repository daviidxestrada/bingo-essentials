/* Bingo Essentials - widget "Cabecera" */
(function () {
    'use strict';

    function fit(header) {
        if (window.BLVHeaderFit) {
            window.BLVHeaderFit(header);
        }
        if (!header.classList.contains('is-compact')) {
            close(header);
        }
    }

    // Borde inferior real de la barra en pantalla (admin bar, scroll, etc.).
    function placeDrawer(header) {
        var bar = header.querySelector('.blv-hd__bar');
        var bottom = Math.max(0, Math.round(bar.getBoundingClientRect().bottom));
        header.style.setProperty('--blv-hd-drawer-top', bottom + 'px');
    }

    // iOS ignora overflow:hidden en html/body: se bloquea el gesto de
    // arrastre fuera del panel (y dentro, si el panel no tiene scroll propio).
    var lockedHeader = null;
    function blockTouch(event) {
        if (!lockedHeader) {
            return;
        }
        var drawer = lockedHeader.querySelector('[data-blv-hd-drawer]');
        var insideScrollable = drawer.contains(event.target) && drawer.scrollHeight > drawer.clientHeight;
        if (!insideScrollable) {
            event.preventDefault();
        }
    }
    document.addEventListener('touchmove', blockTouch, { passive: false });

    function open(header) {
        var toggle = header.querySelector('[data-blv-hd-toggle]');
        placeDrawer(header);
        lockedHeader = header;
        header.classList.add('is-open');
        document.documentElement.classList.add('blv-hd-locked');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.querySelector('[data-blv-hd-toggle-text]').textContent = 'Cerrar';
        var first = header.querySelector('[data-blv-hd-drawer] a');
        if (first) {
            window.setTimeout(function () { first.focus({ preventScroll: true }); }, 250);
        }
    }

    function close(header, returnFocus) {
        if (!header.classList.contains('is-open')) {
            return;
        }
        var toggle = header.querySelector('[data-blv-hd-toggle]');
        lockedHeader = null;
        header.classList.remove('is-open');
        document.documentElement.classList.remove('blv-hd-locked');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.querySelector('[data-blv-hd-toggle-text]').textContent = 'Menú';
        if (returnFocus) {
            toggle.focus();
        }
    }

    function init(header) {
        if (!header || header.__blvHd) {
            return;
        }
        header.__blvHd = true;

        var toggle = header.querySelector('[data-blv-hd-toggle]');
        var drawer = header.querySelector('[data-blv-hd-drawer]');

        toggle.addEventListener('click', function () {
            if (header.classList.contains('is-open')) {
                close(header, false);
            } else {
                open(header);
            }
        });

        drawer.addEventListener('click', function (event) {
            if (event.target.closest('a')) {
                close(header, false);
            }
        });

        header.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                close(header, true);
                return;
            }
            // Mantiene el foco dentro del panel abierto.
            if (event.key === 'Tab' && header.classList.contains('is-open')) {
                var items = [toggle].concat(Array.prototype.slice.call(drawer.querySelectorAll('a')));
                var firstItem = items[0];
                var lastItem = items[items.length - 1];
                if (event.shiftKey && document.activeElement === firstItem) {
                    event.preventDefault();
                    lastItem.focus();
                } else if (!event.shiftKey && document.activeElement === lastItem) {
                    event.preventDefault();
                    firstItem.focus();
                }
            }
        });

        // Vuelve a decidir el modo cuando cambia el ancho o cargan las fuentes.
        var frame = 0;
        var refit = function () {
            cancelAnimationFrame(frame);
            frame = requestAnimationFrame(function () {
                fit(header);
                if (header.classList.contains('is-open')) {
                    placeDrawer(header);
                }
            });
        };
        if ('ResizeObserver' in window) {
            new ResizeObserver(refit).observe(header.querySelector('.blv-hd__bar'));
        } else {
            window.addEventListener('resize', refit);
        }
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(refit);
        }
        refit();

        // Barra más baja al hacer scroll.
        var ticking = false;
        var onScroll = function () {
            if (ticking) {
                return;
            }
            ticking = true;
            requestAnimationFrame(function () {
                header.classList.toggle('is-scrolled', window.scrollY > 12);
                if (header.classList.contains('is-open')) {
                    placeDrawer(header);
                }
                ticking = false;
            });
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    function boot(scope) {
        (scope || document).querySelectorAll('[data-blv-hd]').forEach(init);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { boot(); });
    } else {
        boot();
    }

    // Vista previa del editor de Elementor.
    window.addEventListener('elementor/frontend/init', function () {
        if (window.elementorFrontend && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/blv_site_header.default', function ($scope) {
                boot($scope[0]);
            });
        }
    });
})();
