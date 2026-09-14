<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('index.meta.title') }}</title>
    <meta name="description" content="{{ __('index.meta.description') }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ __('index.meta.og_title') }}">
    <meta property="og:description" content="{{ __('index.meta.og_description') }}">
    <meta property="og:type" content="website">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header', ['active' => 'index'])

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1>{{ __('index.hero.title') }}</h1>
                        <p class="hero-subtitle">{{ __('index.hero.subtitle') }}</p>

                        <div class="hero-actions">
                            <a href="#contact-form" class="btn btn-primary btn-large">{{ __('index.hero.cta_primary') }}</a>
                            <a href="for-companies.html" class="btn btn-outline btn-large">{{ __('index.hero.cta_secondary') }}</a>
                        </div>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">92%</div>
                            <div class="stat-label">{{ __('index.hero.stat_1') }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">70+</div>
                            <div class="stat-label">{{ __('index.hero.stat_2') }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">14</div>
                            <div class="stat-label">{{ __('index.hero.stat_3') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.services.title') }}</h2>
                    <p>{{ __('index.services.subtitle') }}</p>
                </div>

                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>Healthcare</h3>
                        <p class="service-price">{{ __('index.services.healthcare.price') }}</p>
                        <p class="service-description">{{ __('index.services.healthcare.description') }}</p>
                        <ul class="service-features">
                            <li>{{ __('index.services.healthcare.feature_1') }}</li>
                            <li>{{ __('index.services.healthcare.feature_2') }}</li>
                            <li>{{ __('index.services.healthcare.feature_3') }}</li>
                            <li>{{ __('index.services.healthcare.feature_4') }}</li>
                            <li>{{ __('index.services.healthcare.feature_5') }}</li>
                        </ul>
                        <a href="services/healthcare.html" class="btn btn-primary">{{ __('index.common.learn_more') }}</a>
                    </div>

                    <div class="service-card featured">
                        <div class="service-badge">{{ __('index.services.ambulance.badge') }}</div>
                        <div class="service-icon">
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <h3>Ambulance</h3>
                        <p class="service-price">{{ __('index.services.ambulance.price') }}</p>
                        <p class="service-description">{{ __('index.services.ambulance.description') }}</p>
                        <ul class="service-features">
                            <li>{{ __('index.services.ambulance.feature_1') }}</li>
                            <li>{{ __('index.services.ambulance.feature_2') }}</li>
                            <li>{{ __('index.services.ambulance.feature_3') }}</li>
                            <li>{{ __('index.services.ambulance.feature_4') }}</li>
                            <li>{{ __('index.services.ambulance.feature_5') }}</li>
                        </ul>
                        <a href="services/ambulance.html" class="btn btn-primary">{{ __('index.common.learn_more') }}</a>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3>HealthCheckup</h3>
                        <p class="service-price">{{ __('index.services.checkup.price') }}</p>
                        <p class="service-description">{{ __('index.services.checkup.description') }}</p>
                        <ul class="service-features">
                            <li>{{ __('index.services.checkup.feature_1') }}</li>
                            <li>{{ __('index.services.checkup.feature_2') }}</li>
                            <li>{{ __('index.services.checkup.feature_3') }}</li>
                            <li>{{ __('index.services.checkup.feature_4') }}</li>
                            <li>{{ __('index.services.checkup.feature_5') }}</li>
                        </ul>
                        <a href="services/checkup.html" class="btn btn-primary">{{ __('index.common.learn_more') }}</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="how-it-works">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.how_it_works.title') }}</h2>
                    <p>{{ __('index.how_it_works.subtitle') }}</p>
                </div>

                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>{{ __('index.how_it_works.step_1_title') }}</h3>
                            <p>{{ __('index.how_it_works.step_1_desc') }}</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>{{ __('index.how_it_works.step_2_title') }}</h3>
                            <p>{{ __('index.how_it_works.step_2_desc') }}</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>{{ __('index.how_it_works.step_3_title') }}</h3>
                            <p>{{ __('index.how_it_works.step_3_desc') }}</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>{{ __('index.how_it_works.step_4_title') }}</h3>
                            <p>{{ __('index.how_it_works.step_4_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Health Monitoring Section -->
        <section class="health-monitoring">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.monitoring.title') }}</h2>
                    <p>{{ __('index.monitoring.subtitle') }}</p>
                </div>

                <div class="monitoring-dashboard">
                    <div class="monitoring-intro">
                        <h3>{{ __('index.monitoring.intro_title') }}</h3>
                        <p>{{ __('index.monitoring.intro_text') }}</p>

                        <div class="monitoring-benefits">
                            <div class="benefit-point">
                                <i class="fas fa-shield-alt"></i>
                                <span>{{ __('index.monitoring.benefit_1') }}</span>
                            </div>
                            <div class="benefit-point">
                                <i class="fas fa-bell"></i>
                                <span>{{ __('index.monitoring.benefit_2') }}</span>
                            </div>
                            <div class="benefit-point">
                                <i class="fas fa-chart-line"></i>
                                <span>{{ __('index.monitoring.benefit_3') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="health-metrics-demo">
                        <div class="metrics-header">
                            <h4>{{ __('index.monitoring.sample_report') }}</h4>
                            <span class="live-indicator">
                                <span class="pulse-dot"></span>
                                {{ __('index.monitoring.live_monitoring') }}
                            </span>
                        </div>

                        <div class="metrics-grid">
                            <div class="metric-card strain">
                                <div class="metric-header">
                                    <span class="metric-label">{{ __('index.monitoring.metrics.strain.label') }}</span>
                                    <span class="metric-status optimal">{{ __('index.monitoring.metrics.strain.status') }}</span>
                                </div>
                                <div class="metric-visual">
                                    <div class="circular-progress">
                                        <svg width="80" height="80">
                                            <circle cx="40" cy="40" r="35" fill="none" stroke="#e5e5e5" stroke-width="6"/>
                                            <circle cx="40" cy="40" r="35" fill="none" stroke="#10b981" stroke-width="6"
                                                    stroke-dasharray="220" stroke-dashoffset="66"
                                                    stroke-linecap="round" transform="rotate(-90 40 40)"/>
                                        </svg>
                                        <div class="metric-value">14.2</div>
                                    </div>
                                </div>
                                <div class="metric-insights">
                                    <p>{{ __('index.monitoring.metrics.strain.insight') }}</p>
                                </div>
                            </div>

                            <div class="metric-card recovery">
                                <div class="metric-header">
                                    <span class="metric-label">{{ __('index.monitoring.metrics.recovery.label') }}</span>
                                    <span class="metric-status good">{{ __('index.monitoring.metrics.recovery.status') }}</span>
                                </div>
                                <div class="metric-visual">
                                    <div class="recovery-bar">
                                        <div class="recovery-fill" style="width: 78%"></div>
                                        <span class="recovery-percentage">78%</span>
                                    </div>
                                </div>
                                <div class="metric-insights">
                                    <p>{{ __('index.monitoring.metrics.recovery.insight') }}</p>
                                </div>
                            </div>

                            <div class="metric-card sleep">
                                <div class="metric-header">
                                    <span class="metric-label">{{ __('index.monitoring.metrics.sleep.label') }}</span>
                                    <span class="metric-status excellent">{{ __('index.monitoring.metrics.sleep.status') }}</span>
                                </div>
                                <div class="metric-visual">
                                    <div class="sleep-chart">
                                        <div class="sleep-stages">
                                            <div class="stage deep" style="height: 45%; width: 20%"></div>
                                            <div class="stage light" style="height: 30%; width: 25%"></div>
                                            <div class="stage rem" style="height: 60%; width: 22%"></div>
                                            <div class="stage light" style="height: 35%; width: 18%"></div>
                                            <div class="stage awake" style="height: 10%; width: 15%"></div>
                                        </div>
                                        <div class="sleep-duration">{{ __('index.monitoring.metrics.sleep.duration') }}</div>
                                    </div>
                                </div>
                                <div class="metric-insights">
                                    <p>{{ __('index.monitoring.metrics.sleep.insight') }}</p>
                                </div>
                            </div>

                            <div class="metric-card hrv">
                                <div class="metric-header">
                                    <span class="metric-label">{{ __('index.monitoring.metrics.hrv.label') }}</span>
                                    <span class="metric-status normal">{{ __('index.monitoring.metrics.hrv.status') }}</span>
                                </div>
                                <div class="metric-visual">
                                    <div class="hrv-trend">
                                        <svg width="120" height="60">
                                            <polyline points="0,45 15,42 30,38 45,35 60,32 75,30 90,33 105,35 120,38"
                                                      fill="none" stroke="#003d82" stroke-width="2"/>
                                            <circle cx="120" cy="38" r="3" fill="#003d82"/>
                                        </svg>
                                        <div class="hrv-value">52ms</div>
                                    </div>
                                </div>
                                <div class="metric-insights">
                                    <p>{{ __('index.monitoring.metrics.hrv.insight') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="ai-recommendations">
                            <div class="ai-header">
                                <i class="fas fa-robot"></i>
                                <h4>{{ __('index.monitoring.ai_title') }}</h4>
                            </div>
                            <div class="recommendations-list">
                                <div class="recommendation priority-high">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ __('index.monitoring.ai_rec_1') }}</span>
                                </div>
                                <div class="recommendation priority-medium">
                                    <i class="fas fa-info-circle"></i>
                                    <span>{{ __('index.monitoring.ai_rec_2') }}</span>
                                </div>
                                <div class="recommendation priority-low">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>{{ __('index.monitoring.ai_rec_3') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="monitoring-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h4>{{ __('index.monitoring.features.feature_1_title') }}</h4>
                        <p>{{ __('index.monitoring.features.feature_1_desc') }}</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>{{ __('index.monitoring.features.feature_2_title') }}</h4>
                        <p>{{ __('index.monitoring.features.feature_2_desc') }}</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h4>{{ __('index.monitoring.features.feature_3_title') }}</h4>
                        <p>{{ __('index.monitoring.features.feature_3_desc') }}</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>{{ __('index.monitoring.features.feature_4_title') }}</h4>
                        <p>{{ __('index.monitoring.features.feature_4_desc') }}</p>
                    </div>
                </div>

                <div class="monitoring-cta">
                    <div class="cta-content">
                        <h3>{{ __('index.monitoring.cta_title') }}</h3>
                        <p>{{ __('index.monitoring.cta_subtitle') }}</p>
                        <a href="#contact-form" class="btn btn-primary btn-large">{{ __('index.monitoring.cta_button') }}</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Responsibility Section -->
        <section class="responsibility-section">
            <div class="container">
                <div class="responsibility-content">
                    <div class="responsibility-text">
                        <h2>{{ __('index.responsibility.title') }}</h2>
                        <p class="responsibility-subtitle">{{ __('index.responsibility.subtitle') }}</p>

                        <div class="responsibility-promises">
                            <div class="promise-item">
                                <div class="promise-number">01</div>
                                <div class="promise-content">
                                    <h3>{{ __('index.responsibility.promise_1_title') }}</h3>
                                    <p>{{ __('index.responsibility.promise_1_desc') }}</p>
                                </div>
                            </div>

                            <div class="promise-item">
                                <div class="promise-number">02</div>
                                <div class="promise-content">
                                    <h3>{{ __('index.responsibility.promise_2_title') }}</h3>
                                    <p>{{ __('index.responsibility.promise_2_desc') }}</p>
                                </div>
                            </div>

                            <div class="promise-item">
                                <div class="promise-number">03</div>
                                <div class="promise-content">
                                    <h3>{{ __('index.responsibility.promise_3_title') }}</h3>
                                    <p>{{ __('index.responsibility.promise_3_desc') }}</p>
                                </div>
                            </div>

                            <div class="promise-item">
                                <div class="promise-number">04</div>
                                <div class="promise-content">
                                    <h3>{{ __('index.responsibility.promise_4_title') }}</h3>
                                    <p>{{ __('index.responsibility.promise_4_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="responsibility-visual">
                        <div class="care-circle">
                            <div class="patient-center">
                                <i class="fas fa-user"></i>
                                <span>{{ __('index.responsibility.visual_you') }}</span>
                            </div>

                            <div class="care-layer doctor">
                                <div class="care-item">
                                    <i class="fas fa-user-md"></i>
                                    <span>{{ __('index.responsibility.visual_curator') }}</span>
                                </div>
                            </div>

                            <div class="care-layer monitoring">
                                <div class="care-item">
                                    <i class="fas fa-heartbeat"></i>
                                    <span>{{ __('index.responsibility.visual_monitoring') }}</span>
                                </div>
                            </div>

                            <div class="care-layer ai">
                                <div class="care-item">
                                    <i class="fas fa-robot"></i>
                                    <span>{{ __('index.responsibility.visual_ai') }}</span>
                                </div>
                            </div>

                            <div class="care-layer team">
                                <div class="care-item">
                                    <i class="fas fa-users"></i>
                                    <span>{{ __('index.responsibility.visual_team') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="protection-badge">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>{{ __('index.responsibility.protection_title') }}</strong>
                                <span>{{ __('index.responsibility.protection_subtitle') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Evidence Section -->
        <section class="evidence">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.evidence.title') }}</h2>
                    <p>{{ __('index.evidence.subtitle') }}</p>
                </div>

                <div class="evidence-stats">
                    <div class="evidence-stat">
                        <div class="stat-number">68%</div>
                        <div class="stat-description">{{ __('index.evidence.stat_1') }}</div>
                    </div>
                    <div class="evidence-stat">
                        <div class="stat-number">43%</div>
                        <div class="stat-description">{{ __('index.evidence.stat_2') }}</div>
                    </div>
                    <div class="evidence-stat">
                        <div class="stat-number">38%</div>
                        <div class="stat-description">{{ __('index.evidence.stat_3') }}</div>
                    </div>
                </div>

                <div class="certifications">
                    <h3>{{ __('index.evidence.standards') }}</h3>
                    <div class="cert-badges">
                        <div class="cert-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>HIPAA</span>
                        </div>
                        <div class="cert-badge">
                            <i class="fas fa-certificate"></i>
                            <span>GDPR</span>
                        </div>
                        <div class="cert-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>ISO 27001</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Preview Section -->
        <section class="blog-preview">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.blog_preview.title') }}</h2>
                    <p>{{ __('index.blog_preview.subtitle') }}</p>
                </div>

                <div class="blog-posts-preview">
                    <article class="blog-preview-card">
                        <div class="blog-preview-meta">
                            <span class="post-category cardiology">{{ __('index.blog_preview.post_1.category') }}</span>
                            <span class="post-date">{{ __('index.blog_preview.post_1.date') }}</span>
                        </div>
                        <h3><a href="blog/managing-hypertension-2024.html">{{ __('index.blog_preview.post_1.title') }}</a></h3>
                        <p>{{ __('index.blog_preview.post_1.excerpt') }}</p>
                        <div class="blog-preview-author">
                            <span>{{ __('index.blog_preview.post_1.author') }}</span>
                        </div>
                    </article>

                    <article class="blog-preview-card">
                        <div class="blog-preview-meta">
                            <span class="post-category prevention">{{ __('index.blog_preview.post_2.category') }}</span>
                            <span class="post-date">{{ __('index.blog_preview.post_2.date') }}</span>
                        </div>
                        <h3><a href="blog/diabetes-prevention-guide.html">{{ __('index.blog_preview.post_2.title') }}</a></h3>
                        <p>{{ __('index.blog_preview.post_2.excerpt') }}</p>
                        <div class="blog-preview-author">
                            <span>{{ __('index.blog_preview.post_2.author') }}</span>
                        </div>
                    </article>

                    <article class="blog-preview-card">
                        <div class="blog-preview-meta">
                            <span class="post-category mental-health">{{ __('index.blog_preview.post_3.category') }}</span>
                            <span class="post-date">{{ __('index.blog_preview.post_3.date') }}</span>
                        </div>
                        <h3><a href="blog/stress-management-techniques.html">{{ __('index.blog_preview.post_3.title') }}</a></h3>
                        <p>{{ __('index.blog_preview.post_3.excerpt') }}</p>
                        <div class="blog-preview-author">
                            <span>{{ __('index.blog_preview.post_3.author') }}</span>
                        </div>
                    </article>
                </div>

                <div class="blog-preview-actions">
                    <a href="blog.html" class="btn btn-outline">{{ __('index.blog_preview.all_articles') }}</a>
                </div>
            </div>
        </section>

        <!-- Partners Section -->
        <section class="partners">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.partners.title') }}</h2>
                    <p>{{ __('index.partners.subtitle') }}</p>
                </div>

                <div class="partners-info">
                    <div class="partner-types">
                        <div class="partner-type">
                            <h3>{{ __('index.partners.item_1_title') }}</h3>
                            <p>{{ __('index.partners.item_1_desc') }}</p>
                        </div>
                        <div class="partner-type">
                            <h3>{{ __('index.partners.item_2_title') }}</h3>
                            <p>{{ __('index.partners.item_2_desc') }}</p>
                        </div>
                        <div class="partner-type">
                            <h3>{{ __('index.partners.item_3_title') }}</h3>
                            <p>{{ __('index.partners.item_3_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>{{ __('index.final_cta.title') }}</h2>
                    <p>{{ __('index.final_cta.subtitle') }}</p>
                    <div class="cta-actions">
                        <a href="#contact-form" class="btn btn-primary btn-large">{{ __('index.final_cta.primary') }}</a>
                        <a href="pricing.html" class="btn btn-outline btn-large">{{ __('index.final_cta.secondary') }}</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section id="contact-form" class="contact-form-section">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('index.contact.title') }}</h2>
                    <p>{{ __('index.contact.subtitle') }}</p>
                </div>

                <div class="form-container">
                    <form class="contact-form" id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">{{ __('index.contact.first_name') }}</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">{{ __('index.contact.last_name') }}</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">{{ __('index.contact.email') }}</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('index.contact.phone') }}</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="service">{{ __('index.contact.service') }}</label>
                            <select id="service" name="service" required>
                                <option value="">{{ __('index.contact.service_placeholder') }}</option>
                                <option value="healthcare">{{ __('ui.header.service_healthcare') }}</option>
                                <option value="ambulance">{{ __('ui.header.service_ambulance') }}</option>
                                <option value="checkup">{{ __('ui.header.service_checkup') }}</option>
                                <option value="consultation">{{ __('index.contact.service_consultation') }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">{{ __('index.contact.message') }}</label>
                            <textarea id="message" name="message" rows="4" placeholder="{{ __('index.contact.message_placeholder') }}"></textarea>
                        </div>

                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="privacy" name="privacy" required>
                            <label for="privacy">{{ __('index.contact.privacy_prefix') }} <a href="/privacy" target="_blank">{{ __('index.contact.privacy_link') }}</a> {{ __('index.contact.privacy_suffix') }}</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-large">{{ __('index.contact.submit') }}</button>
                    </form>

                    <div class="contact-info">
                        <h3>{{ __('index.contact.contact_info_title') }}</h3>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>bodyhealthmediclinic@gmail.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+38 (096) 267-50-52</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ __('index.contact.support_24_7') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer', [
        'footerExtraLegalLines' => [__('index.footer.compliance')],
        'showFooterSocial' => true,
    ])

    <!-- JavaScript -->
    <script>
        window.bodyHealthI18n = {
            contactFormSending: @json(__('ui.js.contact_form_sending')),
            contactFormSuccess: @json(__('ui.js.contact_form_success')),
            contactFormInvalidFirstName: @json(__('ui.js.contact_form_invalid_first_name')),
            contactFormInvalidLastName: @json(__('ui.js.contact_form_invalid_last_name')),
            contactFormInvalidEmail: @json(__('ui.js.contact_form_invalid_email')),
            contactFormMissingService: @json(__('ui.js.contact_form_missing_service')),
            contactFormMissingPrivacy: @json(__('ui.js.contact_form_missing_privacy')),
            contactFormInvalidPhone: @json(__('ui.js.contact_form_invalid_phone'))
        };
    </script>
    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
</body>
</html>
