/* Bingo Essentials - entrada sutil para widgets visuales */
(function () {
    'use strict';

    var widgetSelector = '.blv26-exp-widget, .blv26-sp-widget, .blv26-premios-widget, .blv26-arrow-link';
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function getTargets(widget) {
        if (widget.classList.contains('blv26-exp-widget')) {
            return widget.querySelectorAll('.blv26-exp-card');
        }
        if (widget.classList.contains('blv26-sp-widget')) {
            return widget.querySelectorAll('.blv26-sp-card');
        }
        if (widget.classList.contains('blv26-premios-widget')) {
            return widget.querySelectorAll('.blv26-premios-content, .blv26-premios-poster-wrap');
        }
        return [widget];
    }

    function cleanup(widget) {
        widget.classList.remove('blv26-motion-enabled', 'blv26-motion-in');
        widget.classList.add('blv26-motion-done');
        getTargets(widget).forEach(function (target) {
            if (target && target.style) {
                target.style.removeProperty('--blv26-motion-delay');
            }
        });
    }

    function play(widget) {
        if (!widget || widget.__blvVisualPlayed) {
            return;
        }

        widget.__blvVisualPlayed = true;

        if (reduceMotion) {
            cleanup(widget);
            return;
        }

        requestAnimationFrame(function () {
            widget.classList.add('blv26-motion-in');
            window.setTimeout(function () {
                cleanup(widget);
            }, 1250);
        });
    }

    function prepare(widget) {
        if (!widget || widget.__blvVisualInit || widget.classList.contains('blv26-motion-done')) {
            return;
        }

        widget.__blvVisualInit = true;

        var targets = getTargets(widget);
        if (!targets || !targets.length) {
            return;
        }

        targets.forEach(function (target, index) {
            if (target && target.style) {
                target.style.setProperty('--blv26-motion-delay', (index * 70) + 'ms');
            }
        });

        if (reduceMotion) {
            cleanup(widget);
            return;
        }

        widget.classList.add('blv26-motion-enabled');

        if (!('IntersectionObserver' in window)) {
            window.setTimeout(function () { play(widget); }, 80);
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    observer.unobserve(widget);
                    play(widget);
                }
            });
        }, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });

        observer.observe(widget);
        window.setTimeout(function () { play(widget); }, 1800);
    }

    function initAll(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        if (root.matches && root.matches(widgetSelector)) {
            prepare(root);
        }
        root.querySelectorAll(widgetSelector).forEach(prepare);
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
                [
                    'frontend/element_ready/blv_experiencias_cards.default',
                    'frontend/element_ready/blv_sorteos_promos.default',
                    'frontend/element_ready/blv_arrow_link.default',
                    'frontend/element_ready/blv_partidas_especiales.default'
                ].forEach(function (hook) {
                    elementorFrontend.hooks.addAction(hook, function ($scope) {
                        initAll($scope && $scope[0] ? $scope[0] : document);
                    });
                });
            }
        });
    }
})();
