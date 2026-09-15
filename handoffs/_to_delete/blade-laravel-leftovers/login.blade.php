<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('ui.login_page.title') }}</title>
    <meta name="description" content="{{ __('ui.login_page.description') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header')

    <main>
        <section class="services">
            <div class="container">
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>{{ __('ui.login_page.for_doctors') }}</h3>
                        <p class="service-description">{{ __('ui.login_page.for_doctors_desc') }}</p>
                        <ul class="service-features">
                            <li>{{ __('ui.login_page.doctor_feature_1') }}</li>
                            <li>{{ __('ui.login_page.doctor_feature_2') }}</li>
                            <li>{{ __('ui.login_page.doctor_feature_3') }}</li>
                        </ul>
                        <a href="https://app.body-health.care" class="btn btn-primary" target="_blank" rel="noopener noreferrer">{{ __('ui.login_page.open_crm') }}</a>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>{{ __('ui.login_page.for_patients') }}</h3>
                        <p class="service-description">{{ __('ui.login_page.for_patients_desc') }}</p>
                        <ul class="service-features">
                            <li>{{ __('ui.login_page.patient_feature_1') }}</li>
                            <li>{{ __('ui.login_page.patient_feature_2') }}</li>
                            <li>{{ __('ui.login_page.patient_feature_3') }}</li>
                        </ul>
                        <div style="display:flex; gap:0.75rem; flex-wrap:wrap; justify-content:center;">
                            <a href="https://apps.apple.com/be/app/healthie/id1112029170" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><i class="fab fa-apple" style="margin-right:0.5rem;"></i>App Store</a>
                            <a href="https://play.google.com/store/apps/details?id=com.healthie.app.healthie&hl=en&gl=US&pli=1" class="btn btn-outline" target="_blank" rel="noopener noreferrer"><i class="fab fa-google-play" style="margin-right:0.5rem;"></i>Google Play</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
</body>
</html>
