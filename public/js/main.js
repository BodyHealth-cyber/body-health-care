// ===== I18N LANGUAGE SWITCHER =====
(function () {
    var DEFAULT_LANG = 'uk';
    var STORAGE_KEY = 'bh_lang';

    function applyTranslations(lang) {
        var t = (window.BH_TRANSLATIONS || {})[lang];
        if (!t) return;

        // Update <html lang>
        document.documentElement.lang = lang;

        // Text content via data-i18n
        document.querySelectorAll('[data-i18n]').forEach(function (el) {
            var key = el.dataset.i18n;
            if (t[key] !== undefined) el.textContent = t[key];
        });

        // innerHTML via data-i18n-html (e.g. labels with <a> inside)
        document.querySelectorAll('[data-i18n-html]').forEach(function (el) {
            var key = el.dataset.i18nHtml;
            if (t[key] !== undefined) el.innerHTML = t[key];
        });

        // Placeholder attributes
        document.querySelectorAll('[data-i18n-placeholder]').forEach(function (el) {
            var key = el.dataset.i18nPlaceholder;
            if (t[key] !== undefined) el.placeholder = t[key];
        });

        // Select <option> elements
        document.querySelectorAll('option[data-i18n]').forEach(function (el) {
            var key = el.dataset.i18n;
            if (t[key] !== undefined) el.textContent = t[key];
        });

        // Update language toggle button label
        var langBtn = document.getElementById('langToggle');
        if (langBtn) langBtn.textContent = lang.toUpperCase();

        // Mark active item in dropdown
        document.querySelectorAll('.lang-menu a[data-lang]').forEach(function (a) {
            a.classList.toggle('lang-active', a.dataset.lang === lang);
        });
    }

    function initLanguageSwitcher() {
        var saved = localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG;
        applyTranslations(saved);

        var langToggle = document.getElementById('langToggle');
        var langMenu = document.querySelector('.lang-menu');

        if (langToggle && langMenu) {
            // Clicking the toggle button opens/closes the dropdown
            langToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                langMenu.classList.toggle('open');
            });
            // Close on outside click
            document.addEventListener('click', function (e) {
                if (!langToggle.contains(e.target) && !langMenu.contains(e.target)) {
                    langMenu.classList.remove('open');
                }
            });
        }

        // Language selection
        document.querySelectorAll('.lang-menu a[data-lang]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var lang = link.dataset.lang;
                localStorage.setItem(STORAGE_KEY, lang);
                applyTranslations(lang);
                if (langMenu) langMenu.classList.remove('open');
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLanguageSwitcher);
    } else {
        initLanguageSwitcher();
    }

    // Global helper — returns translated string for current language
    window.BH_T = function (key) {
        var lang = localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG;
        return ((window.BH_TRANSLATIONS || {})[lang] || {})[key] || key;
    };
})();


// ===== MOBILE NAVIGATION =====
function initMobileNavigation() {
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const mobileLangSwitcher = document.querySelector('.mobile-lang-switcher');
    const mobileLangCurrent = document.querySelector('.mobile-lang-current');

    if (!navToggle || !navMenu || navToggle.dataset.navBound === '1') {
        return;
    }

    const closeMenu = () => {
        navMenu.classList.remove('active');
        navToggle.classList.remove('active');
        navToggle.setAttribute('aria-expanded', 'false');
        if (mobileLangSwitcher) {
            mobileLangSwitcher.classList.remove('open');
        }
        if (mobileLangCurrent) {
            mobileLangCurrent.setAttribute('aria-expanded', 'false');
        }
    };

    const openMenu = () => {
        navMenu.classList.add('active');
        navToggle.classList.add('active');
        navToggle.setAttribute('aria-expanded', 'true');
    };

    navToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (navMenu.classList.contains('active')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    navToggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            navToggle.click();
        }
    });

    const navLinks = navMenu.querySelectorAll('.nav-link, .mobile-lang-link');
    navLinks.forEach((link) => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });

    if (mobileLangSwitcher && mobileLangCurrent) {
        mobileLangCurrent.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = mobileLangSwitcher.classList.toggle('open');
            mobileLangCurrent.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    document.addEventListener('click', (e) => {
        if (mobileLangSwitcher && !mobileLangSwitcher.contains(e.target)) {
            mobileLangSwitcher.classList.remove('open');
            if (mobileLangCurrent) {
                mobileLangCurrent.setAttribute('aria-expanded', 'false');
            }
        }
        if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
            closeMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.matchMedia('(min-width: 769px)').matches) {
            closeMenu();
        }
    });

    navToggle.dataset.navBound = '1';
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMobileNavigation);
} else {
    initMobileNavigation();
}

// ===== SMOOTH SCROLLING =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (!href || href === '#') return;
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ===== CONTACT FORM HANDLING =====
// Messages resolved at call time via i18n system
function getContactMessages() {
    var t = window.BH_T || function(k) { return k; };
    return {
        sending: t('btn_submit') + '…',
        success: t('form_success'),
        error: t('form_error'),
        invalidFirstName: t('ph_fname') ? "Введіть ім'я / Enter first name" : "Введіть ім'я",
        invalidLastName: t('ph_lname') ? "Введіть прізвище / Enter last name" : "Введіть прізвище",
        invalidEmail: 'Email не валідний / Invalid email',
        missingService: 'Оберіть послугу / Select a service',
        missingPrivacy: 'Потрібна згода / Consent required',
        invalidPhone: 'Номер телефону некоректний / Invalid phone',
    };
}
var contactFormMessages = getContactMessages();

const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        contactFormMessages = getContactMessages(); // refresh for current language

        // Get form data
        const formData = new FormData(this);
        const formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        // Basic validation
        if (!validateForm(formObject)) {
            return;
        }

        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = contactFormMessages.sending;
        submitButton.disabled = true;

        // Make.com webhook URL — replace MAKE_WEBHOOK_URL with your actual webhook from Make.com
        const MAKE_WEBHOOK_URL = contactForm.dataset.makeWebhook || 'MAKE_WEBHOOK_URL';

        try {
            const payload = {
                form_type: formObject.form_type || 'client',
                subject: 'BodyHealth — ' + (formObject.service || 'Заявка'),
                first_name: formObject.firstName,
                last_name: formObject.lastName,
                email: formObject.email,
                phone: formObject.phone || '—',
                service: formObject.service,
                message: formObject.message || '—',
                timestamp: new Date().toISOString(),
                source_page: window.location.href
            };

            const response = await fetch(MAKE_WEBHOOK_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            // Make.com webhooks return 200 with "Accepted" on success
            if (response.ok) {
                showNotification(contactFormMessages.success, 'success');
                contactForm.reset();
                trackEvent('form_submit_success', { service: formObject.service });
            } else {
                throw new Error('Webhook error ' + response.status);
            }
        } catch (err) {
            console.error('Form submission error:', err);
            showNotification(contactFormMessages.error, 'error');
            trackEvent('form_submit_error', { error: err.message });
        } finally {
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });
}

// ===== FORM VALIDATION =====
function validateForm(data) {
    const errors = [];

    if (!data.firstName || data.firstName.trim().length < 2) {
        errors.push(contactFormMessages.invalidFirstName);
    }

    if (!data.lastName || data.lastName.trim().length < 2) {
        errors.push(contactFormMessages.invalidLastName);
    }

    if (!data.email || !isValidEmail(data.email)) {
        errors.push(contactFormMessages.invalidEmail);
    }

    if (!data.service) {
        errors.push(contactFormMessages.missingService);
    }

    if (!data.privacy) {
        errors.push(contactFormMessages.missingPrivacy);
    }

    if (data.phone && !isValidPhone(data.phone)) {
        errors.push(contactFormMessages.invalidPhone);
    }

    if (errors.length > 0) {
        showNotification(errors.join('<br>'), 'error');
        return false;
    }

    return true;
}

// ===== UTILITY FUNCTIONS =====
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

// ===== NOTIFICATION SYSTEM =====
function showNotification(message, type = 'info') {
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-message">${message}</div>
            <button class="notification-close" aria-label="Закрыть">&times;</button>
        </div>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#d4edda' : type === 'error' ? '#f8d7da' : '#d1ecf1'};
        color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : '#0c5460'};
        border: 1px solid ${type === 'success' ? '#c3e6cb' : type === 'error' ? '#f5c6cb' : '#bee5eb'};
        border-radius: 8px;
        padding: 1rem;
        max-width: 400px;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        animation: slideInRight 0.3s ease;
    `;

    if (!document.querySelector('#notification-styles')) {
        const styles = document.createElement('style');
        styles.id = 'notification-styles';
        styles.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .notification-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }
            .notification-close {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0;
                color: inherit;
                opacity: 0.7;
            }
            .notification-close:hover { opacity: 1; }
        `;
        document.head.appendChild(styles);
    }

    document.body.appendChild(notification);

    const closeButton = notification.querySelector('.notification-close');
    closeButton.addEventListener('click', () => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    });

    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 6000);
}

// ===== SCROLL TO TOP BUTTON =====
function createScrollToTopButton() {
    const button = document.createElement('button');
    button.innerHTML = '↑';
    button.className = 'scroll-to-top';
    button.setAttribute('aria-label', 'Наверх');

    function applyButtonLayout() {
        const isMobile = window.matchMedia('(max-width: 768px)').matches;
        const size = isMobile ? 44 : 50;
        const offset = isMobile ? 16 : 24;

        button.style.cssText = `
            position: fixed;
            bottom: max(${offset}px, env(safe-area-inset-bottom));
            right: max(${offset}px, env(safe-area-inset-right));
            width: ${size}px;
            height: ${size}px;
            background-color: #1e4fa8;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            z-index: 1000;
            font-size: ${isMobile ? 16 : 18}px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: background-color 0.2s, transform 0.2s;
        `;
    }

    applyButtonLayout();

    button.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    button.addEventListener('mouseenter', () => {
        button.style.backgroundColor = '#163a80';
        button.style.transform = 'scale(1.1)';
    });
    button.addEventListener('mouseleave', () => {
        button.style.backgroundColor = '#1e4fa8';
        button.style.transform = 'scale(1)';
    });

    document.body.appendChild(button);

    window.addEventListener('scroll', () => {
        button.style.display = window.pageYOffset > 300 ? 'block' : 'none';
    }, { passive: true });

    window.addEventListener('resize', applyButtonLayout);
}

createScrollToTopButton();

// ===== FORM INPUT ENHANCEMENTS =====
document.addEventListener('DOMContentLoaded', function() {
    const formGroups = document.querySelectorAll('.form-group');

    formGroups.forEach(group => {
        const input = group.querySelector('input, textarea, select');
        if (input && input.type !== 'checkbox') {
            input.addEventListener('focus', () => group.classList.add('focused'));
            input.addEventListener('blur', function() {
                group.classList.remove('focused');
                group.classList.toggle('filled', this.value.trim() !== '');
            });
            if (input.value.trim() !== '') group.classList.add('filled');
        }
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formatted = '';

            if (value.length > 0) {
                if (value[0] === '7' || value[0] === '8') {
                    formatted = '+7 '; value = value.substring(1);
                } else if (value[0] === '1') {
                    formatted = '+1 '; value = value.substring(1);
                } else {
                    formatted = '+';
                }
            }
            if (value.length >= 3) { formatted += '(' + value.substring(0, 3) + ') '; value = value.substring(3); }
            if (value.length >= 3) { formatted += value.substring(0, 3) + '-'; value = value.substring(3); }
            if (value.length > 0) { formatted += value.substring(0, 4); }
            e.target.value = formatted;
        });
    }
});

// ===== SCROLL ANIMATIONS =====
// Only animate if user hasn't requested reduced motion
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.addEventListener('DOMContentLoaded', function() {
    if (prefersReducedMotion) return; // Respect accessibility

    const animatedSections = document.querySelectorAll('.services, .how-it-works, .evidence, .partners');

    if (!animatedSections.length) return;

    // Add CSS for animation classes
    const animStyle = document.createElement('style');
    animStyle.textContent = `
        .will-animate {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.55s ease, transform 0.55s ease;
        }
        .will-animate.animated {
            opacity: 1;
            transform: translateY(0);
        }
    `;
    document.head.appendChild(animStyle);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target); // Fire once
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    animatedSections.forEach(section => {
        section.classList.add('will-animate');
        observer.observe(section);
    });
});

// ===== ANALYTICS TRACKING =====
function trackEvent(eventName, parameters = {}) {
    if (typeof gtag === 'function') {
        gtag('event', eventName, parameters);
    }
}

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-primary, .btn-outline');
    if (btn) {
        trackEvent('cta_click', {
            button_text: btn.textContent.trim(),
            location: window.location.pathname
        });
    }
});
