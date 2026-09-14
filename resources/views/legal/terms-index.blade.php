<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('legal.terms_index.meta_title') }}</title>
    <meta name="description" content="{{ __('legal.terms_index.meta_description') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header')

    <main class="legal-page">
        <section class="legal-page-section">
            <div class="container">
                <div class="legal-card">
                    <div class="legal-card-header">
                        <div>
                            <p class="legal-eyebrow">{{ __('legal.common.category') }}</p>
                            <h1>{{ __('legal.terms_index.title') }}</h1>
                            <p class="legal-summary">{{ __('legal.terms_index.summary') }}</p>
                        </div>
                    </div>

                    <div class="legal-language-grid">
                        @foreach ($languageLinks as $languageLink)
                            <a href="{{ $languageLink['url'] }}" class="legal-language-card">
                                <span class="legal-language-card-label">{{ $languageLink['label'] }}</span>
                                <span class="legal-language-card-action">{{ __('legal.terms_index.open_version') }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
</body>
</html>
