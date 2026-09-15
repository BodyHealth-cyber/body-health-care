@php
    $active = $active ?? '';
    $isServicesActive = in_array($active, ['services', 'healthcare', 'ambulance', 'checkup'], true);
    $isCompaniesActive = $active === 'for-companies';
    $isBlogActive = in_array($active, ['blog', 'blog-article'], true);
    $isContactsActive = $active === 'contacts';
    $currentLocale = app()->getLocale();
    $localeLabelMap = ['uk' => 'UA', 'ru' => 'RU', 'en' => 'EN'];
    $currentLocaleLabel = $localeLabelMap[$currentLocale] ?? strtoupper($currentLocale);
    $localeUrl = static fn (string $locale): string => request()->fullUrlWithQuery(['lang' => $locale]);
@endphp
<header class="header">
    <div class="container">
        <nav class="nav">
            <div class="nav-brand">
                <a href="/" class="logo">
                    <img src="/img/logo_no_bg.png" alt="BodyHealth" style="height:55px;">
                    <span style="margin-right:8px; margin-left:8px">BodyHealth</span>
                </a>
            </div>

            <ul class="nav-menu">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link{{ $isServicesActive ? ' active' : '' }}">{{ __('ui.header.services') }} <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/services/healthcare.html">{{ __('ui.header.service_healthcare') }}</a></li>
                        <li><a href="/services/ambulance.html">{{ __('ui.header.service_ambulance') }}</a></li>
                        <li><a href="/services/checkup.html">{{ __('ui.header.service_checkup') }}</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/for-companies.html" class="nav-link{{ $isCompaniesActive ? ' active' : '' }}">{{ __('ui.header.for_companies') }}</a>
                </li>
                <li class="nav-item">
                    <a href="/blog.html" class="nav-link{{ $isBlogActive ? ' active' : '' }}">{{ __('ui.header.blog') }}</a>
                </li>
                <li class="nav-item">
                    <a href="/contacts.html" class="nav-link{{ $isContactsActive ? ' active' : '' }}">{{ __('ui.header.contacts') }}</a>
                </li>
            </ul>

            <div class="nav-actions">
                <div class="language-switcher">
                    <span class="current-lang">{{ $currentLocaleLabel }}</span>
                    <ul class="lang-menu">
                        <li><a href="{{ $localeUrl('en') }}">EN</a></li>
                        <li><a href="{{ $localeUrl('uk') }}">UA</a></li>
                        <li><a href="{{ $localeUrl('ru') }}">RU</a></li>
                    </ul>
                </div>
                <a href="/login.html" class="btn btn-white">{{ __('ui.header.login') }}</a>
                <a href="/#contact-form" class="btn btn-primary">{{ __('ui.header.start_care') }}</a>
            </div>

            <div class="mobile-lang-switcher" aria-label="Language switcher">
                <button class="mobile-lang-current" type="button" aria-expanded="false" aria-label="Select language">
                    {{ $currentLocaleLabel }}
                </button>
                <ul class="mobile-lang-menu">
                    <li><a href="{{ $localeUrl('en') }}" class="mobile-lang-link{{ $currentLocale === 'en' ? ' active' : '' }}">EN</a></li>
                    <li><a href="{{ $localeUrl('uk') }}" class="mobile-lang-link{{ $currentLocale === 'uk' ? ' active' : '' }}">UA</a></li>
                    <li><a href="{{ $localeUrl('ru') }}" class="mobile-lang-link{{ $currentLocale === 'ru' ? ' active' : '' }}">RU</a></li>
                </ul>
            </div>

            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </div>
</header>
