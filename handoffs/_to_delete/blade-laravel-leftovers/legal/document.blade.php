<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document['meta_title'] }}</title>
    <meta name="description" content="{{ $document['meta_description'] }}">

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
                            <h1>{{ $document['title'] }}</h1>
                            <p class="legal-summary">{{ $document['summary'] }}</p>
                        </div>

                        <div class="legal-meta-panel">
                            @if ($isDocumentAvailable && !empty($document['revision_date']))
                                <div class="legal-meta-block">
                                    <span class="legal-meta-label">{{ __('legal.common.revision_date') }}</span>
                                    <span class="legal-meta-value">{{ $document['revision_date'] }}</span>
                                </div>
                            @endif

                            <div class="legal-meta-block">
                                <span class="legal-meta-label">
                                    {{ $isDocumentAvailable ? __('legal.common.document_language') : __('legal.common.status') }}
                                </span>
                                <span class="legal-meta-value">
                                    {{ $isDocumentAvailable ? $documentLanguageLabel : __('legal.common.not_ready_status') }}
                                </span>
                            </div>

                            @unless ($isDocumentAvailable)
                                <div class="legal-meta-block">
                                    <span class="legal-meta-label">{{ __('legal.common.available_language') }}</span>
                                    <span class="legal-meta-value">{{ __('legal.common.ukrainian_language') }}</span>
                                </div>
                            @endunless
                        </div>
                    </div>

                    @if (!empty($languageLinks))
                        <div class="legal-language-switcher" aria-label="{{ __('legal.terms_index.version_links_label') }}">
                            @foreach ($languageLinks as $languageLink)
                                <a href="{{ $languageLink['url'] }}" class="btn {{ $languageLink['locale'] === app()->getLocale() ? 'btn-primary' : 'btn-outline' }}">
                                    {{ $languageLink['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if ($isDocumentAvailable)
                        @if (!empty($document['details']))
                            <div class="legal-details-grid">
                                @foreach ($document['details'] as $detail)
                                    <div class="legal-detail-card">
                                        <span class="legal-detail-label">{{ $detail['label'] }}</span>
                                        <p class="legal-detail-value">{{ $detail['value'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (!empty($document['content_view']))
                            @include($document['content_view'])
                        @elseif (!empty($document['sections']))
                            <div class="legal-sections">
                                @foreach ($document['sections'] as $section)
                                    <section class="legal-section-block">
                                        <h2>{{ $section['heading'] }}</h2>

                                        @foreach ($section['paragraphs'] ?? [] as $paragraph)
                                            <p>{{ $paragraph }}</p>
                                        @endforeach

                                        @if (!empty($section['items']))
                                            <ul class="service-features legal-list">
                                                @foreach ($section['items'] as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </section>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="legal-empty-state">
                            <h2>{{ __('legal.common.not_ready_heading') }}</h2>
                            <p>{{ __('legal.common.not_ready_message') }}</p>

                            <div class="legal-actions">
                                <a href="{{ $ukrainianSwitchUrl }}" class="btn btn-primary">
                                    {{ __('legal.common.switch_to_ukrainian') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
</body>
</html>
