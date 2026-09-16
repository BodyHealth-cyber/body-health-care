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

// ===== ВЫСОТА ПЕРВОГО ЭКРАНА =====
// Первый блок занимает экран минус шапка минус 96 px (верхний отступ каждого
// раздела) — так снизу всегда виден край следующего раздела и никогда
// обрезанная карточка. Высота шапки зависит от ширины экрана и немного от
// языка, поэтому берём её с живой страницы, а не прописываем в CSS числом.
(function () {
    function syncHeaderHeight() {
        var header = document.querySelector('.header');
        if (!header) return;
        var h = Math.round(header.getBoundingClientRect().height);
        if (h > 0) document.documentElement.style.setProperty('--header-h', h + 'px');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncHeaderHeight);
    } else {
        syncHeaderHeight();
    }
    window.addEventListener('load', syncHeaderHeight);
    window.addEventListener('resize', syncHeaderHeight);
})();

// ===== УДЕРЖАНИЕ МЕСТА ПРИ ОТКРЫТИИ ОКНА =====
// Человек должен остаться ровно там, где нажал кнопку. Браузер иногда сам
// подтягивает страницу под открывшееся окно — из-за фокуса в поле, из-за
// пересчёта высоты, из-за скрытой полосы прокрутки. Замеров «на глаз» тут
// мало: запоминаем место до открытия и возвращаем страницу на него в течение
// первой четверти секунды. scroll-behavior на время возврата выключаем, иначе
// правка была бы видна как плавный отъезд и обратно.
function holdScrollPosition() {
    var keepY = window.scrollY || window.pageYOffset || 0;

    function restore() {
        var now = window.scrollY || window.pageYOffset || 0;
        if (Math.abs(now - keepY) < 2) return;
        var html = document.documentElement;
        var previous = html.style.scrollBehavior;
        html.style.scrollBehavior = 'auto';
        window.scrollTo(0, keepY);
        html.style.scrollBehavior = previous;
    }

    requestAnimationFrame(restore);
    setTimeout(restore, 80);
    setTimeout(restore, 260);
    return keepY;
}

// ===== SMOOTH SCROLLING =====
// Якоря, за которыми стоит анкета, сюда не попадают. Раньше этот обработчик
// висел прямо на ссылке и срабатывал раньше диалога: человек нажимал кнопку в
// первом экране, страница уезжала на несколько тысяч пикселей вниз, и только
// потом поверх открывалась анкета. Закрыв её, он оказывался не там, где нажал.
// Теперь прокрутка остаётся только для настоящей навигации по странице.
var DIALOG_ANCHORS = ['#contact-form', '#b2b-form'];

function anchorOpensDialog(href) {
    for (var i = 0; i < DIALOG_ANCHORS.length; i++) {
        if (href.indexOf(DIALOG_ANCHORS[i]) !== -1) return true;
    }
    return false;
}

// Делегирование, а не подписка на каждую ссылку: main.js на части страниц
// подключён выше разметки, и подписка на момент загрузки находила не все якоря.
document.addEventListener('click', function (e) {
    var anchor = e.target.closest ? e.target.closest('a[href^="#"]') : null;
    if (!anchor) return;
    var href = anchor.getAttribute('href');
    if (!href || href === '#' || anchorOpensDialog(href)) return;
    var target = document.querySelector(href);
    if (!target) return;
    e.preventDefault();
    target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
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
        missingPhone: 'Вкажіть номер телефону — ми зателефонуємо',
        badPhone: 'Перевірте номер: український мобільний має вигляд +380 XX XXX XX XX',
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
        missingPhone: 'Please give us a phone number — we will call you',
        badPhone: 'Check the number: a Ukrainian mobile looks like +380 XX XXX XX XX',
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
        missingPhone: 'Укажите номер телефона — мы позвоним',
        badPhone: 'Проверьте номер: украинский мобильный выглядит как +380 XX XXX XX XX',
    },
};

function getContactMessages() {
    var lang = (document.documentElement.lang || 'uk').slice(0, 2);
    return FORM_MESSAGES[lang] || FORM_MESSAGES.uk;
}

var contactFormMessages = getContactMessages();

// Two forms share this handler: the one at the foot of the home page and the
// one inside the enquiry dialog, which exists on every page. Everything below
// reads `this`, never a captured element, so both behave identically.
// Страховка на уровне документа: ни одна анкета не должна уходить обычной
// GET-отправкой. Именно это и происходило с анкетой во всплывающем окне —
// страница перезагружалась, имя, телефон и почта человека оказывались в
// адресной строке, а заявка не уходила никуда. Перехват в фазе погружения
// срабатывает раньше любого обработчика формы и не мешает ему отработать.
document.addEventListener('submit', function (e) {
    var form = e.target;
    if (form && form.hasAttribute && form.hasAttribute('data-make-webhook')) {
        e.preventDefault();
    }
}, true);

// Разметка анкеты во всплывающем окне стоит в подвале страницы, ниже main.js,
// поэтому на момент загрузки скрипта её ещё нет в документе: getElementById
// возвращал null, и обработчик отправки не вешался ни на одной странице сайта.
// Ждём документ, как это уже сделано для меню, диалогов и подписки.
function initContactForms() {
    var forms = [
        document.getElementById('contactForm'),
        document.getElementById('contactFormModal')
    ].filter(Boolean);
    forms.forEach(bindContactForm);
}

// В письме клиенту стояло «Послуга: personal-care» и «Надіслано:
// 2026-09-16T14:12:10.319Z» — машинный код и время по Гринвичу. Человеку это
// читается как техническая ошибка. Название услуги берём прямо из выбранного
// пункта списка: оно уже на языке страницы, и второго словаря заводить не надо.
function selectedServiceLabel(form) {
    var select = form.querySelector('[name="service"]');
    if (!select || select.selectedIndex < 0) return '';
    var option = select.options[select.selectedIndex];
    if (!option) return '';
    var label = (option.textContent || '').trim();
    // В списке пункт подписан целиком: «Personal Care — постійний куратор і
    // команда спеціалістів». В теме письма и в строке «Послуга» нужно короткое
    // имя пакета, иначе тема не помещается в почтовой программе.
    var dash = label.indexOf(' — ');
    return dash > 0 ? label.slice(0, dash).trim() : label;
}

// Время киевское и в привычном виде. Если браузер старый и часовых поясов не
// знает — отдаём как есть, лучше машинная строка, чем пустое место в письме.
function localTimestamp(date) {
    try {
        return new Intl.DateTimeFormat('uk-UA', {
            timeZone: 'Europe/Kyiv',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(date);
    } catch (e) {
        return date.toISOString();
    }
}

function bindContactForm(form) {
    if (form.dataset.contactBound === '1') return;
    form.dataset.contactBound = '1';
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        contactFormMessages = getContactMessages(); // refresh for current language

        // Get form data
        const formData = new FormData(this);
        const formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        // Basic validation
        if (!validateForm(formObject, this)) {
            return;
        }

        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = contactFormMessages.sending;
        submitButton.disabled = true;

        // Make.com webhook. Until it is configured the attribute still holds the
        // literal placeholder, which would resolve as a relative URL against this
        // page and quietly 404 — so the enquiry is handed to a working channel
        // instead of being lost behind an error box.
        const MAKE_WEBHOOK_URL = this.dataset.makeWebhook || '';
        const webhookReady = /^https?:\/\//.test(MAKE_WEBHOOK_URL);

        const serviceLabel = selectedServiceLabel(form) || formObject.service || '';

        const enquirySummary = [
            (formObject.firstName || '') + ' ' + (formObject.lastName || ''),
            formObject.email,
            formObject.phone,
            serviceLabel,
            formObject.message,
        ].filter(Boolean).join('\n').trim();

        if (!webhookReady) {
            offerDirectContact(enquirySummary);
            trackEvent('form_submit_unconfigured', { service: formObject.service });
            submitButton.textContent = originalText;
            submitButton.disabled = false;
            return;
        }

        try {
            const sentAt = new Date();
            const payload = {
                form_type: formObject.form_type || 'client',
                subject: 'BodyHealth — ' + (serviceLabel || 'Заявка'),
                first_name: formObject.firstName,
                last_name: formObject.lastName,
                email: formObject.email,
                phone: formObject.phone || '—',
                service: formObject.service,
                // то же самое словами, на языке страницы — для письма человеку
                service_label: serviceLabel,
                message: formObject.message || '—',
                timestamp: sentAt.toISOString(),
                // то же время по Києву и в привычном виде — для письма человеку
                submitted_at: localTimestamp(sentAt),
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
                this.reset();
                trackEvent('form_submit_success', { service: formObject.service });
            } else {
                throw new Error('Webhook error ' + response.status);
            }
        } catch (err) {
            console.error('Form submission error:', err);
            // the form is deliberately not reset — what they typed is still there
            offerDirectContact(enquirySummary);
            trackEvent('form_submit_error', { error: err.message });
        } finally {
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initContactForms);
} else {
    initContactForms();
}

// ===== FORM VALIDATION =====
function validateForm(data, form) {
    const errors = [];
    const field = function (name) {
        return form ? form.querySelector('[name="' + name + '"]') : null;
    };
    ['firstName', 'lastName', 'email', 'phone'].forEach(function (n) {
        clearFieldError(field(n));
    });

    if (!data.firstName || data.firstName.trim().length < 2) {
        errors.push(contactFormMessages.invalidFirstName);
        setFieldError(field('firstName'), contactFormMessages.invalidFirstName);
    }

    if (!data.lastName || data.lastName.trim().length < 2) {
        errors.push(contactFormMessages.invalidLastName);
        setFieldError(field('lastName'), contactFormMessages.invalidLastName);
    }

    if (!data.email || !isValidEmail(data.email)) {
        errors.push(contactFormMessages.invalidEmail);
        setFieldError(field('email'), contactFormMessages.invalidEmail);
    }

    if (!data.service) {
        errors.push(contactFormMessages.missingService);
    }

    if (!data.privacy) {
        errors.push(contactFormMessages.missingPrivacy);
    }

    if (!data.phone || !data.phone.trim()) {
        errors.push(contactFormMessages.missingPhone);
        setFieldError(field('phone'), contactFormMessages.missingPhone);
    } else if (!isValidPhone(data.phone)) {
        errors.push(contactFormMessages.badPhone);
        setFieldError(field('phone'), contactFormMessages.badPhone);
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

// Стара перевірка пропускала будь-що: регулярний вираз ^[+]?[1-9]\d{0,15}$
// приймав навіть «5» або «1234». Через неї в заявки потрапляли порожні та
// вигадані номери, і передзвонити не було куди.
//
// Тепер: український номер — це 380 і ще дев'ять цифр, де перші дві є
// справжнім кодом оператора. Іноземний — від 8 до 15 цифр (стандарт E.164).
// Окремо відсіюємо очевидні підробки на кшталт +380 11 111 11 11.
var UA_OPERATOR_CODES = [
    '39', '50', '63', '66', '67', '68', '73', '89',
    '91', '92', '93', '94', '95', '96', '97', '98', '99'
];

function phoneDigits(phone) {
    return String(phone || '').replace(/\D/g, '');
}

// Свідомо тільки одне правило — усі цифри однакові (+380 11 111 11 11).
// Спочатку тут були ще «123456789» і повтор пари, але на них спіткнувся
// справжній польський номер +48 123 456 789. Краще пропустити рідкісну
// підробку, ніж відмовити живому клієнту.
function looksFake(digits) {
    return /^(\d)\1+$/.test(digits.slice(-9));
}

function isValidPhone(phone) {
    var d = phoneDigits(phone);
    if (!d) return false;
    if (d.charAt(0) === '0') d = '38' + d;                    // 098… → 38098…
    if (looksFake(d)) return false;
    if (d.indexOf('380') === 0) {
        return d.length === 12 && UA_OPERATOR_CODES.indexOf(d.substr(3, 2)) !== -1;
    }
    return d.length >= 8 && d.length <= 15;
}

// Підпис помилки під самим полем: повідомлення згори екрана легко пропустити,
// і людина не розуміє, яке саме поле не так заповнене.
function setFieldError(input, message) {
    if (!input) return;
    input.classList.add('is-invalid');
    input.setAttribute('aria-invalid', 'true');
    var holder = input.parentElement;
    var box = holder.querySelector('.field-error');
    if (!box) {
        box = document.createElement('p');
        box.className = 'field-error';
        holder.appendChild(box);
    }
    box.textContent = message;
}

function clearFieldError(input) {
    if (!input) return;
    input.classList.remove('is-invalid');
    input.removeAttribute('aria-invalid');
    var box = input.parentElement.querySelector('.field-error');
    if (box) box.remove();
}

// Поле очищується від помилки, щойно людина почала його виправляти.
document.addEventListener('input', function (e) {
    if (e.target && e.target.classList && e.target.classList.contains('is-invalid')) {
        clearFieldError(e.target);
    }
});

// Телефон перевіряємо ще й при виході з поля — щоб не чекати відправки.
document.addEventListener('blur', function (e) {
    var el = e.target;
    if (!el || el.type !== 'tel' || !el.value.trim()) return;
    var msgs = getContactMessages();
    if (!isValidPhone(el.value)) setFieldError(el, msgs.badPhone);
    else clearFieldError(el);
}, true);

// ===== NOTIFICATION SYSTEM =====
// ===== WHEN A FORM CANNOT BE SUBMITTED =====
// The forms post to a Make.com webhook. If that webhook is not configured, or the
// request fails, the visitor has typed a real enquiry and it must not simply
// disappear behind a red box. This hands them the same message over a channel
// that works right now, with what they wrote already in it.
var CONTACT = {
    phone: '+380981501498',
    phoneLabel: '+380 98 150 14 98',
    telegram: 'https://t.me/bodyhealthclinic',
    whatsapp: '380981501498',
};

var FALLBACK_TEXT = {
    uk: {
        lead: 'Не вдалося надіслати форму. Напишіть нам напряму — ваше повідомлення вже готове:',
        wa: 'Надіслати у WhatsApp',
        tg: 'Написати в Telegram',
        call: 'Зателефонувати',
    },
    en: {
        lead: 'The form could not be sent. Message us directly — your enquiry is ready to go:',
        wa: 'Send on WhatsApp',
        tg: 'Message on Telegram',
        call: 'Call us',
    },
    ru: {
        lead: 'Не удалось отправить форму. Напишите нам напрямую — ваше сообщение уже готово:',
        wa: 'Отправить в WhatsApp',
        tg: 'Написать в Telegram',
        call: 'Позвонить',
    },
};

function offerDirectContact(summary) {
    var lang = (document.documentElement.lang || 'uk').slice(0, 2);
    var t = FALLBACK_TEXT[lang] || FALLBACK_TEXT.uk;
    var wa = 'https://wa.me/' + CONTACT.whatsapp + '?text=' + encodeURIComponent(summary);
    showNotification(
        '<div style="line-height:1.5">' +
        '<div style="margin-bottom:.6rem">' + t.lead + '</div>' +
        '<div style="display:flex;flex-direction:column;gap:.35rem">' +
        '<a href="' + wa + '" target="_blank" rel="noopener" style="color:inherit;font-weight:600">' + t.wa + '</a>' +
        '<a href="' + CONTACT.telegram + '" target="_blank" rel="noopener" style="color:inherit;font-weight:600">' + t.tg + '</a>' +
        '<a href="tel:' + CONTACT.phone + '" style="color:inherit;font-weight:600">' + t.call + ' ' + CONTACT.phoneLabel + '</a>' +
        '</div></div>', 'error');
}

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

    // A notice that hands the visitor a link to follow must not slide away
    // while they are reading it.
    if (!notification.querySelector('a')) {
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }
        }, 6000);
    }
}

// ===== SCROLL TO TOP BUTTON =====
// Placed inside the floating contact stack rather than positioned in the same
// corner independently: as two separately fixed elements they landed on top of
// each other, and the button showed through from behind the WhatsApp circle.
// Sizing, spacing and the mobile breakpoint all live in style.css.
function createScrollToTopButton() {
    var button = document.createElement('button');
    button.type = 'button';
    button.className = 'scroll-to-top';
    button.innerHTML = '\u2191';

    var LABEL = { uk: 'Догори', en: 'Back to top', ru: 'Наверх' };
    var lang = (document.documentElement.lang || 'uk').slice(0, 2);
    button.setAttribute('aria-label', LABEL[lang] || LABEL.uk);
    button.setAttribute('title', LABEL[lang] || LABEL.uk);
    button.hidden = true;

    var stack = document.querySelector('.float-contacts');
    if (stack) {
        stack.appendChild(button);
    } else {
        // no contact stack on this page — stand alone, clear of the corner
        button.style.position = 'fixed';
        button.style.right = '1.5rem';
        button.style.bottom = '2rem';
        button.style.zIndex = '9000';
        document.body.appendChild(button);
    }

    button.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    var shown = false;
    function sync() {
        var should = window.pageYOffset > 300;
        if (should !== shown) {
            shown = should;
            button.hidden = !should;
        }
    }
    sync();
    window.addEventListener('scroll', sync, { passive: true });
}

// На части страниц этот скрипт подключён выше блока .float-contacts, поэтому
// на момент вызова стека ещё нет в DOM и кнопка уходила в запасную ветку —
// системная серая кнопка вставала поверх WhatsApp. Ждём готовности документа.
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', createScrollToTopButton);
} else {
    createScrollToTopButton();
}

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

    // Форматування телефону.
    // Стара маска була розрахована на десятизначний номер (+(XXX) XXX-XXXX) і
    // обрізала все зайве: український +380 98 150 14 98 перетворювався на
    // +(380) 981-5014, тобто дві останні цифри просто зникали і заявка
    // приходила з неправильним номером. Нова маска нічого не відкидає:
    // українські номери групує звично, будь-які інші лишає як +цифри.
    function formatPhoneValue(raw) {
        var d = String(raw || '').replace(/\D/g, '');
        if (!d) return '';
        if (d.charAt(0) === '0') d = '38' + d;          // 098… → 38098…
        if (d.indexOf('380') === 0 && d.length <= 12) {
            var rest = d.slice(3);
            var parts = ['+380'];
            if (rest.length) parts.push(rest.slice(0, 2));
            if (rest.length > 2) parts.push(rest.slice(2, 5));
            if (rest.length > 5) parts.push(rest.slice(5, 7));
            if (rest.length > 7) parts.push(rest.slice(7, 9));
            return parts.join(' ');
        }
        return '+' + d;
    }

    document.querySelectorAll('input[type="tel"]').forEach(function (input) {
        if (input.dataset.phoneBound === '1') return;
        input.dataset.phoneBound = '1';
        input.addEventListener('input', function (e) {
            var atEnd = e.target.selectionStart === e.target.value.length;
            var next = formatPhoneValue(e.target.value);
            if (next === e.target.value) return;
            e.target.value = next;
            if (atEnd) e.target.setSelectionRange(next.length, next.length);
        });
    });
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

// ===== CONTACT SHEET =====
// The footer no longer lists Telegram and WhatsApp as separate rows: the
// "call now" button opens this panel and the visitor picks a channel. Built
// once, on first open, so 18 pages don't each carry a copy of the markup.
(function () {
    var CONTACT_SHEET_TEXT = {
        uk: {
            title: 'Як вам зручніше звʼязатися?',
            sub: 'Оберіть спосіб — ми відповімо в робочі години.',
            close: 'Закрити',
            phone: 'Подзвонити', phoneSub: '+380 98 150 14 98',
            tg: 'Telegram', tgSub: 'Написати в месенджері',
            wa: 'WhatsApp', waSub: 'Написати в месенджері'
        },
        en: {
            title: 'How would you like to reach us?',
            sub: 'Pick a channel — we reply during working hours.',
            close: 'Close',
            phone: 'Call', phoneSub: '+380 98 150 14 98',
            tg: 'Telegram', tgSub: 'Message us',
            wa: 'WhatsApp', waSub: 'Message us'
        },
        ru: {
            title: 'Как вам удобнее связаться?',
            sub: 'Выберите способ — ответим в рабочие часы.',
            close: 'Закрыть',
            phone: 'Позвонить', phoneSub: '+380 98 150 14 98',
            tg: 'Telegram', tgSub: 'Написать в мессенджере',
            wa: 'WhatsApp', waSub: 'Написать в мессенджере'
        }
    };

    var sheetEl = null;
    var lastFocused = null;

    function sheetText() {
        var lang = (document.documentElement.lang || 'uk').slice(0, 2);
        return CONTACT_SHEET_TEXT[lang] || CONTACT_SHEET_TEXT.uk;
    }

    function option(cls, icon, href, label, sub, external) {
        return '<a class="contact-option ' + cls + '" href="' + href + '"' +
            (external ? ' target="_blank" rel="noopener"' : '') + '>' +
            '<span class="co-icon"><i class="' + icon + '"></i></span>' +
            '<span><span class="co-label">' + label + '</span>' +
            '<span class="co-sub">' + sub + '</span></span></a>';
    }

    function buildSheet() {
        var t = sheetText();
        var el = document.createElement('div');
        el.className = 'contact-sheet-backdrop';
        el.hidden = true;
        el.setAttribute('role', 'dialog');
        el.setAttribute('aria-modal', 'true');
        el.setAttribute('aria-label', t.title);
        el.innerHTML =
            '<div class="contact-sheet">' +
                '<div class="contact-sheet-head">' +
                    '<div>' +
                        '<p class="contact-sheet-title">' + t.title + '</p>' +
                        '<p class="contact-sheet-sub">' + t.sub + '</p>' +
                    '</div>' +
                    '<button type="button" class="contact-sheet-close" aria-label="' + t.close + '">&times;</button>' +
                '</div>' +
                '<div class="contact-sheet-options">' +
                    option('co-phone', 'fas fa-phone', 'tel:+380981501498', t.phone, t.phoneSub, false) +
                    option('co-tg', 'fab fa-telegram', 'https://t.me/bodyhealthclinic', t.tg, t.tgSub, true) +
                    option('co-wa', 'fab fa-whatsapp', 'https://wa.me/380981501498', t.wa, t.waSub, true) +
                '</div>' +
            '</div>';

        el.addEventListener('click', function (e) {
            if (e.target === el) closeSheet();
        });
        el.querySelector('.contact-sheet-close').addEventListener('click', closeSheet);
        // picking a channel closes the panel behind the visitor
        Array.prototype.forEach.call(el.querySelectorAll('.contact-option'), function (a) {
            a.addEventListener('click', function () { setTimeout(closeSheet, 120); });
        });
        return el;
    }

    function onKeydown(e) {
        if (e.key === 'Escape' || e.keyCode === 27) closeSheet();
    }

    function openSheet() {
        if (!sheetEl) {
            sheetEl = buildSheet();
            document.body.appendChild(sheetEl);
        }
        lastFocused = document.activeElement;
        sheetEl.hidden = false;
        document.body.style.overflow = 'hidden';
        holdScrollPosition();
        // next frame, so the opacity transition actually runs
        requestAnimationFrame(function () { sheetEl.classList.add('is-open'); });
        var first = sheetEl.querySelector('.contact-option');
        if (first && first.focus) first.focus({ preventScroll: true });
        document.addEventListener('keydown', onKeydown);
    }

    function closeSheet() {
        if (!sheetEl) return;
        sheetEl.classList.remove('is-open');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKeydown);
        setTimeout(function () { if (sheetEl) sheetEl.hidden = true; }, 180);
        if (lastFocused && lastFocused.focus) lastFocused.focus({ preventScroll: true });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var triggers = document.querySelectorAll('[data-contact-open]');
        Array.prototype.forEach.call(triggers, function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                openSheet();
            });
        });
    });
})();

// ===== ENQUIRY DIALOG =====
// 42 buttons across 18 pages pointed at #contact-form, and the form only ever
// existed on the home page: from an article or a service page the button threw
// the reader onto a different page and scrolled them to the bottom. They now
// open the form where the person already is. The form at the foot of the home
// page stays for anyone who scrolled that far.
(function () {
    // main.js is included before the dialog markup at the foot of the page, so
    // looking the element up at load time finds nothing and the whole
    // controller bails silently. Wait for the document instead.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEnquiryDialog);
    } else {
        initEnquiryDialog();
    }

    function initEnquiryDialog() {
    var dialog = document.getElementById('enquiryDialog');
    if (!dialog) return;

    var panel = dialog.querySelector('.enquiry-panel');
    var lastFocused = null;

    function openDialog() {
        lastFocused = document.activeElement;
        dialog.hidden = false;
        document.body.style.overflow = 'hidden';
        holdScrollPosition();
        requestAnimationFrame(function () { dialog.classList.add('is-open'); });
        var first = dialog.querySelector('input, select, textarea');
        // preventScroll обязателен: без него браузер, ставя курсор в поле,
        // подтягивает страницу под окно — человек закрывал анкету и оказывался
        // на 200-400 px ниже того места, где нажал кнопку.
        if (first && first.focus) first.focus({ preventScroll: true });
        document.addEventListener('keydown', onKeydown);
        trackEvent('enquiry_dialog_open', { page: window.location.pathname });
    }

    function closeDialog() {
        dialog.classList.remove('is-open');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKeydown);
        setTimeout(function () { dialog.hidden = true; }, 180);
        if (lastFocused && lastFocused.focus) lastFocused.focus({ preventScroll: true });
    }

    function onKeydown(e) {
        if (e.key === 'Escape' || e.keyCode === 27) { closeDialog(); return; }
        if (e.key !== 'Tab') return;
        // keep focus inside the dialog while it is open
        var f = panel.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled])');
        if (!f.length) return;
        var first = f[0], last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    }

    dialog.addEventListener('click', function (e) {
        if (e.target === dialog) closeDialog();
    });
    Array.prototype.forEach.call(dialog.querySelectorAll('[data-enquiry-close]'), function (b) {
        b.addEventListener('click', closeDialog);
    });

    document.addEventListener('click', function (e) {
        var a = e.target.closest ? e.target.closest('a[href*="#contact-form"]') : null;
        if (!a) return;
        // Every one of these buttons opens the form in place, the home page
        // included. Scrolling there instead was inconsistent: the same button
        // behaved differently depending on the page, and on the home page it
        // threw the reader to the very bottom. The form still sits at the foot
        // of the home page for anyone who scrolls down on their own.
        e.preventDefault();
        openDialog();
    });

    // a successful send closes the dialog behind the visitor
    var modalForm = document.getElementById('contactFormModal');
    if (modalForm) {
        modalForm.addEventListener('submit', function () {
            var was = modalForm.querySelector('[name="email"]').value;
            setTimeout(function () {
                // only if the form actually cleared, i.e. the send went through
                if (modalForm.querySelector('[name="email"]').value !== was) closeDialog();
            }, 1200);
        });
    }
    }
})();

// ===== B2B ENQUIRY DIALOG =====
// Пять кнопок на странице для компаний вели к анкете в самом низу страницы:
// человек нажимал в первом экране, а его уносило на 6 500 px вниз. Теперь
// анкета открывается там, где нажали. Форма не копируется, а переезжает в окно
// и возвращается на своё место при закрытии — поэтому её id, обработчик
// отправки и переводы остаются те же, и внизу страницы анкета не пропадает.
(function () {
    var CLOSE_LABEL = { uk: 'Закрити', ru: 'Закрыть', en: 'Close' };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initB2bDialog);
    } else {
        initB2bDialog();
    }

    function initB2bDialog() {
        var form = document.getElementById('b2bForm');
        var section = document.getElementById('b2b-form');
        if (!form || !section) return;

        var lang = (document.documentElement.lang || 'uk').slice(0, 2);
        var home = document.createComment('b2b-form');
        var dialog = null;
        var panel = null;
        var lastFocused = null;

        function build() {
            var heading = section.querySelector('.form-info h2');
            var sub = section.querySelector('.form-info h2 + p');

            var d = document.createElement('div');
            d.className = 'enquiry-backdrop';
            d.hidden = true;
            d.setAttribute('role', 'dialog');
            d.setAttribute('aria-modal', 'true');

            panel = document.createElement('div');
            panel.className = 'enquiry-panel enquiry-panel--wide';

            var close = document.createElement('button');
            close.type = 'button';
            close.className = 'enquiry-close';
            close.setAttribute('aria-label', CLOSE_LABEL[lang] || CLOSE_LABEL.uk);
            close.innerHTML = '&times;';
            close.addEventListener('click', closeDialog);
            panel.appendChild(close);

            if (heading) {
                var title = document.createElement('p');
                title.className = 'enquiry-title';
                title.textContent = heading.textContent;
                panel.appendChild(title);
                d.setAttribute('aria-label', heading.textContent);
            }
            if (sub) {
                var subtitle = document.createElement('p');
                subtitle.className = 'enquiry-sub';
                subtitle.textContent = sub.textContent;
                panel.appendChild(subtitle);
            }

            d.appendChild(panel);
            d.addEventListener('click', function (e) { if (e.target === d) closeDialog(); });
            document.body.appendChild(d);
            return d;
        }

        function onKeydown(e) {
            if (e.key === 'Escape' || e.keyCode === 27) { closeDialog(); return; }
            if (e.key !== 'Tab' || !panel) return;
            var f = panel.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled])');
            if (!f.length) return;
            var first = f[0], last = f[f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }

        function openDialog(wantsDemo) {
            if (!dialog) dialog = build();
            if (form.parentNode !== panel) {
                form.parentNode.insertBefore(home, form);
                panel.appendChild(form);
            }
            if (wantsDemo) {
                var demo = form.querySelector('#demo-request');
                if (demo) demo.checked = true;
            }
            lastFocused = document.activeElement;
            dialog.hidden = false;
            document.body.style.overflow = 'hidden';
            holdScrollPosition();
            requestAnimationFrame(function () { dialog.classList.add('is-open'); });
            var firstField = form.querySelector('input, select, textarea');
            if (firstField && firstField.focus) firstField.focus({ preventScroll: true });
            document.addEventListener('keydown', onKeydown);
            if (typeof trackEvent === 'function') {
                trackEvent('b2b_dialog_open', { page: window.location.pathname });
            }
        }

        function closeDialog() {
            if (!dialog) return;
            dialog.classList.remove('is-open');
            document.body.style.overflow = '';
            document.removeEventListener('keydown', onKeydown);
            setTimeout(function () {
                dialog.hidden = true;
                if (home.parentNode) home.parentNode.insertBefore(form, home);
            }, 180);
            if (lastFocused && lastFocused.focus) lastFocused.focus({ preventScroll: true });
        }

        document.addEventListener('click', function (e) {
            var a = e.target.closest ? e.target.closest('a[href*="#b2b-form"]') : null;
            if (!a) return;
            e.preventDefault();
            // «Замовити демонстрацію» сразу ставит галочку про демонстрацию:
            // человек уже сказал, чего хочет, спрашивать второй раз незачем.
            openDialog((a.getAttribute('data-i18n') || '') === 'b2b_btn_demo');
        });

        // успешная отправка закрывает окно за человеком
        form.addEventListener('submit', function () {
            var email = form.querySelector('[name="email"]');
            var was = email ? email.value : '';
            setTimeout(function () {
                if (email && email.value !== was) closeDialog();
            }, 1200);
        });
    }
})();

// ===== NEWSLETTER SUBSCRIPTION =====
// Two subscribe boxes live in the blog: the sidebar widget on the index and the
// wide band at the foot of the hypertension article. Until now neither had a
// handler or a name on its input, so submitting did a plain GET: the page
// reloaded and the address was gone. They post to the same Make webhook as the
// enquiry forms, marked form_type: 'newsletter' so the scenario can tell them
// apart. Deferred, because this file is loaded before the markup on some pages.
(function () {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNewsletterForms);
    } else {
        initNewsletterForms();
    }

    function initNewsletterForms() {
        var forms = document.querySelectorAll('form.newsletter-form[data-make-webhook], form.newsletter-form-large[data-make-webhook]');
        Array.prototype.forEach.call(forms, function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var t = newsletterMessages();
                var input = form.querySelector('input[type="email"]');
                var email = input ? String(input.value || '').trim() : '';
                var webhookUrl = form.dataset.makeWebhook || '';

                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showNotification(t.invalidEmail, 'error');
                    return;
                }
                if (!/^https?:\/\//.test(webhookUrl)) {
                    showNotification(t.error, 'error');
                    return;
                }

                var btn = form.querySelector('button[type="submit"]');
                var originalText = btn ? btn.textContent : '';
                if (btn) { btn.textContent = t.sending; btn.disabled = true; }

                fetch(webhookUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        form_type: 'newsletter',
                        subject: 'BodyHealth — підписка на розсилку',
                        email: email,
                        timestamp: new Date().toISOString(),
                        source_page: window.location.href
                    })
                }).then(function (r) {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    showNotification(t.success, 'success');
                    form.reset();
                    if (typeof trackEvent === 'function') trackEvent('newsletter_subscribe', { page: window.location.pathname });
                }).catch(function (err) {
                    console.error('Newsletter submission error:', err);
                    // what they typed stays in the field
                    showNotification(t.error, 'error');
                    if (typeof trackEvent === 'function') trackEvent('newsletter_error', { error: err.message });
                }).then(function () {
                    if (btn) { btn.textContent = originalText; btn.disabled = false; }
                });
            });
        });
    }

    function newsletterMessages() {
        var lang = (document.documentElement.lang || 'uk').slice(0, 2);
        var dict = {
            uk: {
                sending: 'Надсилаємо…',
                success: 'Дякуємо! Ви підписані на розсилку.',
                error: 'Не вдалося підписатися. Напишіть нам на info@body-health.care',
                invalidEmail: 'Введіть коректну електронну адресу'
            },
            en: {
                sending: 'Sending…',
                success: 'Thank you! You are subscribed.',
                error: 'Could not subscribe. Please write to info@body-health.care',
                invalidEmail: 'Please enter a valid email address'
            },
            ru: {
                sending: 'Отправляем…',
                success: 'Спасибо! Вы подписаны на рассылку.',
                error: 'Не удалось подписаться. Напишите нам на info@body-health.care',
                invalidEmail: 'Введите корректный адрес электронной почты'
            }
        };
        return dict[lang] || dict.uk;
    }
})();
