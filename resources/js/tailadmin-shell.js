/**
 * TailAdmin-style shell: sidebar collapse (desktop), drawer (mobile).
 */
function initTailadminShell() {
    const body = document.getElementById('ta-body');
    const backdrop = document.getElementById('ta-backdrop');
    const toggleBtns = document.querySelectorAll('[data-ta-toggle-sidebar]');
    const collapseBtns = document.querySelectorAll('[data-ta-collapse-sidebar]');

    if (!body) return;

    const mq = window.matchMedia('(min-width: 1280px)');

    const setMobileOpen = (open) => {
        body.classList.toggle('ta-mobile-sidebar-open', open);
        if (backdrop) {
            backdrop.classList.toggle('hidden', !open);
        }
    };

    const toggleMobile = () => {
        setMobileOpen(!body.classList.contains('ta-mobile-sidebar-open'));
    };

    const toggleCollapsed = () => {
        body.classList.toggle('ta-sidebar-collapsed');
        try {
            localStorage.setItem(
                'ta_sidebar_collapsed',
                body.classList.contains('ta-sidebar-collapsed') ? '1' : '0',
            );
        } catch (_) {
            /* ignore */
        }
    };

    try {
        if (localStorage.getItem('ta_sidebar_collapsed') === '1') {
            body.classList.add('ta-sidebar-collapsed');
        }
    } catch (_) {
        /* ignore */
    }

    toggleBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (mq.matches) {
                toggleCollapsed();
            } else {
                toggleMobile();
            }
        });
    });

    collapseBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (mq.matches) {
                body.classList.add('ta-sidebar-collapsed');
            } else {
                setMobileOpen(false);
            }
        });
    });

    if (backdrop) {
        backdrop.addEventListener('click', () => setMobileOpen(false));
    }

    mq.addEventListener('change', () => {
        setMobileOpen(false);
    });

    document.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            const search = document.querySelector('[data-ta-search]');
            if (search) {
                e.preventDefault();
                search.focus();
            }
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTailadminShell);
} else {
    initTailadminShell();
}
