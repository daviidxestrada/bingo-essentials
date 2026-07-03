/* Bingo Essentials - lightbox para promociones */
(function () {
    'use strict';

    function initWidget(widget) {
        if (!widget || widget.getAttribute('data-blv26-sp-ready') === 'true') {
            return;
        }

        var cards = widget.querySelectorAll('[data-blv26-sp-src]');
        var lightbox = widget.querySelector('[data-blv26-sp-lightbox]');
        var lightboxImage = lightbox ? lightbox.querySelector('[data-blv26-sp-image]') : null;
        var closeButton = lightbox ? lightbox.querySelector('[data-blv26-sp-close]') : null;
        var openClass = 'blv26-sp-lightbox--open';
        var bodyOpenClass = 'blv26-sp-lightbox-open';
        var lastActiveElement = null;

        if (!cards.length || !lightbox || !lightboxImage || !closeButton) {
            return;
        }

        widget.setAttribute('data-blv26-sp-ready', 'true');

        if (lightbox.parentNode !== document.body) {
            document.body.appendChild(lightbox);
        }

        function openLightbox(src, alt) {
            lastActiveElement = document.activeElement;
            lightboxImage.src = src;
            lightboxImage.alt = alt || '';
            lightbox.classList.add(openClass);
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.classList.add(bodyOpenClass);
            closeButton.focus({ preventScroll: true });
        }

        function closeLightbox() {
            lightbox.classList.remove(openClass);
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.classList.remove(bodyOpenClass);
            lightboxImage.removeAttribute('src');

            if (lastActiveElement && typeof lastActiveElement.focus === 'function') {
                lastActiveElement.focus({ preventScroll: true });
            }
        }

        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                openLightbox(
                    card.getAttribute('data-blv26-sp-src'),
                    card.getAttribute('data-blv26-sp-alt')
                );
            });
        });

        closeButton.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && lightbox.classList.contains(openClass)) {
                closeLightbox();
            }
        });
    }

    function initAll(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        if (root.matches && root.matches('[data-blv26-sp-widget]')) {
            initWidget(root);
        }
        root.querySelectorAll('[data-blv26-sp-widget]').forEach(initWidget);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initAll(document); });
    } else {
        initAll(document);
    }
    window.addEventListener('load', function () { initAll(document); });

    if (window.jQuery) {
        jQuery(window).on('elementor/frontend/init', function () {
            if (window.elementorFrontend && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction('frontend/element_ready/blv_sorteos_promos.default', function ($scope) {
                    initAll($scope && $scope[0] ? $scope[0] : document);
                });
            }
        });
    }
})();
