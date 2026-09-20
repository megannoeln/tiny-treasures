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

function initFeaturedCarousel() {
    document.querySelectorAll('[data-featured-carousel]').forEach((carousel) => {
        const slides = Array.from(carousel.querySelectorAll('[data-featured-carousel-slide]'));
        const previous = carousel.querySelector('[data-featured-carousel-previous]');
        const next = carousel.querySelector('[data-featured-carousel-next]');

        if (slides.length < 2 || !previous || !next) return;

        let activeIndex = 0;

        const showSlide = (index) => {
            activeIndex = (index + slides.length) % slides.length;

            slides.forEach((slide, slideIndex) => {
                const isActive = slideIndex === activeIndex;
                const isPrevious = slideIndex === (activeIndex - 1 + slides.length) % slides.length;
                const isNext = slideIndex === (activeIndex + 1) % slides.length;

                slide.classList.toggle('is-active', isActive);
                slide.classList.toggle('is-previous', isPrevious);
                slide.classList.toggle('is-next', isNext);
                slide.classList.toggle('is-hidden', !isActive && !isPrevious && !isNext);
                slide.classList.toggle('pointer-events-none', !isActive);
                slide.setAttribute('aria-hidden', String(!isActive));
            });
        };

        previous.addEventListener('click', () => showSlide(activeIndex - 1));
        next.addEventListener('click', () => showSlide(activeIndex + 1));
        showSlide(0);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initFlash();
    initFeaturedCarousel();
});
