<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('contacts.meta.title') }}</title>
    <meta name="description" content="{{ __('contacts.meta.description') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header', ['active' => 'contacts'])

    <main>
        <section class="services">
            <div class="container">
                <div class="section-header">
                    <h1>{{ __('contacts.page.title') }}</h1>
                    <p>{{ __('contacts.page.subtitle') }}</p>
                </div>

                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>{{ __('contacts.page.phone') }}</h3>
                        <p class="service-description">
                            <a href="tel:+380962675052">+38 (096) 267-50-52</a>
                        </p>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>{{ __('contacts.page.email') }}</h3>
                        <p class="service-description">
                            <a href="mailto:info@body-health.care">info@body-health.care</a>
                        </p>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3>{{ __('contacts.page.website') }}</h3>
                        <p class="service-description">
                            <a href="https://body-health.care" target="_blank" rel="noopener noreferrer">body-health.care</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
</body>
</html>
