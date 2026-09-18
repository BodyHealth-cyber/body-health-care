/* Чек здоров'я за 2 хвилини — /health-check.html
 *
 * Підрахунок за Life's Essential 8 (Lloyd-Jones et al., Circulation 2022):
 * кожен із восьми показників дає 0–100 балів, індекс — їхнє середнє.
 * Якщо людина не знає своїх аналізів, показник лишається непорахованим,
 * і на екрані це написано прямо, а не ховається за середнім по решті.
 *
 * Увесь текст живе в розмітці сторінки: і запитання, і рядки-заготовки в
 * .qz-strings. Скрипт оперує числами й ключами, тому складальник локалей
 * перекладає сторінку, не заглядаючи сюди.
 */
(function () {
    'use strict';

    var root = document.getElementById('quiz');
    if (!root) return;

    /* ---------- таблиці балів ---------- */
    function paPoints(min) {
        if (min >= 150) return 100;
        if (min >= 120) return 90;
        if (min >= 90) return 80;
        if (min >= 60) return 60;
        if (min >= 30) return 40;
        if (min >= 1) return 20;
        return 0;
    }
    function bmiPoints(b) {
        if (b < 25) return 100;
        if (b < 30) return 70;
        if (b < 35) return 30;
        if (b < 40) return 15;
        return 0;
    }
    function bpPoints(s, d, treated) {
        var p;
        if (s >= 160 || d >= 100) p = 0;
        else if (s >= 140 || d >= 90) p = 25;
        else if (s >= 130 || d >= 80) p = 50;
        else if (s >= 120) p = 75;
        else p = 100;
        return treated ? Math.max(0, p - 20) : p;
    }
    // Пороги LE8 задані в мг/дл; тут вони переведені в ммоль/л, бо в українських
    // лабораторіях ліпіди видають саме так. 130 мг/дл = 3,4 ммоль/л.
    function lipidPoints(nonHDL, treated) {
        var p;
        if (nonHDL < 3.4) p = 100;
        else if (nonHDL < 4.1) p = 60;
        else if (nonHDL < 4.9) p = 40;
        else if (nonHDL < 5.7) p = 20;
        else p = 0;
        return treated ? Math.max(0, p - 20) : p;
    }

    // Українська й російська сторінки пишуть десяткову кому, англійська — крапку.
    // Інакше «ІМТ 28.1» стоїть поруч із «ЛПВЩ прийнято 1,3» на одному екрані.
    var COMMA = ['uk', 'ru'].indexOf((document.documentElement.lang || 'uk').slice(0, 2)) !== -1;
    function dec(n, digits) {
        var s = Number(n).toFixed(digits === undefined ? 1 : digits);
        return COMMA ? s.replace('.', ',') : s;
    }

    /* ---------- рядки з розмітки ---------- */
    var STR = {};
    Array.prototype.forEach.call(root.parentNode.querySelectorAll('.qz-strings [data-t]'), function (el) {
        STR[el.getAttribute('data-t')] = (el.textContent || '').trim();
    });
    function t(key, vars) {
        var s = STR[key] || '';
        if (!vars) return s;
        return s.replace(/\{(\w+)\}/g, function (m, k) {
            return Object.prototype.hasOwnProperty.call(vars, k) ? vars[k] : m;
        });
    }

    /* ---------- стан ---------- */
    var S = {};        // відповіді-вибори за data-id екрана
    var N = {};        // числові поля за data-num
    var F = {};        // відмітки-галочки за data-flag
    var DIET = ['d_veg', 'd_fish', 'd_grain', 'd_sugar', 'd_meat'];
    var MEPA = {};     // уточнення харчування, 16 ознак; порожнє — не проходили
    var MEPA_N = 16;

    // Опитувальник MEPA, 0–16 ознак, і опублікована AHA відповідність балам LE8.
    function mepaPoints(score) {
        if (score >= 15) return 100;
        if (score >= 12) return 80;
        if (score >= 8) return 50;
        if (score >= 4) return 25;
        return 0;
    }
    function mepaScore() {
        var n = 0;
        for (var k in MEPA) if (MEPA[k] === 'yes') n++;
        return n;
    }
    function mepaDone() { return Object.keys(MEPA).length === MEPA_N; }

    var screens = Array.prototype.slice.call(root.querySelectorAll('.qz-screen'));
    var questions = screens.filter(function (s) { return s.getAttribute('data-screen') === 'q'; });
    var intro = screens.filter(function (s) { return s.getAttribute('data-screen') === 'intro'; })[0];
    var result = screens.filter(function (s) { return s.getAttribute('data-screen') === 'result'; })[0];
    var mepa = screens.filter(function (s) { return s.getAttribute('data-screen') === 'mepa'; })[0];
    var stop = screens.filter(function (s) { return s.getAttribute('data-screen') === 'stop'; })[0];
    var MIN_AGE = 18;

    var bar = document.getElementById('qzBar');
    var nav = document.getElementById('qzNav');
    var btnBack = document.getElementById('qzBack');
    var btnNext = document.getElementById('qzNext');
    var count = document.getElementById('qzCount');

    var idx = -1;   // -1 — вступ, 0..n-1 — запитання, n — результат

    function id(el) { return el.getAttribute('data-id'); }

    /* Пропуски. Нуль днів навантаження — питати про хвилини нема сенсу;
       той, хто курить сам, уже отримав нуль, і питання про чужий дим зайве. */
    function skipped(el) {
        var key = id(el);
        if (key === 'shs' && S.nic === 'now') return true;
        return false;
    }
    function step(from, dir) {
        var i = from + dir;
        while (i >= 0 && i < questions.length && skipped(questions[i])) i += dir;
        return i;
    }

    function num(key) {
        var v = N[key];
        return (typeof v === 'number' && !isNaN(v)) ? v : null;
    }

    function ready(el) {
        var key = id(el);
        if (key === 'pa') return !!S.paDays && (S.paDays === '0' || !!S.paMin);
        if (key === 'profile') return !!S.profile && num('age') !== null;
        if (key === 'body') return num('h') !== null && num('w') !== null;
        if (key === 'bp') {
            if (S.bp === 'no') return true;
            return !!S.bp && num('sys') !== null && num('dia') !== null;
        }
        if (key === 'lip') {
            if (S.lip === 'no') return true;
            if (S.lip === 'full') return num('tc') !== null && num('hdl') !== null;
            if (S.lip === 'total') return num('tc') !== null;
            return false;
        }
        return !!S[key];
    }

    /* Хвилини рахуємо від середини діапазону: «3–5 днів» це 4.
       Нуль днів — питати про хвилини нема про що, блок ховається. */
    function paWeek() {
        var d = parseFloat(S.paDays), m = parseFloat(S.paMin);
        if (isNaN(d) || isNaN(m)) return 0;
        return Math.round(d * m);
    }
    function paReveal(el) {
        if (id(el) !== 'pa') return;
        var mins = el.querySelector('[data-sub="paMin"]');
        if (mins) mins.hidden = (S.paDays === '0');
    }

    function reveals(el) {
        Array.prototype.forEach.call(el.querySelectorAll('[data-reveal]'), function (box) {
            var allowed = box.getAttribute('data-reveal').split(/\s+/);
            box.hidden = allowed.indexOf(S[id(el)]) === -1;
        });
    }

    function live(el) {
        var box = el.querySelector('[data-live]');
        if (!box) return;
        var kind = box.getAttribute('data-live');
        if (kind === 'bmi') {
            var h = num('h'), w = num('w');
            box.textContent = (h && w) ? t('bmi_live', { v: dec(w / Math.pow(h / 100, 2)) }) : '';
        }
        if (kind === 'pa') {
            box.textContent = S.paDays === '0'
                ? t('pa_live_zero')
                : (S.paDays && S.paMin) ? t('pa_live', { n: paWeek() }) : '';
        }
    }

    function show() {
        screens.forEach(function (s) { s.hidden = true; });
        if (idx < 0) {
            intro.hidden = false;
            nav.hidden = true;
            bar.style.width = '0%';
            return;
        }
        if (idx === 'mepa') {
            mepa.hidden = false;
            nav.hidden = true;
            bar.style.width = '100%';
            return;
        }
        if (idx >= questions.length && num('age') !== null && num('age') < MIN_AGE) {
            stop.hidden = false;
            nav.hidden = true;
            bar.style.width = '100%';
            return;
        }
        if (idx >= questions.length) {
            renderResult();
            result.hidden = false;
            nav.hidden = true;
            bar.style.width = '100%';
            return;
        }
        var el = questions[idx];
        el.hidden = false;
        nav.hidden = false;
        reveals(el);
        paReveal(el);
        live(el);
        btnNext.disabled = !ready(el);
        count.textContent = t('cnt', { n: idx + 1 });
        bar.style.width = Math.round((idx / questions.length) * 100) + '%';
    }

    function go(next) {
        idx = next;
        show();
        var top = root.getBoundingClientRect().top + (window.scrollY || window.pageYOffset || 0);
        var header = document.querySelector('header.header');
        var offset = header ? header.getBoundingClientRect().height + 16 : 16;
        window.scrollTo({ top: Math.max(0, top - offset), behavior: 'smooth' });
    }

    /* ---------- обробники ---------- */
    root.addEventListener('click', function (e) {
        var opt = e.target.closest ? e.target.closest('.qz-opt') : null;
        if (opt && root.contains(opt)) {
            var item = opt.closest('.qz-item');
            if (item) {
                MEPA[item.getAttribute('data-k')] = opt.getAttribute('data-v');
                Array.prototype.forEach.call(item.querySelectorAll('.qz-opt'), function (b) {
                    b.setAttribute('aria-pressed', b === opt ? 'true' : 'false');
                });
                document.getElementById('qzMepaDone').disabled = !mepaDone();
                document.getElementById('qzMepaCount').textContent =
                    t('m_mepa_count', { n: Object.keys(MEPA).length });
                return;
            }
            var screen = opt.closest('.qz-screen');
            /* Екран активності несе дві групи — підсвічуємо лише свою. */
            var part = opt.closest('[data-sub]');
            var scope = part || screen;
            var key = part ? part.getAttribute('data-sub') : id(screen);
            S[key] = opt.getAttribute('data-v');
            Array.prototype.forEach.call(scope.querySelectorAll('.qz-opt'), function (b) {
                b.setAttribute('aria-pressed', b === opt ? 'true' : 'false');
            });
            reveals(screen);
            paReveal(screen);
            live(screen);
            btnNext.disabled = !ready(screen);
            return;
        }
        if (e.target.closest && e.target.closest('[data-qz-next]')) go(step(-1, 1));
    });

    root.addEventListener('change', function (e) {
        var box = e.target;
        if (!box.hasAttribute || !box.hasAttribute('data-flag')) return;
        F[box.getAttribute('data-flag')] = !!box.checked;
    });

    root.addEventListener('input', function (e) {
        var field = e.target;
        if (!field.hasAttribute || !field.hasAttribute('data-num')) return;
        var raw = String(field.value).replace(',', '.');
        var v = parseFloat(raw);
        N[field.getAttribute('data-num')] = isNaN(v) ? null : v;
        var screen = field.closest('.qz-screen');
        live(screen);
        btnNext.disabled = !ready(screen);
    });

    btnNext.addEventListener('click', function () {
        if (btnNext.disabled) return;
        go(step(idx, 1));
    });
    btnBack.addEventListener('click', function () {
        go(idx <= 0 ? -1 : step(idx, -1));
    });

    /* ---------- підрахунок ---------- */
    function nicotinePoints() {
        var base = pointsOf('nic', S.nic);
        var second = S.shs === 'yes' ? -20 : 0;
        return Math.max(0, base + second);
    }
    function pointsOf(screenId, value) {
        var el = root.querySelector('.qz-screen[data-id="' + screenId + '"] .qz-opt[data-v="' + value + '"]');
        var p = el && el.getAttribute('data-p');
        return p === null || p === undefined ? 0 : parseInt(p, 10);
    }
    function labelOf(screenId, value) {
        var el = root.querySelector('.qz-screen[data-id="' + screenId + '"] .qz-opt[data-v="' + value + '"]');
        return el ? (el.textContent || '').trim() : '';
    }

    function compute() {
        var bmi = num('w') / Math.pow(num('h') / 100, 2);
        var week = paWeek();

        var dietScore = 0;
        var dietNote = t('n_diet');
        if (mepaDone()) {
            var mScore = mepaScore();
            dietScore = mepaPoints(mScore);
            dietNote = t('n_diet_mepa', { n: mScore });
        } else {
            DIET.forEach(function (k) { dietScore += pointsOf(k, S[k]); });
        }

        var rows = [
            { key: 'diet', name: t('c_diet'), p: dietScore, note: dietNote },
            { key: 'pa', name: t('c_pa'), p: paPoints(week), note: t('n_pa', { n: week }) },
            { key: 'nic', name: t('c_nic'), p: nicotinePoints(), note: S.shs === 'yes' ? t('n_shs') : '' },
            { key: 'sleep', name: t('c_sleep'), p: pointsOf('sleep', S.sleep), note: t('n_sleep', { l: labelOf('sleep', S.sleep) }) },
            { key: 'bmi', name: t('c_bmi'), p: bmiPoints(bmi), note: t('n_bmi', { v: dec(bmi) }) }
        ];

        // Вычитать из общего холестерина усреднённый ЛПВЩ врачи признали клинически
        // неверным: разброс слишком велик. Если известен только общий — показатель
        // остаётся непосчитанным, а человек получает рекомендацию по общему.
        if (S.lip === 'no') {
            rows.push({ key: 'lip', name: t('c_lip'), p: null, note: t('n_none') });
        } else if (S.lip === 'total') {
            rows.push({ key: 'lip', name: t('c_lip'), p: null, advice: 'a_lip_total',
                        note: t('n_lip_total', { v: dec(num('tc')) }) });
        } else {
            var nonHDL = num('tc') - num('hdl');
            var parts = [t('n_lip', { v: dec(nonHDL) })];
            if (F.statins) parts.push(t('n_med'));
            rows.push({ key: 'lip', name: t('c_lip'), p: lipidPoints(nonHDL, !!F.statins), note: parts.join(' · ') });
        }

        var DIABETES = ['d7', 'd79', 'd89', 'd99', 'd10'];
        if (S.glu === 'no') rows.push({ key: 'glu', name: t('c_glu'), p: null, note: t('n_none') });
        else rows.push({ key: 'glu', name: t('c_glu'), p: pointsOf('glu', S.glu),
                         note: labelOf('glu', S.glu),
                         advice: DIABETES.indexOf(S.glu) !== -1 ? 'a_glu_diabetes' : null });

        if (S.bp === 'no') {
            rows.push({ key: 'bp', name: t('c_bp'), p: null, note: t('n_none') });
        } else {
            var bpNote = num('sys') + '/' + num('dia');
            if (S.bp === 'med') bpNote += ' · ' + t('n_med');
            rows.push({ key: 'bp', name: t('c_bp'), p: bpPoints(num('sys'), num('dia'), S.bp === 'med'), note: bpNote });
        }
        return rows;
    }

    function tone(p) {
        if (p === null) return 'none';
        if (p >= 80) return 'good';
        if (p >= 50) return 'mid';
        return 'low';
    }

    var summary = null;   // те, що піде у заявку, якщо людина сама попросить

    function renderResult() {
        var rows = compute();
        var known = rows.filter(function (r) { return r.p !== null; });
        var missing = rows.filter(function (r) { return r.p === null; });
        var index = Math.round(known.reduce(function (a, r) { return a + r.p; }, 0) / known.length);
        var level = index >= 80 ? t('lvl_hi') : index >= 50 ? t('lvl_mid') : t('lvl_low');
        var cls = index >= 80 ? 'good' : index >= 50 ? 'mid' : 'low';

        var score = document.getElementById('qzScore');
        score.textContent = index;
        score.className = 'qz-num qz-' + cls;
        var badge = document.getElementById('qzBadge');
        badge.textContent = level;
        badge.className = 'qz-badge qz-' + cls;

        if (refine) refine.hidden = mepaDone();

        var partial = document.getElementById('qzPartial');
        if (missing.length) {
            var names = missing.map(function (r) { return t('u_' + r.key) || r.name; }).join(', ');
            partial.innerHTML = '';
            var head = document.createElement('strong');
            var whole = t('partial', { n: known.length, l: names });
            var dot = whole.indexOf('. ');
            head.textContent = dot > 0 ? whole.slice(0, dot + 1) : whole;
            partial.appendChild(head);
            if (dot > 0) partial.appendChild(document.createTextNode(' ' + whole.slice(dot + 2)));
            partial.hidden = false;
        } else {
            partial.hidden = true;
        }

        var body = document.getElementById('qzRows');
        body.innerHTML = '';
        rows.forEach(function (r) {
            var tr = document.createElement('tr');
            var td = document.createElement('td');
            var nameEl = document.createElement('span');
            nameEl.className = 'qz-cname';
            nameEl.textContent = r.name;
            td.appendChild(nameEl);
            if (r.note) {
                var noteEl = document.createElement('div');
                noteEl.className = 'qz-cnote';
                noteEl.textContent = r.note;
                td.appendChild(noteEl);
            }
            var barEl = document.createElement('span');
            barEl.className = 'qz-bar';
            var fill = document.createElement('i');
            fill.className = 'qz-fill-' + tone(r.p);
            fill.style.width = (r.p === null ? 0 : r.p) + '%';
            barEl.appendChild(fill);
            td.appendChild(barEl);
            tr.appendChild(td);

            var val = document.createElement('td');
            val.className = 'qz-r qz-' + tone(r.p);
            val.textContent = r.p === null ? '—' : r.p;
            tr.appendChild(val);
            body.appendChild(tr);
        });

        // Спершу те, що взагалі не виміряно: здати аналіз важливіше, ніж
        // підтягувати показник, який ми вже бачимо.
        var worst = known.slice().sort(function (a, b) { return a.p - b.p; });
        var plan = missing.concat(worst).slice(0, 3);
        var stepsBox = document.getElementById('qzSteps');
        stepsBox.innerHTML = '';
        plan.forEach(function (r, i) {
            var li = document.createElement('li');
            var n = document.createElement('span');
            n.className = 'qz-n';
            n.textContent = i + 1;
            li.appendChild(n);
            var text = document.createElement('span');
            var head = document.createElement('strong');
            head.textContent = r.name + ' — ' + (r.p === null ? t('n_none') : t('n_pts', { n: r.p })) + '. ';
            text.appendChild(head);
            text.appendChild(document.createTextNode(t(r.advice || ('a_' + r.key))));
            li.appendChild(text);
            stepsBox.appendChild(li);
        });

        // Эмоциональное состояние — отдельный указатель, в индекс не входит и
        // никуда не отправляется: это самые чувствительные две строки на странице.
        var moodBox = document.getElementById('qzMood');
        if (moodBox) {
            var mood = pointsOf('phq1', S.phq1) + pointsOf('phq2', S.phq2);
            moodBox.innerHTML = '';
            var moodP = document.createElement('p');
            moodP.className = mood >= 3 ? 'qz-lead qz-mood-low' : 'qz-lead';
            moodP.textContent = mood >= 3 ? t('mood_low') : t('mood_ok');
            moodBox.appendChild(moodP);
            var moodNote = document.createElement('p');
            moodNote.className = 'qz-foot';
            moodNote.textContent = t('mood_note');
            moodBox.appendChild(moodNote);
        }

        var bmi = num('w') / Math.pow(num('h') / 100, 2);
        var bench = [
            ['59 %', bmi < 25 ? t('b_bmi_ok') : t('b_bmi_no')],
            ['66 %', S.d_veg === 'yes' ? t('b_veg_ok') : t('b_veg_no')],
            ['34 %', (S.nic === 'never' || S.nic === 'q5') ? t('b_nic_ok') : t('b_nic_no')],
            ['35 %', t('b_bp')]
        ];
        var benchBox = document.getElementById('qzBench');
        benchBox.innerHTML = '';
        bench.forEach(function (pair) {
            var row = document.createElement('div');
            var b = document.createElement('b');
            b.textContent = pair[0];
            row.appendChild(b);
            var s = document.createElement('span');
            s.textContent = pair[1];
            row.appendChild(s);
            benchBox.appendChild(row);
        });

        // У заявку йдуть тільки підсумкові бали. Відповіді про куріння, вагу
        // й аналізи лишаються на цій сторінці та нікуди не надсилаються.
        summary = t('m_sum', { n: index, l: level.toLowerCase(), v: known.length }) + ' ' +
            rows.map(function (r) { return r.name + ': ' + (r.p === null ? '—' : r.p); }).join(' · ');
    }

    /* ---------- уточнення харчування ---------- */
    var refine = document.getElementById('qzRefine');
    var refineBtn = document.getElementById('qzRefineBtn');
    if (refineBtn) {
        refineBtn.addEventListener('click', function () { go('mepa'); });
        document.getElementById('qzMepaBack').addEventListener('click', function () { go(questions.length); });
        document.getElementById('qzMepaDone').addEventListener('click', function () {
            if (!mepaDone()) return;
            go(questions.length);
        });
    }

    /* ---------- заявка ---------- */
    var form = document.getElementById('quizForm');
    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            var consent = form.querySelector('#qz-consent');
            var privacy = form.querySelector('#qz-privacy');
            if (!consent.checked || !privacy.checked) {
                notify(t('m_consent'), 'error');
                return;
            }

            // Телефон обязателен: разбор человеку отдаёт координатор голосом, а
            // прочерк в письме вместо номера выглядел как сбой отправки.
            var phoneEl = form.querySelector('#qz-phone');
            var phone = (phoneEl.value || '').trim();
            if (!phone) {
                notify(t('m_phone'), 'error');
                phoneEl.focus();
                return;
            }
            if (typeof isValidPhone === 'function' && !isValidPhone(phone)) {
                notify(t('m_phone_bad'), 'error');
                phoneEl.focus();
                return;
            }
            var button = form.querySelector('button[type="submit"]');
            var original = button.textContent;
            button.textContent = t('m_sending');
            button.disabled = true;

            // Ответ Turnstile приходит не мгновенно. Ждём его, а не объявляем
            // сразу, что проверка не пройдена: человек нажал кнопку и вправе
            // видеть «надсилаємо», а не ошибку, которой ещё не было.
            var token = '';
            if (typeof turnstileTokenWait === 'function') token = await turnstileTokenWait(form, 8000);
            else if (typeof turnstileToken === 'function') token = turnstileToken(form);
            if (!token) {
                notify(t('m_turnstile'), 'error');
                if (typeof resetTurnstile === 'function') resetTurnstile(form);
                button.textContent = original;
                button.disabled = false;
                return;
            }

            var sentAt = new Date();
            var payload = {
                form_type: 'client',
                subject: 'BodyHealth — ' + t('m_subject'),
                first_name: (form.querySelector('#qz-name').value || '').trim(),
                last_name: '—',
                email: (form.querySelector('#qz-email').value || '').trim(),
                phone: phone,
                service: 'health-check',
                service_label: t('m_subject'),
                message: summary || '—',
                turnstile_token: token,
                timestamp: sentAt.toISOString(),
                submitted_at: (typeof localTimestamp === 'function') ? localTimestamp(sentAt) : sentAt.toISOString(),
                source_page: window.location.href
            };

            fetch('/api/enquiry', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(function (res) {
                if (res.ok) {
                    notify(t('m_ok'), 'success');
                    form.reset();
                    if (typeof trackEvent === 'function') trackEvent('quiz_submit_success', { index: payload.message.slice(0, 40) });
                } else if (res.status === 400) {
                    notify(t('m_turnstile'), 'error');
                } else {
                    throw new Error('endpoint ' + res.status);
                }
            }).catch(function (err) {
                console.error('quiz submit:', err);
                notify(t('m_err'), 'error');
            }).then(function () {
                button.textContent = original;
                button.disabled = false;
                if (typeof resetTurnstile === 'function') resetTurnstile(form);
            });
        });
    }

    function notify(text, kind) {
        if (typeof showNotification === 'function') showNotification(text, kind);
        else alert(text);
    }

    show();
})();
