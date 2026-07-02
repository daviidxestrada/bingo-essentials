/* Bingo Essentials - animaciones para Nuestra Historia */
(function () {
    'use strict';

    function revealAll(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        var widgets = [];
        if (root.matches && root.matches('.blv-history-widget[data-blv-history-anim="pending"]')) {
            widgets.push(root);
        }
        root.querySelectorAll('.blv-history-widget[data-blv-history-anim="pending"]').forEach(function (widget) {
            widgets.push(widget);
        });
        for (var i = 0; i < widgets.length; i++) {
            widgets[i].setAttribute('data-blv-history-anim', 'ready');
        }
    }

    function animateWidget(widget) {
        if (widget.__blvHistoryInit) { return; }
        widget.__blvHistoryInit = true;

        var gsap = window.gsap;
        var ScrollTrigger = window.ScrollTrigger;
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (!gsap || !ScrollTrigger || reduce) {
            widget.setAttribute('data-blv-history-anim', 'ready');
            return;
        }

        try {
            gsap.registerPlugin(ScrollTrigger);

            var hero = widget.querySelector('.blv-history-hero');
            var heroBg = widget.querySelector('.blv-history-hero-bg');
            var heroContent = widget.querySelector('.blv-history-hero-content');

            if (heroContent) {
                gsap.from(heroContent, { autoAlpha: 0, y: 32, duration: 0.7, ease: 'power2.out', delay: 0.15 });
            }

            if (hero && heroBg) {
                gsap.to(heroBg, {
                    yPercent: 6,
                    ease: 'none',
                    scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
                });
            }

            widget.querySelectorAll('.blv-history-split-section').forEach(function (section) {
                var isReverse = section.classList.contains('blv-history-reverse');
                var copy = section.querySelector('.blv-history-copy');
                var image = section.querySelector('.blv-history-image-wrap');
                var tl = gsap.timeline({
                    defaults: { ease: 'power2.out' },
                    scrollTrigger: { trigger: section, start: 'top 78%', once: true }
                });
                if (copy) {
                    tl.from(copy, { autoAlpha: 0, x: isReverse ? 50 : -50, duration: 0.65 });
                }
                if (image) {
                    tl.from(image, { autoAlpha: 0, x: isReverse ? -50 : 50, duration: 0.65 }, '-=0.48');
                }
            });

            var productions = widget.querySelector('.blv-history-productions');
            if (productions) {
                var center = productions.querySelector('.blv-history-center');
                var cards = productions.querySelectorAll('.blv-history-card');
                var prodTl = gsap.timeline({
                    defaults: { ease: 'power2.out' },
                    scrollTrigger: { trigger: productions, start: 'top 78%', once: true }
                });
                if (center) {
                    prodTl.from(center, { autoAlpha: 0, y: 24, duration: 0.55 });
                }
                if (cards.length) {
                    prodTl.from(cards, { y: 28, duration: 0.5, stagger: 0.08 }, '-=0.25');
                }
            }

            widget.setAttribute('data-blv-history-anim', 'ready');
        } catch (e) {
            widget.setAttribute('data-blv-history-anim', 'ready');
        }
    }

    function initAll(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        var widgets = [];
        if (root.matches && root.matches('.blv-history-widget')) {
            widgets.push(root);
        }
        root.querySelectorAll('.blv-history-widget').forEach(function (widget) {
            widgets.push(widget);
        });
        for (var i = 0; i < widgets.length; i++) {
            animateWidget(widgets[i]);
        }
    }

    setTimeout(function () { revealAll(document); }, 2000);

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
                    'frontend/element_ready/blv_historia_hero.default',
                    'frontend/element_ready/blv_historia_nacimiento.default',
                    'frontend/element_ready/blv_historia_famosos.default',
                    'frontend/element_ready/blv_historia_producciones.default',
                    'frontend/element_ready/blv_historia_revolucion.default',
                    'frontend/element_ready/blv_historia_cta.default'
                ].forEach(function (hook) {
                    elementorFrontend.hooks.addAction(hook, function ($scope) {
                        var el = $scope && $scope[0] ? $scope[0] : document;
                        setTimeout(function () { initAll(el); }, 50);
                    });
                });
            }
        });
    }
})();
