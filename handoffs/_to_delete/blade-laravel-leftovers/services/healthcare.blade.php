<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('services_pages.healthcare.meta_title') }}</title>
    <meta name="description" content="{{ __('services_pages.healthcare.meta_description') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header', ['active' => 'healthcare'])

    <!-- Main Content -->
    <main>
        <!-- Service Hero -->
        <section class="service-hero">
            <div class="container">
                <div class="service-hero-content">
                    <div class="service-intro">
                        <div class="breadcrumb">
                            <a href="/">{{ __('services_pages.common.home') }}</a> / <a href="/">{{ __('services_pages.common.services') }}</a> / <span>{{ __('ui.header.service_healthcare') }}</span>
                        </div>
                        <div class="service-badge">{{ __('services_pages.healthcare.badge') }}</div>
                        <h1>{{ __('ui.header.service_healthcare') }}</h1>
                        <p class="service-price">$250 <span>{{ __('services_pages.healthcare.price_suffix') }}</span></p>
                        <p class="service-subtitle">{{ __('services_pages.healthcare.subtitle') }}</p>
                        <div class="service-actions">
                            <a href="/index.html#contact-form" class="btn btn-primary btn-large">{{ __('services_pages.common.select_plan') }}</a>
                            <a href="/pricing.html" class="btn btn-outline btn-large">{{ __('services_pages.common.compare_plans') }}</a>
                        </div>
                    </div>

                    <div class="service-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-user-md"></i>
                            <span>{{ __('services_pages.healthcare.highlight_1') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ __('services_pages.healthcare.highlight_2') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-heartbeat"></i>
                            <span>{{ __('services_pages.healthcare.highlight_3') }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-video"></i>
                            <span>{{ __('services_pages.healthcare.highlight_4') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- What's Included -->
        <section class="whats-included">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.healthcare.included_title') }}</h2>
                    <p>{{ __('services_pages.healthcare.included_subtitle') }}</p>
                </div>

                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.feature_1_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.feature_1_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.healthcare.feature_1_point_1') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_1_point_2') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_1_point_3') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_1_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.feature_2_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.feature_2_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.healthcare.feature_2_point_1') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_2_point_2') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_2_point_3') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_2_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.feature_3_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.feature_3_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.healthcare.feature_3_point_1') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_3_point_2') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_3_point_3') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_3_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.feature_4_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.feature_4_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.healthcare.feature_4_point_1') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_4_point_2') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_4_point_3') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_4_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.feature_5_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.feature_5_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.healthcare.feature_5_point_1') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_5_point_2') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_5_point_3') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_5_point_4') }}</li>
                        </ul>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.feature_6_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.feature_6_desc') }}</p>
                        <ul>
                            <li>{{ __('services_pages.healthcare.feature_6_point_1') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_6_point_2') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_6_point_3') }}</li>
                            <li>{{ __('services_pages.healthcare.feature_6_point_4') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who It's For -->
        <section class="target-audience">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.healthcare.audience_title') }}</h2>
                    <p>{{ __('services_pages.healthcare.audience_subtitle') }}</p>
                </div>

                <div class="audience-grid">
                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.audience_item_1_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.audience_item_1_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.audience_item_2_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.audience_item_2_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.audience_item_3_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.audience_item_3_desc') }}</p>
                    </div>

                    <div class="audience-item">
                        <div class="audience-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>{{ __('services_pages.healthcare.audience_item_4_title') }}</h3>
                        <p>{{ __('services_pages.healthcare.audience_item_4_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Personal Health Dashboard -->
        <section class="personal-dashboard">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.healthcare.dashboard_title') }}</h2>
                    <p>{{ __('services_pages.healthcare.dashboard_subtitle') }}</p>
                </div>

                <div class="dashboard-preview">
                    <div class="dashboard-header">
                        <div class="user-info">
                            <div class="avatar">MI</div>
                            <div class="user-details">
                                <h3>{{ __('services_pages.healthcare.dashboard_user_name') }}</h3>
                                <span>{{ __('services_pages.healthcare.dashboard_user_plan_status') }}</span>
                            </div>
                        </div>
                        <div class="health-score">
                            <div class="score-circle">
                                <span class="score">87</span>
                                <span class="score-max">/100</span>
                            </div>
                            <div class="score-label">{{ __('services_pages.healthcare.dashboard_health_index_label') }}</div>
                        </div>
                    </div>

                    <div class="dashboard-stats">
                        <div class="stat-item">
                            <div class="stat-icon heart-rate">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value">64 <small>{{ __('services_pages.healthcare.dashboard_stat_1_unit') }}</small></span>
                                <span class="stat-label">{{ __('services_pages.healthcare.dashboard_stat_1_label') }}</span>
                                <span class="stat-trend positive">{{ __('services_pages.healthcare.dashboard_stat_1_trend') }}</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon steps">
                                <i class="fas fa-walking"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value">8,247</span>
                                <span class="stat-label">{{ __('services_pages.healthcare.dashboard_stat_2_label') }}</span>
                                <span class="stat-trend positive">{{ __('services_pages.healthcare.dashboard_stat_2_trend') }}</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon sleep">
                                <i class="fas fa-moon"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value">{{ __('services_pages.healthcare.dashboard_stat_3_value') }}</span>
                                <span class="stat-label">{{ __('services_pages.healthcare.dashboard_stat_3_label') }}</span>
                                <span class="stat-trend neutral">{{ __('services_pages.healthcare.dashboard_stat_3_trend') }}</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon stress">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value">{{ __('services_pages.healthcare.dashboard_stat_4_value') }}</span>
                                <span class="stat-label">{{ __('services_pages.healthcare.dashboard_stat_4_label') }}</span>
                                <span class="stat-trend positive">{{ __('services_pages.healthcare.dashboard_stat_4_trend') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-alerts">
                        <h4><i class="fas fa-bell"></i> {{ __('services_pages.healthcare.dashboard_alerts_title') }}</h4>
                        <div class="alerts-list">
                            <div class="alert-item priority-medium">
                                <div class="alert-icon">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="alert-content">
                                    <span class="alert-title">{{ __('services_pages.healthcare.dashboard_alert_1_title') }}</span>
                                    <span class="alert-description">{{ __('services_pages.healthcare.dashboard_alert_1_desc') }}</span>
                                    <span class="alert-time">{{ __('services_pages.healthcare.dashboard_alert_1_time') }}</span>
                                </div>
                                <button class="alert-action">{{ __('services_pages.healthcare.dashboard_alert_1_action') }}</button>
                            </div>

                            <div class="alert-item priority-high">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-content">
                                    <span class="alert-title">{{ __('services_pages.healthcare.dashboard_alert_2_title') }}</span>
                                    <span class="alert-description">{{ __('services_pages.healthcare.dashboard_alert_2_desc') }}</span>
                                    <span class="alert-time">{{ __('services_pages.healthcare.dashboard_alert_2_time') }}</span>
                                </div>
                                <button class="alert-action">{{ __('services_pages.healthcare.dashboard_alert_2_action') }}</button>
                            </div>

                            <div class="alert-item priority-low">
                                <div class="alert-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="alert-content">
                                    <span class="alert-title">{{ __('services_pages.healthcare.dashboard_alert_3_title') }}</span>
                                    <span class="alert-description">{{ __('services_pages.healthcare.dashboard_alert_3_desc') }}</span>
                                    <span class="alert-time">{{ __('services_pages.healthcare.dashboard_alert_3_time') }}</span>
                                </div>
                                <button class="alert-action">{{ __('services_pages.healthcare.dashboard_alert_3_action') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="care-team">
                        <h4><i class="fas fa-users"></i> {{ __('services_pages.healthcare.care_team_title') }}</h4>
                        <div class="team-members">
                            <div class="team-member primary">
                                <div class="member-avatar">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div class="member-info">
                                    <span class="member-name">{{ __('services_pages.healthcare.care_member_1_name') }}</span>
                                    <span class="member-role">{{ __('services_pages.healthcare.care_member_1_role') }}</span>
                                    <span class="member-status online">{{ __('services_pages.healthcare.care_member_1_status') }}</span>
                                </div>
                                <button class="contact-btn">{{ __('services_pages.healthcare.care_member_1_action') }}</button>
                            </div>

                            <div class="team-member">
                                <div class="member-avatar">
                                    <i class="fas fa-user-nurse"></i>
                                </div>
                                <div class="member-info">
                                    <span class="member-name">{{ __('services_pages.healthcare.care_member_2_name') }}</span>
                                    <span class="member-role">{{ __('services_pages.healthcare.care_member_2_role') }}</span>
                                    <span class="member-status">{{ __('services_pages.healthcare.care_member_2_status') }}</span>
                                </div>
                                <button class="contact-btn">{{ __('services_pages.healthcare.care_member_2_action') }}</button>
                            </div>

                            <div class="team-member">
                                <div class="member-avatar">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="member-info">
                                    <span class="member-name">{{ __('services_pages.healthcare.care_member_3_name') }}</span>
                                    <span class="member-role">{{ __('services_pages.healthcare.care_member_3_role') }}</span>
                                    <span class="member-status">{{ __('services_pages.healthcare.care_member_3_status') }}</span>
                                </div>
                                <button class="contact-btn">{{ __('services_pages.healthcare.care_member_3_action') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-benefits">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>{{ __('services_pages.healthcare.benefit_1_title') }}</h4>
                        <p>{{ __('services_pages.healthcare.benefit_1_desc') }}</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4>{{ __('services_pages.healthcare.benefit_2_title') }}</h4>
                        <p>{{ __('services_pages.healthcare.benefit_2_desc') }}</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>{{ __('services_pages.healthcare.benefit_3_title') }}</h4>
                        <p>{{ __('services_pages.healthcare.benefit_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="how-it-works-service">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.healthcare.how_title') }}</h2>
                    <p>{{ __('services_pages.healthcare.how_subtitle') }}</p>
                </div>

                <div class="process-steps">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>{{ __('services_pages.healthcare.step_1_title') }}</h3>
                            <p>{{ __('services_pages.healthcare.step_1_desc') }}</p>
                            <div class="step-duration">{{ __('services_pages.healthcare.step_1_duration') }}</div>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>{{ __('services_pages.healthcare.step_2_title') }}</h3>
                            <p>{{ __('services_pages.healthcare.step_2_desc') }}</p>
                            <div class="step-duration">{{ __('services_pages.healthcare.step_2_duration') }}</div>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>{{ __('services_pages.healthcare.step_3_title') }}</h3>
                            <p>{{ __('services_pages.healthcare.step_3_desc') }}</p>
                            <div class="step-duration">{{ __('services_pages.healthcare.step_3_duration') }}</div>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>{{ __('services_pages.healthcare.step_4_title') }}</h3>
                            <p>{{ __('services_pages.healthcare.step_4_desc') }}</p>
                            <div class="step-duration">{{ __('services_pages.healthcare.step_4_duration') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="faq-section">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('services_pages.common.faq_title') }}</h2>
                    <p>{{ __('services_pages.healthcare.faq_subtitle') }}</p>
                </div>

                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.healthcare.faq_1_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.healthcare.faq_1_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.healthcare.faq_2_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.healthcare.faq_2_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.healthcare.faq_3_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.healthcare.faq_3_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.healthcare.faq_4_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.healthcare.faq_4_a') }}</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>{{ __('services_pages.healthcare.faq_5_q') }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>{{ __('services_pages.healthcare.faq_5_a') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>{{ __('services_pages.healthcare.cta_title') }}</h2>
                    <p>{{ __('services_pages.healthcare.cta_subtitle') }}</p>

                    <div class="cta-features">
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.healthcare.cta_feature_1') }}</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.healthcare.cta_feature_2') }}</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-check"></i>
                            <span>{{ __('services_pages.healthcare.cta_feature_3') }}</span>
                        </div>
                    </div>

                    <div class="cta-actions">
                        <a href="/index.html#contact-form" class="btn btn-primary btn-large">{{ __('services_pages.common.select_plan') }} {{ __('ui.header.service_healthcare') }}</a>
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
