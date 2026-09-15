# body-health.care — the contact forms had no endpoint

**Status:** RESOLVED 15.09.2026. The Make.com webhook is live and the scenario is on.
Found while auditing the site after the trilingual build.

## What was wrong

Both forms on the site carried `data-make-webhook="MAKE_WEBHOOK_URL"` — the literal
placeholder string, never replaced with a real Make.com webhook.

- **`#contactForm`** (the home page, every locale). The browser resolved
  `MAKE_WEBHOOK_URL` as a *relative* path, so a submission POSTed to
  `https://body-health.care/.../MAKE_WEBHOOK_URL`, received a 405, fell into the
  catch branch and showed a generic red error. The visitor had no idea their
  enquiry went nowhere and no alternative was offered.
- **`#b2bForm`** (for-companies) had a guard and said "form temporarily
  unavailable" — honest, but still a dead end.

The primary call to action on every page of the site ("Розпочати супровід" /
"Start Care Program") leads to `#contact-form`. So the main conversion path was
silently dropping every lead, and nothing in the build or on the page said so.

## What changed

Neither form now pretends. Before submitting, each checks the endpoint is an
actual `http(s)://` URL. When it is not — or when the request fails — the visitor
is handed the same enquiry over a channel that works:

- a WhatsApp link with everything they typed already in the message body,
- Telegram,
- the phone number.

The form is **not reset**, so their text is still on screen, and the notice no
longer auto-dismisses after six seconds, because it now asks them to follow a
link.

`check-forms.py` runs on every build and reports which forms have a live endpoint.
It deliberately does **not** fail the build — the site is deployable and the
fallback works.

## Resolution

Webhook wired into both forms and pushed (commit `553b525`):
`https://hook.eu1.make.com/2e9lvba2ypntnv4e4q40i6b7l1epsvgo`

The Make scenario ("Integration Webhooks", scenario 7431287) was created but left
unsaved with its toggle off, so the endpoint answered
`410 There is no scenario listening for this webhook`. Saved and switched on
15.09.2026; a test POST now returns `200 Accepted`. `build.sh` reports
`forms: 2 with a live endpoint (b2bForm, contactForm)`.

**Still open:** the scenario has no action module. It accepts leads and does
nothing with them. Next step is an email module to `sales@body-health.care` once
the corporate mail is up — that needs an account sign-in, so it is an owner step.

## Payload shape, for whoever builds the Make scenario

`#contactForm` sends: `form_type`, `subject`, `first_name`, `last_name`, `email`,
`phone`, `service`, `message`, `timestamp`, `source_page`.

`#b2bForm` sends the form's own fields plus `goals` (an array of checked values),
`form_type: "b2b"`, `timestamp`, `source_page`.

## Worth noting

This was invisible until the 404 page landed earlier the same day. While every
unknown path returned the homepage with a 200, a request to
`/MAKE_WEBHOOK_URL` would also have returned 200 — and the form would have
reported **success** while delivering nothing at all. The 405 that exposed it is
a consequence of fixing the 404 handling first.
