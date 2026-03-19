import './bootstrap';

function initMobileNav() {
    const button = document.querySelector('[data-mobile-nav-button]');
    const nav = document.querySelector('[data-mobile-nav]');
    if (!button || !nav) return;

    const close = () => {
        nav.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
    };

    const open = () => {
        nav.classList.remove('hidden');
        button.setAttribute('aria-expanded', 'true');
    };

    button.addEventListener('click', () => {
        const expanded = button.getAttribute('aria-expanded') === 'true';
        expanded ? close() : open();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });

    nav.addEventListener('click', (e) => {
        const target = e.target;
        if (target instanceof HTMLAnchorElement) close();
    });
}

function initFlash() {
    const flash = document.querySelector('[data-flash]');
    if (!flash) return;

    const closeButton = flash.querySelector('[data-flash-close]');
    const hide = () => {
        flash.classList.add('opacity-0');
        flash.classList.add('transition');
        flash.classList.add('duration-300');
        window.setTimeout(() => flash.remove(), 300);
    };

    closeButton?.addEventListener('click', hide);
    window.setTimeout(hide, 4500);
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initFlash();
});
