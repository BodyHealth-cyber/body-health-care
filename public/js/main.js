// ===== LANGUAGE SWITCHER =====
// Each locale is a real page generated at build time (/ , /en/ , /ru/), and
// build-locales.py already writes the correct href and active state into every
// entry of this menu. Nothing here decides what the links point at — the menu
// works with JavaScript disabled, and this only opens and closes it.
(function () {
    function init() {
        var toggle = document.getElementById('langToggle');
        var menu = document.querySelector('.lang-menu');
        if (!toggle || !menu) return;

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            menu.classList.toggle('open');
        });
        document.addEventListener('click', function (e) {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('open');
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') menu.classList.remove('open');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
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
// Every page is served in one language, so the form speaks that language too —
// no runtime lookup and no "Введіть ім'я / Enter first name" double-barrelled
// fallbacks. Keyed off <html lang>, which the build sets per locale.
var FORM_MESSAGES = {
    uk: {
        sending: 'Надсилаємо…',
        success: "Дякуємо! Ваша заявка відправлена. Ми зв'яжемось з Вами протягом 24 годин.",
        error: 'Помилка при відправці. Будь ласка, спробуйте ще раз або напишіть нам напряму.',
        invalidFirstName: "Введіть ім'я",
        invalidLastName: 'Введіть прізвище',
        invalidEmail: 'Email некоректний',
        missingService: 'Оберіть послугу',
        missingPrivacy: 'Потрібна згода з політикою конфіденційності',
        invalidPhone: 'Номер телефону некоректний',
    },
    en: {
        sending: 'Sending…',
        success: "Thank you! Your request has been sent. We'll contact you within 24 hours.",
        error: 'Submission error. Please try again or write to us directly.',
        invalidFirstName: 'Enter your first name',
        invalidLastName: 'Enter your last name',
        invalidEmail: 'Email is not valid',
        missingService: 'Select a service',
        missingPrivacy: 'Consent to the privacy policy is required',
        invalidPhone: 'Phone number is not valid',
    },
    ru: {
        sending: 'Отправляем…',
        success: 'Спасибо! Ваша заявка отправлена. Мы свяжемся с Вами в течение 24 часов.',
        error: 'Ошибка при отправке. Пожалуйста, попробуйте ещё раз или напишите нам напрямую.',
        invalidFirstName: 'Введите имя',
        invalidLastName: 'Введите фамилию',
        invalidEmail: 'Email некорректный',
        missingService: 'Выберите услугу',
        missingPrivacy: 'Требуется согласие с политикой конфиденциальности',
        invalidPhone: 'Номер телефона некорректный',
    },
};

function getContactMessages() {
    var lang = (document.documentElement.lang || 'uk').slice(0, 2);
    return FORM_MESSAGES[lang] || FORM_MESSAGES.uk;
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
