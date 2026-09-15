# Заявки с сайта — все три вида, 16.09.2026

## Что было

Опись всех `<form>` в `resources/views` показала три разных вида форм.
Два отправляли заявки в Make, третий — нет.

| Форма | Где | Было | Стало |
|---|---|---|---|
| `contactForm` / `contactFormModal` | главная + окно на 18 страницах | вебхук ✅ | без изменений |
| `b2bForm` | for-companies.html | вебхук ✅ | добавлен `subject` |
| `newsletterForm` | blog.html, сайдбар | **ничего** | вебхук ✅ |
| `articleNewsletter` | blog/managing-hypertension-2024.html | **ничего** | вебхук ✅ |

## Чем это было плохо

У форм подписки не было ни обработчика в JS, ни `data-make-webhook`,
ни даже атрибута `name` у поля ввода. Submit уходил обычным GET:
страница перезагружалась, адрес исчезал бесследно. Никакой ошибки
пользователю не показывалось — он видел моргание и уходил, считая,
что подписался.

Отдельно: payload формы B2B не содержал поля `subject`, а модуль Gmail
в Make подставляет тему письма из `{{1.subject}}`. Корпоративные заявки
приходили с пустой темой.

## Что сделано

- `public/js/main.js` — добавлен обработчик подписки (отложен до
  `DOMContentLoaded`, потому что файл подключается раньше разметки).
  Отправляет `{form_type:'newsletter', subject, email, timestamp, source_page}`,
  валидирует адрес, показывает уведомление на языке страницы (uk/en/ru),
  при ошибке поле не очищает.
- `resources/views/blog.html`, `blog/managing-hypertension-2024.html` —
  у форм появился `data-make-webhook`, у полей `name="email"`.
- `resources/views/for-companies.html` — в payload добавлен
  `obj.subject = 'BodyHealth B2B — ' + companyName`.

`check-forms.py` после сборки: **5 форм с живым эндпоинтом**
(`articleNewsletter`, `b2bForm`, `contactForm`, `contactFormModal`,
`newsletterForm`). Было 3.

## Различать в Make

Все три вида идут в один вебхук и различаются полем `form_type`:

- `client` — заявка на консультацию
- `b2b` — корпоративная
- `newsletter` — подписка на рассылку

## Осталось

- Уведомление об ошибке в Make: сценарий сам выключается после сбоя,
  и заявки молча копятся. Настроить письмо при падении.
- Таблица заявок на новом Google Диске: три листа по `form_type`,
  наполняется модулем Google Sheets в том же сценарии. Требует
  отдельного подключения Google в Make (OAuth владельца).
