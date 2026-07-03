/* Bingo Essentials - visor PDF para Carta */
(function () {
    'use strict';

    function isRealPdfUrl(url) {
        return url && url.indexOf('PEGA_AQUI') === -1;
    }

    function setupPdfJs() {
        if (!window.pdfjsLib) {
            return null;
        }

        if (window.BLV_BE_PDF && window.BLV_BE_PDF.workerUrl) {
            window.pdfjsLib.GlobalWorkerOptions.workerSrc = window.BLV_BE_PDF.workerUrl;
        }

        return window.pdfjsLib;
    }

    function openZoom(widget, canvas, altText) {
        var zoom = widget.__blvPdfZoom || widget.querySelector('[data-pdf-zoom]');
        var image = widget.__blvPdfZoomImage || (zoom ? zoom.querySelector('[data-pdf-zoom-img]') : null);

        if (!zoom || !image) {
            return;
        }

        image.src = canvas.toDataURL('image/png');
        image.alt = altText;
        zoom.classList.add('is-open');
        zoom.setAttribute('aria-hidden', 'false');

        if (!window.matchMedia('(max-width: 767px)').matches) {
            document.documentElement.style.overflow = 'hidden';
        }
    }

    function closeZoom(widget) {
        var zoom = widget.__blvPdfZoom || widget.querySelector('[data-pdf-zoom]');
        var image = widget.__blvPdfZoomImage || (zoom ? zoom.querySelector('[data-pdf-zoom-img]') : null);

        if (!zoom || !image) {
            return;
        }

        zoom.classList.remove('is-open');
        zoom.setAttribute('aria-hidden', 'true');
        image.removeAttribute('src');
        document.documentElement.style.overflow = '';
    }

    function showPanelError(panel) {
        if (!panel) {
            return;
        }

        panel.classList.remove('is-loading');
        panel.classList.add('has-error');
    }

    function renderPdfPages(widget, pdfjsLib, kind, url) {
        var panel = widget.querySelector('[data-pdf-panel="' + kind + '"]');
        var pagesEl = widget.querySelector('[data-pdf-pages="' + kind + '"]');

        if (!panel || !pagesEl || panel.getAttribute('data-rendered') === 'true') {
            return Promise.resolve();
        }

        if (!isRealPdfUrl(url)) {
            showPanelError(panel);
            return Promise.resolve();
        }

        return pdfjsLib.getDocument({ url: url }).promise.then(function (pdf) {
            var skipFirstPage = pagesEl.getAttribute('data-skip-first-page') === 'true';
            var firstPage = skipFirstPage ? 2 : 1;
            var renderQueue = Promise.resolve();

            pagesEl.innerHTML = '';

            if (firstPage > pdf.numPages) {
                showPanelError(panel);
                return;
            }

            for (var pageNumber = firstPage; pageNumber <= pdf.numPages; pageNumber += 1) {
                (function (currentPage) {
                    renderQueue = renderQueue.then(function () {
                        return pdf.getPage(currentPage).then(function (page) {
                            var viewport = page.getViewport({ scale: 2 });
                            var canvas = document.createElement('canvas');
                            var context = canvas.getContext('2d');
                            var button = document.createElement('button');
                            var visiblePageNumber = skipFirstPage ? currentPage - 1 : currentPage;
                            var panelTitle = panel.querySelector('h3') ? panel.querySelector('h3').textContent : kind;

                            canvas.width = viewport.width;
                            canvas.height = viewport.height;
                            canvas.setAttribute('aria-hidden', 'true');

                            button.type = 'button';
                            button.className = 'blv26pdf-page';
                            button.setAttribute('aria-label', 'Ampliar ' + panelTitle + ', página ' + visiblePageNumber);
                            button.appendChild(canvas);
                            pagesEl.appendChild(button);

                            return page.render({
                                canvasContext: context,
                                viewport: viewport
                            }).promise.then(function () {
                                button.addEventListener('click', function () {
                                    openZoom(widget, canvas, panelTitle + ', página ' + visiblePageNumber);
                                });
                            });
                        });
                    });
                })(pageNumber);
            }

            return renderQueue.then(function () {
                panel.classList.remove('is-loading');
                panel.setAttribute('data-rendered', 'true');
            });
        }).catch(function () {
            showPanelError(panel);
        });
    }

    function activatePanel(widget, tabs, panels, kind) {
        tabs.forEach(function (tab) {
            var isActive = tab.getAttribute('data-pdf-kind') === kind;
            tab.classList.toggle('is-active', isActive);
            tab.setAttribute('aria-current', isActive ? 'true' : 'false');
        });

        panels.forEach(function (panel) {
            var isActive = panel.getAttribute('data-pdf-panel') === kind;
            panel.classList.toggle('is-active', isActive);
            panel.hidden = !isActive;
        });
    }

    function setupReveal(widget) {
        var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReduced) {
            return;
        }

        widget.classList.add('blv26pdf-anim');

        if (!('IntersectionObserver' in window)) {
            widget.classList.add('blv26pdf-inview');
            return;
        }

        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    widget.classList.add('blv26pdf-inview');
                    revealObserver.disconnect();
                }
            });
        }, { rootMargin: '0px 0px -10% 0px', threshold: 0 });

        revealObserver.observe(widget);
        window.setTimeout(function () {
            widget.classList.add('blv26pdf-inview');
        }, 1800);
    }

    function initWidget(widget) {
        if (!widget || widget.getAttribute('data-blv26pdf-ready') === 'true') {
            return;
        }

        var pdfjsLib = setupPdfJs();
        var pdfUrls = {
            carta: widget.getAttribute('data-pdf-carta-url') || '',
            bebidas: widget.getAttribute('data-pdf-bebidas-url') || '',
            alergenos: widget.getAttribute('data-pdf-alergenos-url') || ''
        };
        var tabs = Array.prototype.slice.call(widget.querySelectorAll('[data-blv26pdf-tab]'));
        var panels = Array.prototype.slice.call(widget.querySelectorAll('[data-pdf-panel]'));
        var closeButton = widget.querySelector('[data-pdf-zoom-close]');
        var zoom = widget.querySelector('[data-pdf-zoom]');

        widget.__blvPdfZoom = zoom;
        widget.__blvPdfZoomImage = zoom ? zoom.querySelector('[data-pdf-zoom-img]') : null;

        if (!tabs.length || !panels.length) {
            return;
        }

        widget.setAttribute('data-blv26pdf-ready', 'true');
        setupReveal(widget);

        tabs.forEach(function (tab, tabIndex) {
            tab.addEventListener('click', function () {
                var kind = tab.getAttribute('data-pdf-kind');
                activatePanel(widget, tabs, panels, kind);

                if (pdfjsLib) {
                    renderPdfPages(widget, pdfjsLib, kind, pdfUrls[kind]);
                }
            });

            tab.addEventListener('keydown', function (event) {
                var nextIndex = tabIndex;

                if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                    nextIndex = (tabIndex + 1) % tabs.length;
                } else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
                    nextIndex = (tabIndex - 1 + tabs.length) % tabs.length;
                } else {
                    return;
                }

                event.preventDefault();
                tabs[nextIndex].focus();
            });
        });

        if (closeButton) {
            closeButton.addEventListener('click', function () {
                closeZoom(widget);
            });
        }

        if (zoom) {
            if (zoom.parentNode !== document.body) {
                document.body.appendChild(zoom);
            }
            zoom.addEventListener('click', function (event) {
                if (event.target === zoom) {
                    closeZoom(widget);
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeZoom(widget);
            }
        });

        if (!pdfjsLib) {
            panels.forEach(showPanelError);
            return;
        }

        activatePanel(widget, tabs, panels, 'carta');
        renderPdfPages(widget, pdfjsLib, 'carta', pdfUrls.carta);
    }

    function initAll(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        if (root.matches && root.matches('[data-blv26pdf-widget]')) {
            initWidget(root);
        }
        root.querySelectorAll('[data-blv26pdf-widget]').forEach(initWidget);
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
                elementorFrontend.hooks.addAction('frontend/element_ready/blv_carta.default', function ($scope) {
                    initAll($scope && $scope[0] ? $scope[0] : document);
                });
            }
        });
    }
})();
