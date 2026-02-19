/**
 * Portfolio – Saiwak Ram
 * script.js | ES6 | Scroll Animations | Typing | Counter | Skill Bars | Validation
 */

'use strict';

/* ============================================================
   LOADER
   ============================================================ */
window.addEventListener('load', () => {
    const loader = document.getElementById('page-loader');
    if (loader) {
        setTimeout(() => loader.classList.add('hidden'), 400);
    }
    initAll();
});

function initAll() {
    initThemeToggle();
    initNavbar();
    initTypingEffect();
    initScrollReveal();
    initSkillBars();
    initCounters();
    initBackToTop();
    initContactForm();
    initParticles();
    initProjectModal();
    initMobileNav();
}

/* ============================================================
   THEME TOGGLE (Dark / Light)
   ============================================================ */
function initThemeToggle() {
    const btn = document.getElementById('theme-toggle');
    const icon = document.getElementById('theme-icon');
    if (!btn) return;

    const saved = localStorage.getItem('portfolio-theme') || 'dark';
    if (saved === 'light') {
        document.body.classList.add('light-mode');
        if (icon) icon.className = 'bi bi-moon-fill';
    }

    btn.addEventListener('click', () => {
        document.body.classList.toggle('light-mode');
        const isLight = document.body.classList.contains('light-mode');
        if (icon) icon.className = isLight ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        localStorage.setItem('portfolio-theme', isLight ? 'light' : 'dark');
    });
}

/* ============================================================
   NAVBAR – Sticky + Active Link
   ============================================================ */
function initNavbar() {
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    const sections = [];

    navLinks.forEach(link => {
        const id = link.getAttribute('href');
        const section = document.querySelector(id);
        if (section) sections.push({ link, section });
    });

    function onScroll() {
        // Sticky background
        if (navbar) {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        }
        // Active link
        const scrollY = window.scrollY + 100;
        sections.forEach(({ link, section }) => {
            const top = section.offsetTop;
            const bottom = top + section.offsetHeight;
            link.classList.toggle('active', scrollY >= top && scrollY < bottom);
        });
        // Back to top
        const btt = document.getElementById('back-to-top');
        if (btt) btt.classList.toggle('visible', window.scrollY > 400);
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ============================================================
   MOBILE NAV – auto-close on link click
   ============================================================ */
function initMobileNav() {
    const toggler = document.querySelector('.navbar-toggler');
    const collapse = document.getElementById('navbarNav');
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (collapse && collapse.classList.contains('show') && window.innerWidth < 992) {
                toggler && toggler.click();
            }
        });
    });
}

/* ============================================================
   TYPING EFFECT
   ============================================================ */
function initTypingEffect() {
    const el = document.getElementById('typed-text');
    if (!el) return;

    const strings = [
        'Full Stack Developer 🚀',
        'Frontend Expert – HTML, CSS, JS',
        'Backend Developer – PHP & SQL',
        'Bootstrap UI Specialist',
        'Database Engineer',
        'Open to Work & Freelance Projects'
    ];

    let strIdx = 0, charIdx = 0, deleting = false;

    function type() {
        const current = strings[strIdx];
        if (deleting) {
            el.textContent = current.substring(0, charIdx - 1);
            charIdx--;
        } else {
            el.textContent = current.substring(0, charIdx + 1);
            charIdx++;
        }

        let delay = deleting ? 50 : 110;

        if (!deleting && charIdx === current.length) {
            delay = 1800;
            deleting = true;
        } else if (deleting && charIdx === 0) {
            deleting = false;
            strIdx = (strIdx + 1) % strings.length;
            delay = 400;
        }
        setTimeout(type, delay);
    }
    setTimeout(type, 600);
}

/* ============================================================
   SCROLL REVEAL
   ============================================================ */
function initScrollReveal() {
    const targets = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    if (!targets.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

    targets.forEach(t => observer.observe(t));
}

/* ============================================================
   SKILL BARS
   ============================================================ */
function initSkillBars() {
    const bars = document.querySelectorAll('.skill-fill');
    if (!bars.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const fill = entry.target;
                const pct = fill.dataset.pct || '0';
                setTimeout(() => { fill.style.width = pct + '%'; }, 200);
                observer.unobserve(fill);
            }
        });
    }, { threshold: 0.3 });

    bars.forEach(b => observer.observe(b));
}

/* ============================================================
   COUNTER ANIMATION
   ============================================================ */
function initCounters() {
    const counters = document.querySelectorAll('.counter-num');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => observer.observe(c));
}

function animateCounter(el) {
    const target = parseInt(el.dataset.target, 10);
    const duration = 1800;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            el.textContent = target;
            clearInterval(timer);
        } else {
            el.textContent = Math.floor(current);
        }
    }, 16);
}

/* ============================================================
   BACK TO TOP
   ============================================================ */
function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

/* ============================================================
   CONTACT FORM (AJAX submit)
   ============================================================ */
function initContactForm() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = form.querySelector('[type="submit"]');
        const msgEl = form.querySelector('.form-msg');

        // Clear previous
        if (msgEl) { msgEl.className = 'form-msg'; msgEl.textContent = ''; }

        // Validate
        const fields = { name: 'Name', email: 'Email', subject: 'Subject', message: 'Message' };
        let valid = true;
        for (const [id, label] of Object.entries(fields)) {
            const el = form.querySelector(`[name="${id}"]`);
            if (!el || !el.value.trim()) {
                showFormMsg(msgEl, `${label} is required.`, 'error');
                el && el.focus();
                valid = false;
                break;
            }
            if (id === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim())) {
                showFormMsg(msgEl, 'Please enter a valid email address.', 'error');
                el.focus();
                valid = false;
                break;
            }
        }
        if (!valid) return;

        // Submit via fetch
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending…';

        try {
            const data = new FormData(form);
            data.append('ajax', '1');
            const res = await fetch('contact.php', { method: 'POST', body: data });
            const json = await res.json();
            if (json.success) {
                showFormMsg(msgEl, '✅ Message sent! I\'ll reply soon.', 'success');
                form.reset();
                showToast('Message sent successfully!');
            } else {
                showFormMsg(msgEl, json.message || '❌ Something went wrong. Please try again.', 'error');
            }
        } catch (err) {
            showFormMsg(msgEl, '❌ Network error. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send me-2"></i>Send Message';
        }
    });
}

function showFormMsg(el, text, type) {
    if (!el) return;
    el.className = `form-msg ${type}`;
    el.textContent = text;
}

/* ============================================================
   TOAST NOTIFICATION
   ============================================================ */
function showToast(message, duration = 3500) {
    let toast = document.getElementById('toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), duration);
}

/* ============================================================
   HERO PARTICLES
   ============================================================ */
function initParticles() {
    const container = document.querySelector('.hero-particles');
    if (!container) return;

    const count = 25;
    for (let i = 0; i < count; i++) {
        const span = document.createElement('span');
        span.style.left = Math.random() * 100 + '%';
        span.style.top  = Math.random() * 100 + '%';
        span.style.animationDelay = (Math.random() * 8) + 's';
        span.style.width  = (Math.random() * 6 + 2) + 'px';
        span.style.height = span.style.width;
        container.appendChild(span);
    }
}

/* ============================================================
   PROJECT MODAL (Quick Preview)
   ============================================================ */
function initProjectModal() {
    document.querySelectorAll('.project-preview-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const card = btn.closest('.project-card');
            const title = card.querySelector('.project-title')?.textContent || '';
            const desc  = card.querySelector('.project-desc')?.textContent  || '';
            const tags  = [...card.querySelectorAll('.project-tag')].map(t => t.textContent).join(', ');
            const githubEl = card.querySelector('.project-github-link');
            const github = githubEl ? githubEl.href : '#';

            const modal = document.getElementById('projectModal');
            if (!modal) return;
            modal.querySelector('#modal-title').textContent = title;
            modal.querySelector('#modal-desc').textContent  = desc;
            modal.querySelector('#modal-tags').textContent  = tags;
            const ghLink = modal.querySelector('#modal-github');
            if (ghLink) ghLink.href = github;

            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    });
}

/* ============================================================
   SMOOTH PAGE TRANSITIONS (for multi-page links)
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[data-transition]').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const href = link.href;
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity .3s ease';
            setTimeout(() => { window.location.href = href; }, 310);
        });
    });
    // Fade in
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity .4s ease';
    setTimeout(() => { document.body.style.opacity = '1'; }, 50);
});

/* ============================================================
   FORM FIELD ANIMATION (floating label effect on admin forms)
   ============================================================ */
document.querySelectorAll('.form-control-custom').forEach(input => {
    input.addEventListener('focus', () => input.classList.add('focused'));
    input.addEventListener('blur',  () => {
        if (!input.value) input.classList.remove('focused');
    });
});

/* ============================================================
   DELETE CONFIRMATION (Admin)
   ============================================================ */
function confirmDelete(form, itemName) {
    if (confirm(`Are you sure you want to delete "${itemName}"?\nThis action cannot be undone.`)) {
        form.submit();
    }
}
