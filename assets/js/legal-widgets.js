/* Bingo Essentials - acordeones de los widgets legales
   (Canal Etico, Politica de Privacidad, Aviso Legal). */
(function () {
    'use strict';

    var GROUPS = [
        { list: '.blv-canal-accordion', item: '.blv-canal-faq', btn: '.blv-canal-faq-btn' },
        { list: '.blv-priv-accordion', item: '.blv-priv-faq', btn: '.blv-priv-faq-btn' },
        { list: '.blv-aviso-accordion', item: '.blv-aviso-faq', btn: '.blv-aviso-faq-btn' }
    ];

    function bindList(list, group) {
        var items = list.querySelectorAll(group.item);
        items.forEach(function (item) {
            var btn = item.querySelector(group.btn);
            if (!btn || btn.dataset.blvLegalBound) {
                return;
            }
            btn.dataset.blvLegalBound = '1';
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var isOpen = item.classList.contains('active');
                items.forEach(function (i) { i.classList.remove('active'); });
                if (!isOpen) {
                    item.classList.add('active');
                }
            });
        });
    }

    function init(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        GROUPS.forEach(function (group) {
            if (root.matches && root.matches(group.list)) {
                bindList(root, group);
            }
            root.querySelectorAll(group.list).forEach(function (list) {
                bindList(list, group);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { init(document); });
    } else {
        init(document);
    }

    if (window.jQuery) {
        jQuery(window).on('elementor/frontend/init', function () {
            if (window.elementorFrontend && elementorFrontend.hooks) {
                [
                    'frontend/element_ready/blv_canal_etico.default',
                    'frontend/element_ready/blv_politica_privacidad.default',
                    'frontend/element_ready/blv_aviso_legal.default'
                ].forEach(function (hook) {
                    elementorFrontend.hooks.addAction(hook, function ($scope) {
                        init($scope && $scope[0] ? $scope[0] : document);
                    });
                });
            }
        });
    }
})();
