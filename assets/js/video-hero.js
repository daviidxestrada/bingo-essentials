/* Bingo Essentials - widget "Hero vídeo": secuencia de entrada */
(function () {
    'use strict';

    var SVG_NS = 'http://www.w3.org/2000/svg';
    var STEP = 110;   // ms entre letras del rótulo
    var DRAW = 650;   // ms que tarda en escribirse cada letra
    var START = 250;  // ms de respiro al cargar

    // Rótulo manuscrito: una <text> por letra, en la posición exacta que le
    // da el navegador al texto completo (respeta el espaciado de la fuente).
    function buildScript(root) {
        var svg = root.querySelector('[data-blv-vh-svg]');
        if (!svg || svg.__blvBuilt) {
            return svg ? svg.__blvCount : 0;
        }
        var measure = svg.querySelector('.blv-vh__measure');
        measure.setAttribute('font-size', '100');
        svg.style.height = '200px';
        var box = measure.getBBox();
        if (!box.width) {
            return 0;
        }
        var pad = 6;
        svg.setAttribute('viewBox', [box.x - pad, box.y - pad, box.width + pad * 2, box.height + pad * 2].join(' '));
        svg.style.height = '';

        var group = document.createElementNS(SVG_NS, 'g');
        group.setAttribute('class', 'blv-vh__glyphs');
        var text = measure.textContent;
        var count = 0;
        for (var i = 0; i < text.length; i++) {
            var ch = text.charAt(i);
            if (/\s/.test(ch)) {
                continue;
            }
            var pos = measure.getStartPositionOfChar(i);
            var glyph = document.createElementNS(SVG_NS, 'text');
            glyph.setAttribute('x', pos.x);
            glyph.setAttribute('y', pos.y);
            glyph.setAttribute('font-size', '100');
            glyph.setAttribute('class', 'blv-vh__glyph');
            glyph.style.setProperty('--i', count);
            glyph.textContent = ch;
            group.appendChild(glyph);
            count++;
        }
        measure.style.display = 'none';
        svg.appendChild(group);
        svg.__blvBuilt = true;
        svg.__blvCount = count;
        root.classList.add('is-svg');
        return count;
    }

    // Titular: letra a letra si es corto, palabra a palabra si es una frase.
    function splitTitle(root) {
        var title = root.querySelector('[data-blv-vh-title]');
        if (!title || title.__blvSplit) {
            return title ? title.__blvUnits : 0;
        }
        var words = title.textContent.trim().split(/\s+/);
        var byChar = title.textContent.trim().length <= 24;
        var unit = 0;
        title.setAttribute('aria-label', title.textContent.trim());
        title.textContent = '';
        words.forEach(function (word, w) {
            var wordEl = document.createElement('span');
            wordEl.className = 'blv-vh__word';
            wordEl.setAttribute('aria-hidden', 'true');
            if (byChar) {
                Array.prototype.forEach.call(word, function (ch) {
                    var c = document.createElement('span');
                    c.className = 'blv-vh__char';
                    c.style.setProperty('--c', unit++);
                    c.textContent = ch;
                    wordEl.appendChild(c);
                });
            } else {
                wordEl.classList.add('blv-vh__char');
                wordEl.style.setProperty('--c', unit * 2);
                unit++;
                wordEl.textContent = word;
            }
            title.appendChild(wordEl);
            if (w < words.length - 1) {
                title.appendChild(document.createTextNode(' '));
            }
        });
        title.__blvSplit = true;
        title.__blvUnits = byChar ? unit : unit * 2;
        return title.__blvUnits;
    }

    function play(root) {
        if (root.__blvPlayed) {
            return;
        }
        root.__blvPlayed = true;

        var glyphs = buildScript(root);
        var units = splitTitle(root);

        var drawEnd = glyphs ? START + (glyphs - 1) * STEP + DRAW : 0;
        var ignite = Math.max(START, drawEnd - 120);
        var title = glyphs ? drawEnd + 120 : START;
        var titleSpan = 760 + units * 34;
        var lead = title + Math.min(titleSpan, 900) * 0.6;

        var vars = {
            '--t-start': START + 'ms',
            '--t-step': STEP + 'ms',
            '--t-draw': DRAW + 'ms',
            '--t-ignite': ignite + 'ms',
            '--t-title': title + 'ms',
            '--t-lead': lead + 'ms',
            '--t-rule': (title + Math.min(titleSpan, 900) * 0.55) + 'ms',
            '--t-button': (lead + 260) + 'ms'
        };
        Object.keys(vars).forEach(function (k) { root.style.setProperty(k, vars[k]); });

        requestAnimationFrame(function () {
            root.classList.add('is-play');
        });
    }

    function init(root) {
        if (!root || root.__blvInit) {
            return;
        }
        root.__blvInit = true;

        var iframe = root.querySelector('.blv-vh__video--vimeo');
        if (iframe) {
            iframe.addEventListener('load', function () {
                window.setTimeout(function () { root.classList.add('is-video-ready'); }, 600);
            });
        }

        if (!root.classList.contains('is-pre')) {
            return;
        }

        // Espera a la fuente del rótulo (como mucho 1,5 s) para medir bien.
        var started = false;
        var go = function () {
            if (!started) {
                started = true;
                play(root);
            }
        };
        if (document.fonts && document.fonts.load) {
            Promise.all([
                document.fonts.load('100px "Yellowtail"'),
                document.fonts.load('700 100px "Libre Bodoni"')
            ]).then(go, go);
            window.setTimeout(go, 1500);
        } else {
            go();
        }
    }

    function boot(scope) {
        (scope || document).querySelectorAll('[data-blv-vh]').forEach(init);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { boot(); });
    } else {
        boot();
    }

    window.addEventListener('elementor/frontend/init', function () {
        if (window.elementorFrontend && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/blv_video_hero.default', function ($scope) {
                var root = $scope[0].querySelector('[data-blv-vh]');
                if (root && !root.classList.contains('is-calm') && !root.classList.contains('is-pre')) {
                    root.classList.add('is-pre');
                }
                boot($scope[0]);
            });
        }
    });
})();
