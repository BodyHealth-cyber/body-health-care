@php
    $footerBrandDescription = $footerBrandDescription ?? __('ui.footer.brand_desc');
    $footerExtraLegalLines = $footerExtraLegalLines ?? [];
    $showFooterSocial = $showFooterSocial ?? false;
@endphp

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-brand">
                    <div class="logo">
                        <img src="/img/logo_no_bg.png" alt="BodyHealth" style="height:55px;">
                        <span style="margin-right:8px; margin-left:8px">BodyHealth</span>
                    </div>
                    <p>{{ $footerBrandDescription }}</p>
                </div>
            </div>

            <div class="footer-section">
                <h4>{{ __('ui.footer.services') }}</h4>
                <ul>
                    <li><a href="/services/healthcare.html">{{ __('ui.header.service_healthcare') }}</a></li>
                    <li><a href="/services/ambulance.html">{{ __('ui.header.service_ambulance') }}</a></li>
                    <li><a href="/services/checkup.html">{{ __('ui.header.service_checkup') }}</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>{{ __('ui.footer.company') }}</h4>
                <ul>
                    <li><a href="/for-companies.html">{{ __('ui.header.for_companies') }}</a></li>
                    <li><a href="/contacts.html">{{ __('ui.header.contacts') }}</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>{{ __('ui.footer.support') }}</h4>
                <ul>
                    <li><a href="/blog.html">{{ __('ui.header.blog') }}</a></li>
                    <li><a href="{{ route('privacy.policy') }}">{{ __('ui.footer.privacy') }}</a></li>
                    <li><a href="{{ route('legal.terms') }}">{{ __('ui.footer.terms') }}</a></li>
                    <li><a href="{{ route('legal.refund') }}">{{ __('ui.footer.refund') }}</a></li>
                    <li><a href="{{ route('legal.contact_info') }}">{{ __('ui.footer.contact_information') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-legal">
                <p>&copy; 2026 BodyHealth. {{ __('ui.footer.all_rights') }}</p>
                @foreach ($footerExtraLegalLines as $line)
                    <p>{{ $line }}</p>
                @endforeach
            </div>

            @if ($showFooterSocial)
                <div class="footer-social">
                    <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                </div>
            @endif
        </div>
    </div>
</footer>
