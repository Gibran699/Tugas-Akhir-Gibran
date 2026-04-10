/* ============================================
   Loading Animation Controller
   Capil Theme — Disdukcapil Samarinda
   ============================================ */

/* ---- Raw overlay helpers (work before JS class is ready) ---- */
function _overlayShow(text) {
    var overlay = document.getElementById('loading-overlay');
    if (!overlay) return;
    var textEl = overlay.querySelector('.loading-text');
    if (textEl) textEl.textContent = text || 'Memuat Data...';
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function _overlayHide() {
    var overlay = document.getElementById('loading-overlay');
    if (!overlay) return;
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

/* ---- Class (for public API) ---- */
class LoadingAnimation {
    show(text) { _overlayShow(text); }
    hide()      { _overlayHide(); }
    showWithDelay(text, delay) {
        _overlayShow(text || 'Memuat Data...');
        return new Promise(resolve => {
            setTimeout(() => { _overlayHide(); resolve(); }, delay || 2000);
        });
    }
}

/* ---- Create global instance as soon as script loads ---- */
window.loadingAnimation = new LoadingAnimation();

/* ---- Global helpers ---- */
window.showLoading = function(text) { _overlayShow(text || 'Memuat Data...'); };
window.hideLoading = function()     { _overlayHide(); };
window.showLoadingWithDelay = function(text, delay) {
    return window.loadingAnimation.showWithDelay(text, delay);
};

/* ==============================================================
   TRIGGERS
   ============================================================== */

/* 1. beforeunload — fires on EVERY real navigation (link, form, back/fwd)
      Most reliable trigger; no need to inspect individual links.        */
window.addEventListener('beforeunload', function() {
    _overlayShow('Memuat Halaman...');
});

/* 2. Form submit — show immediately so text can be customised            */
document.addEventListener('submit', function(e) {
    var form = e.target;
    if (!form || form.hasAttribute('data-no-loading')) return;
    _overlayShow(form.getAttribute('data-loading-text') || 'Memproses Data...');
});

/* ==============================================================
   HIDERS
   ============================================================== */

/* 3. window.load — page fully loaded, hide overlay                      */
window.addEventListener('load', function() { _overlayHide(); });

/* 4. pageshow — covers bfcache (back/forward button) restore             */
window.addEventListener('pageshow', function() { _overlayHide(); });

/* ==============================================================
   AJAX (jQuery / DataTables) — debounced to avoid table-redraw flicker
   ============================================================== */
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery === 'undefined') return;
    var _ajaxTimer = null;
    jQuery(document).ajaxStart(function() {
        clearTimeout(_ajaxTimer);
        _ajaxTimer = setTimeout(function() {
            var overlay = document.getElementById('loading-overlay');
            if (overlay && !overlay.classList.contains('active')) {
                _overlayShow('Memuat Data...');
            }
        }, 400);
    });
    jQuery(document).ajaxStop(function() {
        clearTimeout(_ajaxTimer);
        _overlayHide();
    });
});
