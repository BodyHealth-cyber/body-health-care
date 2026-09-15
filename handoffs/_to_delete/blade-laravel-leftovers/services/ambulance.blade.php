<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('services_pages.ambulance.meta_title') }}</title>
    <meta name="description" content="{{ __('services_pages.ambulance.meta_description') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header', ['active' => 'ambulance'])

    <!-- Main Content -->
    <main>
        <!-- Service Hero -->
        <section class="service-hero">
            <div class="container">
                <div class="service-hero-content">
                    <div class="service-intro">
                        <div class="breadcrumb">
                            <a href="/">{{ __('services_pages.common.home') }}</a> / <a href="/">{{ __('services_pages.common.services') }}</a> / <span>{{ __('ui.header.service_ambulance') }}</span>
                        </div>
                        <div class="service-badge" style="background-color: #fff3cd; color: #856404;">{{ __('services_pages.ambulance.badge') }}</div>
                        <h1>{{ __('ui.header.service_ambulance') }}</h1>
                        <p class="service-price">$500 <span>{{ __('services_pages.ambulance.price_suffix') }}</span></p>
                        <p class="service-subtitle">{{ __('services_pages.ambulance.subtitle') }}</p>
                        <div class="service-actions">
                            <a href="/index.html#contact-form" class="btn btn-primary btn-large">{{ __('services_pages.common.select_plan') }}</a>
                            <a href="/pricing.html" class="btn btn-outline btn-large">{{ __('services_pages.common.compare_plans') }}</a>
                        </div>
                    </div>

                    <div class="service-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-users"></i>
                            <span>{{ __('services_pages.ambulance.highlight_1') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-ambulance"></i>
                            <span>{{ __('services_pages.ambulance.highlight_2') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-star"></i>
                            <span>{{ __('services_pages.ambulance.highlight_3') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-link"></i>
                            <span>{{ __('services_pages.ambulance.highlight_4') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- What's Included -->
        <section class="whats-included">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.ambulance.included_title') }}</h2>
                    <p>{{ __('services_pages.ambulance.included_subtitle') }}</p>
                </div>

                <div class="included-banner">
                    <div class="banner-content">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h3>{{ __('services_pages.ambulance.included_banner_title') }}</h3>
                            <p>{{ __('services_pages.ambulance.included_banner_desc') }}</p>
                        </div>
                    </div>
                </div>

                <div class="features-grid">
                    <div class="feature-item featured-item">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.feature_1_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.feature_1_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.ambulance.feature_1_point_1') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_1_point_2') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_1_point_3') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_1_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item featured-item">
                        <div class="feature-icon">
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.feature_2_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.feature_2_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.ambulance.feature_2_point_1') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_2_point_2') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_2_point_3') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_2_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item featured-item">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.feature_3_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.feature_3_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.ambulance.feature_3_point_1') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_3_point_2') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_3_point_3') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_3_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item featured-item">
                        <div class="feature-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.feature_4_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.feature_4_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.ambulance.feature_4_point_1') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_4_point_2') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_4_point_3') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_4_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item featured-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.feature_5_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.feature_5_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.ambulance.feature_5_point_1') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_5_point_2') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_5_point_3') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_5_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item featured-item">
                        <div class="feature-icon">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.feature_6_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.feature_6_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.ambulance.feature_6_point_1') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_6_point_2') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_6_point_3') }}</li>
                            <li>{{ __('services_pages.ambulance.feature_6_point_4') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who It's For -->
        <section class="target-audience">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.ambulance.audience_title') }}</h2>
                    <p>{{ __('services_pages.ambulance.audience_subtitle') }}</p>
                </div>

                <div class="audience-grid">
                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.audience_item_1_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.audience_item_1_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.audience_item_2_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.audience_item_2_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.audience_item_3_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.audience_item_3_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>{{ __('services_pages.ambulance.audience_item_4_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.audience_item_4_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Success Stories -->
        <section class="success-stories">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.ambulance.stories_title') }}</h2>
                    <p>{{ __('services_pages.ambulance.stories_subtitle') }}</p>
                </div>

                <div class="stories-grid">
                    <div class="story-item">
                        <div class="story-stats">
                            <div class="stat">
                                <span class="stat-number">43%</span>
                                <span class="stat-label">{{ __('services_pages.ambulance.story_1_stat_label') }}</span>
                            </div>
                        </div>
                        <h3>{{ __('services_pages.ambulance.story_1_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.story_1_desc') }}</p>
                    </div>

                    <div class="story-item">
                        <div class="story-stats">
                            <div class="stat">
                                <span class="stat-number">38%</span>
                                <span class="stat-label">{{ __('services_pages.ambulance.story_2_stat_label') }}</span>
                            </div>
                        </div>
                        <h3>{{ __('services_pages.ambulance.story_2_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.story_2_desc') }}</p>
                    </div>

                    <div class="story-item">
                        <div class="story-stats">
                            <div class="stat">
                                <span class="stat-number">68%</span>
                                <span class="stat-label">{{ __('services_pages.ambulance.story_3_stat_label') }}</span>
                            </div>
                        </div>
                        <h3>{{ __('services_pages.ambulance.story_3_title') }}</h3>
                        <p>{{ __('services_pages.ambulance.story_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="faq-section">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.common.faq_title') }}</h2>
                    <p>{{ __('services_pages.ambulance.faq_subtitle') }}</p>
                </div>

                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.ambulance.faq_1_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.ambulance.faq_1_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.ambulance.faq_2_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.ambulance.faq_2_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.ambulance.faq_3_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.ambulance.faq_3_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.ambulance.faq_4_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.ambulance.faq_4_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.ambulance.faq_5_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.ambulance.faq_5_a') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>{{ __('services_pages.ambulance.cta_title') }}</h2>
                    <p>{{ __('services_pages.ambulance.cta_subtitle') }}</p>

                    <div class="cta-features">
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.ambulance.cta_feature_1') }}</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.ambulance.cta_feature_2') }}</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.ambulance.cta_feature_3') }}</span>
                        </div>
                    </div>

                    <div class="cta-actions">
                        <a href="/index.html#contact-form" class="btn btn-primary btn-large">{{ __('services_pages.common.select_plan') }} {{ __('ui.header.service_ambulance') }}</a>
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
