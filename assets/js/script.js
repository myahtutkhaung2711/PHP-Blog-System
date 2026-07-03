document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[href^="#"], a[href*="/#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const hash = link.hash;
            if (!hash) return;
            const target = document.querySelector(hash);
            if (!target) return;
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    const animatedItems = document.querySelectorAll('[data-animate]');
    if (!animatedItems.length) return;

    const reveal = (item) => item.classList.add('is-visible');
    if (!('IntersectionObserver' in window)) {
        animatedItems.forEach(reveal);
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            reveal(entry.target);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.16 });

    animatedItems.forEach((item) => observer.observe(item));
});
