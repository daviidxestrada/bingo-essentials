/* Bingo Essentials - lightbox para partidas especiales */
(function () {
    'use strict';

    function initWidget(widget) {
        if (!widget || widget.getAttribute('data-blv26-premios-ready') === 'true') {
            return;
        }

        var openButton = widget.querySelector('[data-blv26-premios-open]');
        var lightbox = widget.querySelector('[data-blv26-premios-lightbox]');
        var sourceImage = openButton ? openButton.querySelector('.blv26-premios-poster') : null;
        var lightboxImage = lightbox ? lightbox.querySelector('[data-blv26-premios-image]') : null;
        var closeButton = lightbox ? lightbox.querySelector('[data-blv26-premios-close]') : null;
        var openClass = 'blv26-premios-lightbox--open';
        var bodyOpenClass = 'blv26-premios-lightbox-open';
        var lastActiveElement = null;

        if (!openButton || !lightbox || !sourceImage || !lightboxImage || !closeButton) {
            return;
        }

        widget.setAttribute('data-blv26-premios-ready', 'true');

        if (lightbox.parentNode !== document.body) {
            document.body.appendChild(lightbox);
        }

        function openLightbox() {
            lastActiveElement = document.activeElement;
            lightboxImage.src = sourceImage.currentSrc || sourceImage.src;
            lightboxImage.alt = sourceImage.alt || '';
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

        openButton.addEventListener('click', openLightbox);
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
        if (root.matches && root.matches('[data-blv26-premios-widget]')) {
            initWidget(root);
        }
        root.querySelectorAll('[data-blv26-premios-widget]').forEach(initWidget);
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
                elementorFrontend.hooks.addAction('frontend/element_ready/blv_partidas_especiales.default', function ($scope) {
                    initAll($scope && $scope[0] ? $scope[0] : document);
                });
            }
        });
    }
})();
