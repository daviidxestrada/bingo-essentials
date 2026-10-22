/* Bingo Essentials - panel "Fotos Home" */
(function ($) {
    'use strict';

    var root = document.querySelector('[data-blv-hm]');
    if (!root || !window.wp || !wp.media) {
        return;
    }

    var form = root.querySelector('[data-blv-hm-form]');
    var list = root.querySelector('[data-blv-hm-promos]');
    var empty = root.querySelector('[data-blv-hm-promos-empty]');
    var bar = root.querySelector('[data-blv-hm-bar]');
    var status = root.querySelector('[data-blv-hm-status]');
    var submit = root.querySelector('[data-blv-hm-submit]');
    var template = root.querySelector('[data-blv-hm-promo-template]');
    var posterId = root.querySelector('[data-blv-hm-poster-id]');
    var posterImg = root.querySelector('[data-blv-hm-poster-img]');
    var posterEmpty = root.querySelector('[data-blv-hm-poster-empty]');
    var posterFrame = root.querySelector('.blv-hm-poster__frame');
    var dirty = false;
    var submitting = false;

    function markDirty() {
        if (dirty) {
            return;
        }
        dirty = true;
        bar.classList.add('is-dirty');
        status.textContent = 'Tienes cambios sin guardar';
    }

    function imageUrl(attachment) {
        var sizes = attachment.sizes || {};
        return (sizes.medium_large || sizes.large || sizes.medium || sizes.full || attachment).url;
    }

    function frame(options) {
        return wp.media({
            title: options.title,
            button: { text: options.button },
            library: { type: 'image' },
            multiple: !!options.multiple
        });
    }

    function syncList() {
        var items = list.querySelectorAll('[data-blv-hm-promo]');
        empty.hidden = items.length > 0;
        items.forEach(function (item, index) {
            item.querySelector('[data-blv-hm-move="-1"]').disabled = index === 0;
            item.querySelector('[data-blv-hm-move="1"]').disabled = index === items.length - 1;
        });
    }

    function fillPromo(item, attachment) {
        item.querySelector('input[name="promo_id[]"]').value = attachment.id;
        item.querySelector('img').src = imageUrl(attachment);
        var alt = item.querySelector('input[name="promo_alt[]"]');
        if (!alt.value) {
            alt.value = attachment.alt || attachment.title || '';
        }
    }

    function addPromo(attachment) {
        var item = template.content.firstElementChild.cloneNode(true);
        fillPromo(item, attachment);
        list.appendChild(item);
    }

    // Cartel de Partidas especiales.
    var posterFrameMedia;
    root.querySelectorAll('[data-blv-hm-pick-poster]').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!posterFrameMedia) {
                posterFrameMedia = frame({ title: 'Cartel de Partidas especiales', button: 'Usar este cartel' });
                posterFrameMedia.on('select', function () {
                    var attachment = posterFrameMedia.state().get('selection').first().toJSON();
                    posterId.value = attachment.id;
                    posterImg.src = imageUrl(attachment);
                    posterImg.hidden = false;
                    posterEmpty.hidden = true;
                    posterFrame.classList.remove('is-empty');
                    markDirty();
                });
            }
            posterFrameMedia.open();
        });
    });

    // Añadir promociones (varias a la vez).
    var addFrame;
    root.querySelector('[data-blv-hm-add-promos]').addEventListener('click', function () {
        if (!addFrame) {
            addFrame = frame({ title: 'Añadir promociones', button: 'Añadir a la Home', multiple: 'add' });
            addFrame.on('select', function () {
                addFrame.state().get('selection').each(function (model) {
                    addPromo(model.toJSON());
                });
                addFrame.state().get('selection').reset();
                syncList();
                markDirty();
            });
        }
        addFrame.open();
    });

    // Acciones de cada tarjeta.
    var replaceTarget = null;
    var replaceFrame;
    list.addEventListener('click', function (event) {
        var button = event.target.closest('button');
        if (!button) {
            return;
        }
        var item = button.closest('[data-blv-hm-promo]');

        if (button.hasAttribute('data-blv-hm-remove')) {
            item.remove();
            syncList();
            markDirty();
            return;
        }

        if (button.hasAttribute('data-blv-hm-move')) {
            var dir = parseInt(button.getAttribute('data-blv-hm-move'), 10);
            if (dir < 0 && item.previousElementSibling) {
                list.insertBefore(item, item.previousElementSibling);
            } else if (dir > 0 && item.nextElementSibling) {
                list.insertBefore(item.nextElementSibling, item);
            }
            syncList();
            markDirty();
            button.focus();
            return;
        }

        if (button.hasAttribute('data-blv-hm-replace')) {
            replaceTarget = item;
            if (!replaceFrame) {
                replaceFrame = frame({ title: 'Cambiar imagen de la promoción', button: 'Usar esta imagen' });
                replaceFrame.on('select', function () {
                    if (replaceTarget) {
                        replaceTarget.querySelector('input[name="promo_alt[]"]').value = '';
                        fillPromo(replaceTarget, replaceFrame.state().get('selection').first().toJSON());
                        markDirty();
                    }
                });
            }
            replaceFrame.open();
        }
    });

    $(list).sortable({
        items: '> [data-blv-hm-promo]',
        handle: '.blv-hm-promo__media',
        placeholder: 'blv-hm-promo-placeholder',
        tolerance: 'pointer',
        forcePlaceholderSize: true,
        update: function () {
            syncList();
            markDirty();
        }
    });

    form.addEventListener('input', markDirty);

    form.addEventListener('submit', function () {
        submitting = true;
        submit.disabled = true;
        submit.textContent = 'Guardando…';
    });

    window.addEventListener('beforeunload', function (event) {
        if (dirty && !submitting) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    // Aviso de guardado: se va solo y limpia la URL.
    var toast = root.querySelector('[data-blv-hm-toast]');
    if (toast) {
        if (window.history && window.history.replaceState) {
            var url = new URL(window.location.href);
            url.searchParams.delete('blv-saved');
            window.history.replaceState(null, '', url.toString());
        }
        window.setTimeout(function () {
            toast.classList.add('is-leaving');
            window.setTimeout(function () { toast.remove(); }, 450);
        }, 6000);
    }

    syncList();
})(jQuery);
