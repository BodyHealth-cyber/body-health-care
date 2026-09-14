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
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ===== CONTACT FORM HANDLING =====
const i18n = window.bodyHealthI18n || {};
const contactFormMessages = {
    sending: i18n.contactFormSending || 'Отправка...',
    success: i18n.contactFormSuccess || 'Спасибо! Ваша заявка отправлена. Мы свяжемся с Вами в течение 24 часов.',
    invalidFirstName: i18n.contactFormInvalidFirstName || 'Пожалуйста, введите корректное имя',
    invalidLastName: i18n.contactFormInvalidLastName || 'Пожалуйста, введите корректную фамилию',
    invalidEmail: i18n.contactFormInvalidEmail || 'Пожалуйста, введите корректный email',
    missingService: i18n.contactFormMissingService || 'Пожалуйста, выберите услугу',
    missingPrivacy: i18n.contactFormMissingPrivacy || 'Необходимо согласие с политикой конфиденциальности',
    invalidPhone: i18n.contactFormInvalidPhone || 'Пожалуйста, введите корректный номер телефона',
};

const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
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
        
        // Simulate form submission (replace with actual API call)
        setTimeout(() => {
            showNotification(contactFormMessages.success, 'success');
            contactForm.reset();
            
            // Restore button state
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }, 1500);
    });
}

// ===== FORM VALIDATION =====
function validateForm(data) {
    const errors = [];
    
    // Required fields
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
    
    // Phone validation (if provided)
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
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-message">${message}</div>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add styles
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
    
    // Add animation styles to head if not exists
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
            .notification-close:hover {
                opacity: 1;
            }
        `;
        document.head.appendChild(styles);
    }
    
    // Add to page
    document.body.appendChild(notification);
    
    // Close functionality
    const closeButton = notification.querySelector('.notification-close');
    closeButton.addEventListener('click', () => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto-close after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// ===== SCROLL TO TOP BUTTON =====
function createScrollToTopButton() {
    const button = document.createElement('button');
    button.innerHTML = '↑';
    button.className = 'scroll-to-top';

    function applyButtonLayout() {
        const isMobileViewport = window.matchMedia('(max-width: 768px)').matches;
        const buttonSize = isMobileViewport ? 44 : 50;
        const horizontalOffset = isMobileViewport ? 16 : 24;
        const bottomOffset = isMobileViewport ? 16 : 24;
        const fontSize = isMobileViewport ? 16 : 18;

        button.style.cssText = `
            position: fixed;
            bottom: ${bottomOffset}px;
            bottom: max(${bottomOffset}px, env(safe-area-inset-bottom));
            right: ${horizontalOffset}px;
            right: max(${horizontalOffset}px, env(safe-area-inset-right));
            left: auto;
            width: ${buttonSize}px;
            height: ${buttonSize}px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            z-index: 1000;
            font-size: ${fontSize}px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        `;
    }

    applyButtonLayout();
    
    button.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    button.addEventListener('mouseenter', () => {
        button.style.backgroundColor = '#004499';
        button.style.transform = 'scale(1.1)';
    });
    
    button.addEventListener('mouseleave', () => {
        button.style.backgroundColor = '#0066cc';
        button.style.transform = 'scale(1)';
    });
    
    document.body.appendChild(button);
    
    // Show/hide based on scroll position
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            button.style.display = 'block';
        } else {
            button.style.display = 'none';
        }
    });

    window.addEventListener('resize', applyButtonLayout);
}

// Initialize scroll to top button
createScrollToTopButton();

// ===== FORM INPUT ENHANCEMENTS =====
document.addEventListener('DOMContentLoaded', function() {
    // Add floating labels effect
    const formGroups = document.querySelectorAll('.form-group');
    
    formGroups.forEach(group => {
        const input = group.querySelector('input, textarea, select');
        if (input && input.type !== 'checkbox') {
            
            // Add focus/blur handlers for better UX
            input.addEventListener('focus', function() {
                group.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                group.classList.remove('focused');
                if (this.value.trim() !== '') {
                    group.classList.add('filled');
                } else {
                    group.classList.remove('filled');
                }
            });
            
            // Check initial state
            if (input.value.trim() !== '') {
                group.classList.add('filled');
            }
        }
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length > 0) {
                if (value[0] === '7' || value[0] === '8') {
                    formattedValue = '+7 ';
                    value = value.substring(1);
                } else if (value[0] === '1') {
                    formattedValue = '+1 ';
                    value = value.substring(1);
                } else {
                    formattedValue = '+';
                }
            }
            
            if (value.length >= 3) {
                formattedValue += '(' + value.substring(0, 3) + ') ';
                value = value.substring(3);
            }
            
            if (value.length >= 3) {
                formattedValue += value.substring(0, 3) + '-';
                value = value.substring(3);
            }
            
            if (value.length > 0) {
                formattedValue += value.substring(0, 4);
            }
            
            e.target.value = formattedValue;
        });
    }
});

// ===== INTERSECTION OBSERVER FOR ANIMATIONS =====
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Apply animation to sections
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.services, .how-it-works, .evidence, .partners');
    
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
});

// ===== ANALYTICS TRACKING =====
function trackEvent(eventName, parameters = {}) {
    // Basic analytics tracking - can be extended with Google Analytics, etc.
    console.log('Event tracked:', eventName, parameters);
    
    // Example: Track to dataLayer if Google Analytics is present
    if (typeof gtag === 'function') {
        gtag('event', eventName, parameters);
    }
}

// Track CTA clicks
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-primary') || e.target.classList.contains('btn-outline')) {
        trackEvent('cta_click', {
            button_text: e.target.textContent,
            location: window.location.pathname
        });
    }
});

// Track form submissions
if (contactForm) {
    contactForm.addEventListener('submit', function() {
        trackEvent('form_submit', {
            form_type: 'contact_form',
            location: window.location.pathname
        });
    });
}
