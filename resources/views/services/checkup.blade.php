<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('services_pages.checkup.meta_title') }}</title>
    <meta name="description" content="{{ __('services_pages.checkup.meta_description') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header', ['active' => 'checkup'])

    <!-- Main Content -->
    <main>
        <!-- Service Hero -->
        <section class="service-hero">
            <div class="container">
                <div class="service-hero-content">
                    <div class="service-intro">
                        <div class="breadcrumb">
                            <a href="/">{{ __('services_pages.common.home') }}</a> / <a href="/">{{ __('services_pages.common.services') }}</a> / <span>{{ __('ui.header.service_checkup') }}</span>
                        </div>
                        <div class="service-badge" style="background-color: #d1ecf1; color: #0c5460;">{{ __('services_pages.checkup.badge') }}</div>
                        <h1>{{ __('ui.header.service_checkup') }}</h1>
                        <p class="service-price">$100 <span>{{ __('services_pages.checkup.price_suffix') }}</span></p>
                        <p class="service-subtitle">{{ __('services_pages.checkup.subtitle') }}</p>
                        <div class="service-actions">
                            <a href="/index.html#contact-form" class="btn btn-primary btn-large">{{ __('services_pages.checkup.order_plan') }}</a>
                            <a href="/pricing.html" class="btn btn-outline btn-large">{{ __('services_pages.common.compare_plans') }}</a>
                        </div>
                    </div>

                    <div class="service-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-clipboard-check"></i>
                            <span>{{ __('services_pages.checkup.highlight_1') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-file-medical"></i>
                            <span>{{ __('services_pages.checkup.highlight_2') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-route"></i>
                            <span>{{ __('services_pages.checkup.highlight_3') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-user-md"></i>
                            <span>{{ __('services_pages.checkup.highlight_4') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- What's Included -->
        <section class="whats-included">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.checkup.included_title') }}</h2>
                    <p>{{ __('services_pages.checkup.included_subtitle') }}</p>
                </div>

                <div class="checkup-process">
                    <div class="process-item">
                        <div class="process-number">1</div>
                        <div class="process-content">
                            <h3>{{ __('services_pages.checkup.process_1_title') }}</h3>
                            <p>{{ __('services_pages.checkup.process_1_desc') }}</p>
                            <div class="process-duration">{{ __('services_pages.checkup.process_1_duration') }}</div>
                        </div>
                    </div>

                    <div class="process-item">
                        <div class="process-number">2</div>
                        <div class="process-content">
                            <h3>{{ __('services_pages.checkup.process_2_title') }}</h3>
                            <p>{{ __('services_pages.checkup.process_2_desc') }}</p>
                            <div class="process-duration">{{ __('services_pages.checkup.process_2_duration') }}</div>
                        </div>
                    </div>

                    <div class="process-item">
                        <div class="process-number">3</div>
                        <div class="process-content">
                            <h3>{{ __('services_pages.checkup.process_3_title') }}</h3>
                            <p>{{ __('services_pages.checkup.process_3_desc') }}</p>
                            <div class="process-duration">{{ __('services_pages.checkup.process_3_duration') }}</div>
                        </div>
                    </div>

                    <div class="process-item">
                        <div class="process-number">4</div>
                        <div class="process-content">
                            <h3>{{ __('services_pages.checkup.process_4_title') }}</h3>
                            <p>{{ __('services_pages.checkup.process_4_desc') }}</p>
                            <div class="process-duration">{{ __('services_pages.checkup.process_4_duration') }}</div>
                        </div>
                    </div>
                </div>

                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.feature_1_title') }}</h3>
                        <p>{{ __('services_pages.checkup.feature_1_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.checkup.feature_1_point_1') }}</li>
                            <li>{{ __('services_pages.checkup.feature_1_point_2') }}</li>
                            <li>{{ __('services_pages.checkup.feature_1_point_3') }}</li>
                            <li>{{ __('services_pages.checkup.feature_1_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.feature_2_title') }}</h3>
                        <p>{{ __('services_pages.checkup.feature_2_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.checkup.feature_2_point_1') }}</li>
                            <li>{{ __('services_pages.checkup.feature_2_point_2') }}</li>
                            <li>{{ __('services_pages.checkup.feature_2_point_3') }}</li>
                            <li>{{ __('services_pages.checkup.feature_2_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-route"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.feature_3_title') }}</h3>
                        <p>{{ __('services_pages.checkup.feature_3_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.checkup.feature_3_point_1') }}</li>
                            <li>{{ __('services_pages.checkup.feature_3_point_2') }}</li>
                            <li>{{ __('services_pages.checkup.feature_3_point_3') }}</li>
                            <li>{{ __('services_pages.checkup.feature_3_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.feature_4_title') }}</h3>
                        <p>{{ __('services_pages.checkup.feature_4_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.checkup.feature_4_point_1') }}</li>
                            <li>{{ __('services_pages.checkup.feature_4_point_2') }}</li>
                            <li>{{ __('services_pages.checkup.feature_4_point_3') }}</li>
                            <li>{{ __('services_pages.checkup.feature_4_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.feature_5_title') }}</h3>
                        <p>{{ __('services_pages.checkup.feature_5_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.checkup.feature_5_point_1') }}</li>
                            <li>{{ __('services_pages.checkup.feature_5_point_2') }}</li>
                            <li>{{ __('services_pages.checkup.feature_5_point_3') }}</li>
                            <li>{{ __('services_pages.checkup.feature_5_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.feature_6_title') }}</h3>
                        <p>{{ __('services_pages.checkup.feature_6_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.checkup.feature_6_point_1') }}</li>
                            <li>{{ __('services_pages.checkup.feature_6_point_2') }}</li>
                            <li>{{ __('services_pages.checkup.feature_6_point_3') }}</li>
                            <li>{{ __('services_pages.checkup.feature_6_point_4') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sample Report -->
        <section class="sample-report">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.checkup.sample_title') }}</h2>
                    <p>{{ __('services_pages.checkup.sample_subtitle') }}</p>
                </div>

                <div class="report-preview">
                    <div class="report-sections">
                        <div class="report-section">
                            <div class="section-icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <h3>{{ __('services_pages.checkup.report_section_1_title') }}</h3>
                            <p>{{ __('services_pages.checkup.report_section_1_desc') }}</p>
                        </div>

                        <div class="report-section">
                            <div class="section-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h3>{{ __('services_pages.checkup.report_section_2_title') }}</h3>
                            <p>{{ __('services_pages.checkup.report_section_2_desc') }}</p>
                        </div>

                        <div class="report-section">
                            <div class="section-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h3>{{ __('services_pages.checkup.report_section_3_title') }}</h3>
                            <p>{{ __('services_pages.checkup.report_section_3_desc') }}</p>
                        </div>

                        <div class="report-section">
                            <div class="section-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h3>{{ __('services_pages.checkup.report_section_4_title') }}</h3>
                            <p>{{ __('services_pages.checkup.report_section_4_desc') }}</p>
                        </div>
                    </div>

                    <div class="report-sample">
                        <div class="report-header">
                            <h4>{{ __('services_pages.checkup.report_header_title') }}</h4>
                            <p>{{ __('services_pages.checkup.report_header_subtitle') }}</p>
                        </div>

                        <div class="report-content">
                            <div class="health-score">
                                <div class="score-circle">
                                    <span class="score">78</span>
                                    <span class="score-label">{{ __('services_pages.checkup.report_score_label') }}</span>
                                </div>
                                <div class="score-description">
                                    <h5>{{ __('services_pages.checkup.report_score_title') }}</h5>
                                    <p>{{ __('services_pages.checkup.report_score_desc') }}</p>
                                </div>
                            </div>

                            <div class="key-findings">
                                <h5>{{ __('services_pages.checkup.report_findings_title') }}</h5>
                                <ul>
                                    <li><span class="priority high">{{ __('services_pages.checkup.report_finding_1_priority') }}</span> {{ __('services_pages.checkup.report_finding_1_text') }}</li>
                                    <li><span class="priority medium">{{ __('services_pages.checkup.report_finding_2_priority') }}</span> {{ __('services_pages.checkup.report_finding_2_text') }}</li>
                                    <li><span class="priority low">{{ __('services_pages.checkup.report_finding_3_priority') }}</span> {{ __('services_pages.checkup.report_finding_3_text') }}</li>
                                </ul>
                            </div>

                            <div class="next-steps">
                                <h5>{{ __('services_pages.checkup.report_steps_title') }}</h5>
                                <ol>
                                    <li>{{ __('services_pages.checkup.report_step_1') }}</li>
                                    <li>{{ __('services_pages.checkup.report_step_2') }}</li>
                                    <li>{{ __('services_pages.checkup.report_step_3') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who It's For -->
        <section class="target-audience">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.checkup.audience_title') }}</h2>
                    <p>{{ __('services_pages.checkup.audience_subtitle') }}</p>
                </div>

                <div class="audience-grid">
                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.audience_item_1_title') }}</h3>
                        <p>{{ __('services_pages.checkup.audience_item_1_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.audience_item_2_title') }}</h3>
                        <p>{{ __('services_pages.checkup.audience_item_2_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-question"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.audience_item_3_title') }}</h3>
                        <p>{{ __('services_pages.checkup.audience_item_3_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>{{ __('services_pages.checkup.audience_item_4_title') }}</h3>
                        <p>{{ __('services_pages.checkup.audience_item_4_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="faq-section">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.common.faq_title') }}</h2>
                    <p>{{ __('services_pages.checkup.faq_subtitle') }}</p>
                </div>

                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.checkup.faq_1_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.checkup.faq_1_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.checkup.faq_2_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.checkup.faq_2_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.checkup.faq_3_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.checkup.faq_3_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.checkup.faq_4_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.checkup.faq_4_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.checkup.faq_5_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.checkup.faq_5_a') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>{{ __('services_pages.checkup.cta_title') }}</h2>
                    <p>{{ __('services_pages.checkup.cta_subtitle') }}</p>

                    <div class="cta-features">
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.checkup.cta_feature_1') }}</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.checkup.cta_feature_2') }}</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.checkup.cta_feature_3') }}</span>
                        </div>
                    </div>

                    <div class="cta-actions">
                        <a href="/index.html#contact-form" class="btn btn-primary btn-large">{{ __('services_pages.checkup.order_plan') }} {{ __('ui.header.service_checkup') }}</a>
                        <a href="/pricing.html" class="btn btn-outline btn-large">{{ __('services_pages.common.compare_all_plans') }}</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>

    <!-- Service-specific JavaScript -->
    <script>
        // FAQ Toggle Functionality
        document.querySelectorAll('.faq-item').forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = question.querySelector('i');

            question.addEventListener('click', () => {
                const isOpen = item.classList.contains('open');

                // Close all other items
                document.querySelectorAll('.faq-item').forEach(otherItem => {
                    otherItem.classList.remove('open');
                    otherItem.querySelector('.faq-answer').style.maxHeight = '0';
                    otherItem.querySelector('.faq-question i').style.transform = 'rotate(0deg)';
                });

                // Toggle current item
                if (!isOpen) {
                    item.classList.add('open');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.style.transform = 'rotate(180deg)';
                }
            });

            // Initial setup
            answer.style.maxHeight = '0';
            answer.style.overflow = 'hidden';
            answer.style.transition = 'max-height 0.3s ease';
            icon.style.transition = 'transform 0.3s ease';
        });
    </script>
</body>
</html>
