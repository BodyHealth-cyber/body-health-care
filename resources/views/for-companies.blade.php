<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('for_companies.meta.title') }}</title>
    <meta name="description" content="{{ __('for_companies.meta.description') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body class="for-companies-page">
    @include('partials.header', ['active' => 'for-companies'])

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="b2b-hero">
            <div class="container">
                <div class="b2b-hero-content">
                    <div class="hero-text">
                        <h1>{{ __('for_companies.hero.title') }}</h1>
                        <p class="hero-subtitle">{{ __('for_companies.hero.subtitle') }}</p>
                        
                        <div class="hero-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-chart-line"></i>
                                <span>{{ __('for_companies.hero.benefit_1') }}</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-users"></i>
                                <span>{{ __('for_companies.hero.benefit_2') }}</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-rocket"></i>
                                <span>{{ __('for_companies.hero.benefit_3') }}</span>
                            </div>
                        </div>
                        
                        <div class="hero-actions">
                            <a href="#b2b-form" class="btn btn-primary btn-large b2b-quote-btn">{{ __('for_companies.hero.cta_quote') }}</a>
                            <a href="#demo" class="btn btn-outline btn-large">{{ __('for_companies.hero.cta_demo') }}</a>
                        </div>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="stat-card">
                            <div class="stat-number">1,800+</div>
                            <div class="stat-label">{{ __('for_companies.hero.stat_1') }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">{{ __('for_companies.hero.stat_2') }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">$112K</div>
                            <div class="stat-label">{{ __('for_companies.hero.stat_3') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problem & Solution -->
        <section class="problem-solution">
            <div class="container">
                <div class="content-split">
                    <div class="problem-section">
                        <h2>{{ __('for_companies.problem_solution.problem_title') }}</h2>
                        <div class="problem-list">
                            <div class="problem-item">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.problem_1_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.problem_1_desc') }}</p>
                                </div>
                            </div>
                            <div class="problem-item">
                                <i class="fas fa-bed"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.problem_2_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.problem_2_desc') }}</p>
                                </div>
                            </div>
                            <div class="problem-item">
                                <i class="fas fa-chart-line-down"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.problem_3_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.problem_3_desc') }}</p>
                                </div>
                            </div>
                            <div class="problem-item">
                                <i class="fas fa-user-times"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.problem_4_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.problem_4_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="solution-section">
                        <h2>{{ __('for_companies.problem_solution.solution_title') }}</h2>
                        <div class="solution-list">
                            <div class="solution-item">
                                <i class="fas fa-shield-alt"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.solution_1_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.solution_1_desc') }}</p>
                                </div>
                            </div>
                            <div class="solution-item">
                                <i class="fas fa-heartbeat"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.solution_2_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.solution_2_desc') }}</p>
                                </div>
                            </div>
                            <div class="solution-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.solution_3_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.solution_3_desc') }}</p>
                                </div>
                            </div>
                            <div class="solution-item">
                                <i class="fas fa-chart-bar"></i>
                                <div>
                                    <h3>{{ __('for_companies.problem_solution.solution_4_title') }}</h3>
                                    <p>{{ __('for_companies.problem_solution.solution_4_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Corporate Programs -->
        <section class="corporate-programs">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('for_companies.sections.corporate_programs_title') }}</h2>
                    <p>{{ __('for_companies.sections.corporate_programs_subtitle') }}</p>
                </div>
                
                <div class="programs-grid">
                    <div class="program-card">
                        <div class="program-header">
                            <h3>{{ __('for_companies.programs.base.name') }}</h3>
                            <p class="program-price">{{ __('for_companies.programs.base.price') }} <span>{{ __('for_companies.programs.base.period') }}</span></p>
                            <p class="program-subtitle">{{ __('for_companies.programs.base.subtitle') }}</p>
                        </div>
                        <div class="program-features">
                            <div class="feature-category">
                                <h4>{{ __('for_companies.programs.base.included') }}</h4>
                                <ul>
                                    <li>{{ __('for_companies.programs.base.feature_1') }}</li>
                                    <li>{{ __('for_companies.programs.base.feature_2') }}</li>
                                    <li>{{ __('for_companies.programs.base.feature_3') }}</li>
                                    <li>{{ __('for_companies.programs.base.feature_4') }}</li>
                                    <li>{{ __('for_companies.programs.base.feature_5') }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="program-footer">
                            <p class="min-users">{{ __('for_companies.programs.base.min_users') }}</p>
                            <a href="#b2b-form" class="btn btn-outline">{{ __('for_companies.common.learn_more') }}</a>
                        </div>
                    </div>
                    
                    <div class="program-card featured">
                        <div class="program-badge">{{ __('for_companies.common.popular') }}</div>
                        <div class="program-header">
                            <h3>{{ __('for_companies.programs.pro.name') }}</h3>
                            <p class="program-price">{{ __('for_companies.programs.pro.price') }} <span>{{ __('for_companies.programs.pro.period') }}</span></p>
                            <p class="program-subtitle">{{ __('for_companies.programs.pro.subtitle') }}</p>
                        </div>
                        <div class="program-features">
                            <div class="feature-category">
                                <h4>{{ __('for_companies.programs.pro.included') }}</h4>
                                <ul>
                                    <li>{{ __('for_companies.programs.pro.feature_1') }}</li>
                                    <li>{{ __('for_companies.programs.pro.feature_2') }}</li>
                                    <li>{{ __('for_companies.programs.pro.feature_3') }}</li>
                                    <li>{{ __('for_companies.programs.pro.feature_4') }}</li>
                                    <li>{{ __('for_companies.programs.pro.feature_5') }}</li>
                                    <li>{{ __('for_companies.programs.pro.feature_6') }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="program-footer">
                            <p class="min-users">{{ __('for_companies.programs.pro.min_users') }}</p>
                            <a href="#b2b-form" class="btn btn-primary">{{ __('for_companies.common.learn_more') }}</a>
                        </div>
                    </div>
                    
                    <div class="program-card">
                        <div class="program-header">
                            <h3>{{ __('for_companies.programs.enterprise.name') }}</h3>
                            <p class="program-price">{{ __('for_companies.programs.enterprise.price') }}</p>
                            <p class="program-subtitle">{{ __('for_companies.programs.enterprise.subtitle') }}</p>
                        </div>
                        <div class="program-features">
                            <div class="feature-category">
                                <h4>{{ __('for_companies.programs.enterprise.included') }}</h4>
                                <ul>
                                    <li>{{ __('for_companies.programs.enterprise.feature_1') }}</li>
                                    <li>{{ __('for_companies.programs.enterprise.feature_2') }}</li>
                                    <li>{{ __('for_companies.programs.enterprise.feature_3') }}</li>
                                    <li>{{ __('for_companies.programs.enterprise.feature_4') }}</li>
                                    <li>{{ __('for_companies.programs.enterprise.feature_5') }}</li>
                                    <li>{{ __('for_companies.programs.enterprise.feature_6') }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="program-footer">
                            <p class="min-users">{{ __('for_companies.programs.enterprise.min_users') }}</p>
                            <a href="#b2b-form" class="btn btn-outline">{{ __('for_companies.common.discuss') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ROI & Benefits -->
        <section class="roi-benefits">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('for_companies.sections.roi_title') }}</h2>
                    <p>{{ __('for_companies.sections.roi_subtitle') }}</p>
                </div>
                
                <div class="roi-grid">
                    <div class="roi-item">
                        <div class="roi-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3>{{ __('for_companies.roi.item_1_title') }}</h3>
                        <div class="roi-stat">{{ __('for_companies.roi.item_1_stat') }}</div>
                        <p>{{ __('for_companies.roi.item_1_desc') }}</p>
                    </div>
                    
                    <div class="roi-item">
                        <div class="roi-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h3>{{ __('for_companies.roi.item_2_title') }}</h3>
                        <div class="roi-stat">{{ __('for_companies.roi.item_2_stat') }}</div>
                        <p>{{ __('for_companies.roi.item_2_desc') }}</p>
                    </div>
                    
                    <div class="roi-item">
                        <div class="roi-icon">
                            <i class="fas fa-trending-up"></i>
                        </div>
                        <h3>{{ __('for_companies.roi.item_3_title') }}</h3>
                        <div class="roi-stat">{{ __('for_companies.roi.item_3_stat') }}</div>
                        <p>{{ __('for_companies.roi.item_3_desc') }}</p>
                    </div>
                    
                    <div class="roi-item">
                        <div class="roi-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h3>{{ __('for_companies.roi.item_4_title') }}</h3>
                        <div class="roi-stat">{{ __('for_companies.roi.item_4_stat') }}</div>
                        <p>{{ __('for_companies.roi.item_4_desc') }}</p>
                    </div>
                    
                    <div class="roi-item">
                        <div class="roi-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>{{ __('for_companies.roi.item_5_title') }}</h3>
                        <div class="roi-stat">{{ __('for_companies.roi.item_5_stat') }}</div>
                        <p>{{ __('for_companies.roi.item_5_desc') }}</p>
                    </div>
                    
                    <div class="roi-item">
                        <div class="roi-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>{{ __('for_companies.roi.item_6_title') }}</h3>
                        <div class="roi-stat">{{ __('for_companies.roi.item_6_stat') }}</div>
                        <p>{{ __('for_companies.roi.item_6_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Integration -->
        <section class="integration">
            <div class="container">
                <div class="integration-content">
                    <div class="integration-text">
                        <h2>{{ __('for_companies.sections.integration_title') }}</h2>
                        <p>{{ __('for_companies.sections.integration_subtitle') }}</p>
                        
                        <div class="integration-features">
                            <div class="integration-feature">
                                <i class="fas fa-plug"></i>
                                <div>
                                    <h4>{{ __('for_companies.integration.feature_1_title') }}</h4>
                                    <p>{{ __('for_companies.integration.feature_1_desc') }}</p>
                                </div>
                            </div>
                            <div class="integration-feature">
                                <i class="fas fa-shield-alt"></i>
                                <div>
                                    <h4>{{ __('for_companies.integration.feature_2_title') }}</h4>
                                    <p>{{ __('for_companies.integration.feature_2_desc') }}</p>
                                </div>
                            </div>
                            <div class="integration-feature">
                                <i class="fas fa-chart-bar"></i>
                                <div>
                                    <h4>{{ __('for_companies.integration.feature_3_title') }}</h4>
                                    <p>{{ __('for_companies.integration.feature_3_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="integration-logos">
                        <h3>{{ __('for_companies.sections.integrations_label') }}</h3>
                        <div class="logos-grid">
                            <div class="logo-item">
                                <i class="fab fa-microsoft"></i>
                                <span>Microsoft 365</span>
                            </div>
                            <div class="logo-item">
                                <i class="fab fa-google"></i>
                                <span>Google Workspace</span>
                            </div>
                            <div class="logo-item">
                                <i class="fas fa-users-cog"></i>
                                <span>Workday</span>
                            </div>
                            <div class="logo-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Salesforce</span>
                            </div>
                            <div class="logo-item">
                                <i class="fas fa-slack"></i>
                                <span>Slack</span>
                            </div>
                            <div class="logo-item">
                                <i class="fas fa-plus"></i>
                                <span>{{ __('for_companies.common.and_more') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Case Studies -->
        <section class="case-studies">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('for_companies.sections.cases_title') }}</h2>
                    <p>{{ __('for_companies.sections.cases_subtitle') }}</p>
                </div>
                
                <div class="cases-grid">
                    <div class="case-item">
                        <div class="case-header">
                            <div class="case-company">{{ __('for_companies.cases.case_1_company') }}</div>
                            <div class="case-industry">{{ __('for_companies.cases.case_1_industry') }}</div>
                        </div>
                        <h3>{{ __('for_companies.cases.case_1_title') }}</h3>
                        <div class="case-results">
                            <div class="case-stat">
                                <span class="stat-number">45%</span>
                                <span class="stat-label">{{ __('for_companies.cases.case_1_stat_1') }}</span>
                            </div>
                            <div class="case-stat">
                                <span class="stat-number">30%</span>
                                <span class="stat-label">{{ __('for_companies.cases.case_1_stat_2') }}</span>
                            </div>
                        </div>
                        <p>{{ __('for_companies.cases.case_1_desc') }}</p>
                    </div>
                    
                    <div class="case-item">
                        <div class="case-header">
                            <div class="case-company">{{ __('for_companies.cases.case_2_company') }}</div>
                            <div class="case-industry">{{ __('for_companies.cases.case_2_industry') }}</div>
                        </div>
                        <h3>{{ __('for_companies.cases.case_2_title') }}</h3>
                        <div class="case-results">
                            <div class="case-stat">
                                <span class="stat-number">60%</span>
                                <span class="stat-label">{{ __('for_companies.cases.case_2_stat_1') }}</span>
                            </div>
                            <div class="case-stat">
                                <span class="stat-number">$2.1M</span>
                                <span class="stat-label">{{ __('for_companies.cases.case_2_stat_2') }}</span>
                            </div>
                        </div>
                        <p>{{ __('for_companies.cases.case_2_desc') }}</p>
                    </div>
                    
                    <div class="case-item">
                        <div class="case-header">
                            <div class="case-company">{{ __('for_companies.cases.case_3_company') }}</div>
                            <div class="case-industry">{{ __('for_companies.cases.case_3_industry') }}</div>
                        </div>
                        <h3>{{ __('for_companies.cases.case_3_title') }}</h3>
                        <div class="case-results">
                            <div class="case-stat">
                                <span class="stat-number">55%</span>
                                <span class="stat-label">{{ __('for_companies.cases.case_3_stat_1') }}</span>
                            </div>
                            <div class="case-stat">
                                <span class="stat-number">$850K</span>
                                <span class="stat-label">{{ __('for_companies.cases.case_3_stat_2') }}</span>
                            </div>
                        </div>
                        <p>{{ __('for_companies.cases.case_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Implementation Process -->
        <section class="implementation">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('for_companies.sections.implementation_title') }}</h2>
                    <p>{{ __('for_companies.sections.implementation_subtitle') }}</p>
                </div>
                
                <div class="implementation-timeline">
                    <div class="timeline-item">
                        <div class="timeline-step">1</div>
                        <div class="timeline-content">
                            <h3>{{ __('for_companies.implementation.step_1_title') }}</h3>
                            <p>{{ __('for_companies.implementation.step_1_desc') }}</p>
                            <div class="timeline-duration">{{ __('for_companies.implementation.step_1_duration') }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-step">2</div>
                        <div class="timeline-content">
                            <h3>{{ __('for_companies.implementation.step_2_title') }}</h3>
                            <p>{{ __('for_companies.implementation.step_2_desc') }}</p>
                            <div class="timeline-duration">{{ __('for_companies.implementation.step_2_duration') }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-step">3</div>
                        <div class="timeline-content">
                            <h3>{{ __('for_companies.implementation.step_3_title') }}</h3>
                            <p>{{ __('for_companies.implementation.step_3_desc') }}</p>
                            <div class="timeline-duration">{{ __('for_companies.implementation.step_3_duration') }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-step">4</div>
                        <div class="timeline-content">
                            <h3>{{ __('for_companies.implementation.step_4_title') }}</h3>
                            <p>{{ __('for_companies.implementation.step_4_desc') }}</p>
                            <div class="timeline-duration">{{ __('for_companies.implementation.step_4_duration') }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-step">5</div>
                        <div class="timeline-content">
                            <h3>{{ __('for_companies.implementation.step_5_title') }}</h3>
                            <p>{{ __('for_companies.implementation.step_5_desc') }}</p>
                            <div class="timeline-duration">{{ __('for_companies.implementation.step_5_duration') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- B2B Form Section -->
        <section id="b2b-form" class="b2b-form-section">
            <div class="container">
                <div class="form-wrapper">
                    <div class="form-info">
                        <h2>{{ __('for_companies.form.title') }}</h2>
                        <p>{{ __('for_companies.form.subtitle') }}</p>
                        
                        <div class="form-benefits">
                            <div class="form-benefit">
                                <i class="fas fa-check"></i>
                                <span>{{ __('for_companies.form.benefit_1') }}</span>
                            </div>
                            <div class="form-benefit">
                                <i class="fas fa-check"></i>
                                <span>{{ __('for_companies.form.benefit_2') }}</span>
                            </div>
                            <div class="form-benefit">
                                <i class="fas fa-check"></i>
                                <span>{{ __('for_companies.form.benefit_3') }}</span>
                            </div>
                            <div class="form-benefit">
                                <i class="fas fa-check"></i>
                                <span>{{ __('for_companies.form.benefit_4') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-container">
                        <form class="b2b-form" id="b2bForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="companyName">{{ __('for_companies.form.company_name') }}</label>
                                    <input type="text" id="companyName" name="companyName" required>
                                </div>
                                <div class="form-group">
                                    <label for="industry">{{ __('for_companies.form.industry') }}</label>
                                    <select id="industry" name="industry" required>
                                        <option value="">{{ __('for_companies.form.industry_placeholder') }}</option>
                                        <option value="it">{{ __('for_companies.form.industry_it') }}</option>
                                        <option value="finance">{{ __('for_companies.form.industry_finance') }}</option>
                                        <option value="manufacturing">{{ __('for_companies.form.industry_manufacturing') }}</option>
                                        <option value="retail">{{ __('for_companies.form.industry_retail') }}</option>
                                        <option value="healthcare">{{ __('for_companies.form.industry_healthcare') }}</option>
                                        <option value="education">{{ __('for_companies.form.industry_education') }}</option>
                                        <option value="other">{{ __('for_companies.form.industry_other') }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="employeeCount">{{ __('for_companies.form.employee_count') }}</label>
                                    <select id="employeeCount" name="employeeCount" required>
                                        <option value="">{{ __('for_companies.form.employee_count_placeholder') }}</option>
                                        <option value="25-50">{{ __('for_companies.form.employee_count_25_50') }}</option>
                                        <option value="51-100">{{ __('for_companies.form.employee_count_51_100') }}</option>
                                        <option value="101-250">{{ __('for_companies.form.employee_count_101_250') }}</option>
                                        <option value="251-500">{{ __('for_companies.form.employee_count_251_500') }}</option>
                                        <option value="501-1000">{{ __('for_companies.form.employee_count_501_1000') }}</option>
                                        <option value="1000+">{{ __('for_companies.form.employee_count_1000_plus') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="currentBudget">{{ __('for_companies.form.budget') }}</label>
                                    <select id="currentBudget" name="currentBudget">
                                        <option value="">{{ __('for_companies.form.budget_placeholder') }}</option>
                                        <option value="5000-15000">$5,000 - $15,000</option>
                                        <option value="15000-50000">$15,000 - $50,000</option>
                                        <option value="50000-100000">$50,000 - $100,000</option>
                                        <option value="100000+">{{ __('for_companies.form.budget_100000_plus') }}</option>
                                        <option value="no-budget">{{ __('for_companies.form.budget_none') }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contactName">{{ __('for_companies.form.contact_name') }}</label>
                                    <input type="text" id="contactName" name="contactName" required>
                                </div>
                                <div class="form-group">
                                    <label for="position">{{ __('for_companies.form.position') }}</label>
                                    <input type="text" id="position" name="position" required placeholder="{{ __('for_companies.form.position_placeholder') }}">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">{{ __('for_companies.form.email') }}</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ __('for_companies.form.phone') }}</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="goals">{{ __('for_companies.form.goals_title') }}</label>
                                <div class="checkbox-group goals-checkboxes">
                                    <label><input type="checkbox" name="goals" value="reduce-costs"> {{ __('for_companies.form.goal_1') }}</label>
                                    <label><input type="checkbox" name="goals" value="reduce-sick-days"> {{ __('for_companies.form.goal_2') }}</label>
                                    <label><input type="checkbox" name="goals" value="increase-productivity"> {{ __('for_companies.form.goal_3') }}</label>
                                    <label><input type="checkbox" name="goals" value="improve-retention"> {{ __('for_companies.form.goal_4') }}</label>
                                    <label><input type="checkbox" name="goals" value="wellness-culture"> {{ __('for_companies.form.goal_5') }}</label>
                                    <label><input type="checkbox" name="goals" value="compliance"> {{ __('for_companies.form.goal_6') }}</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="challenges">{{ __('for_companies.form.challenges') }}</label>
                                <textarea id="challenges" name="challenges" rows="3" placeholder="{{ __('for_companies.form.challenges_placeholder') }}"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="timeline">{{ __('for_companies.form.timeline') }}</label>
                                <select id="timeline" name="timeline">
                                    <option value="">{{ __('for_companies.form.timeline_placeholder') }}</option>
                                    <option value="immediate">{{ __('for_companies.form.timeline_immediate') }}</option>
                                    <option value="1-3-months">{{ __('for_companies.form.timeline_1_3') }}</option>
                                    <option value="3-6-months">{{ __('for_companies.form.timeline_3_6') }}</option>
                                    <option value="6-12-months">{{ __('for_companies.form.timeline_6_12') }}</option>
                                    <option value="planning">{{ __('for_companies.form.timeline_planning') }}</option>
                                </select>
                            </div>
                            
                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="privacy-b2b" name="privacy" required>
                                <label for="privacy-b2b">{{ __('for_companies.form.privacy_prefix') }} <a href="/privacy" target="_blank">{{ __('for_companies.form.privacy_link') }}</a> {{ __('for_companies.form.privacy_suffix') }}</label>
                            </div>
                            
                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="demo-request" name="demoRequest">
                                <label for="demo-request">{{ __('for_companies.form.demo_request') }}</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-large b2b-quote-btn">{{ __('for_companies.form.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
    
    <!-- B2B Form Handler -->
    <script>
        // B2B Form Handling
        const b2bForm = document.getElementById('b2bForm');
        if (b2bForm) {
            b2bForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(this);
                const formObject = {};
                
                // Handle checkboxes separately
                const goals = [];
                const goalCheckboxes = this.querySelectorAll('input[name="goals"]:checked');
                goalCheckboxes.forEach(checkbox => goals.push(checkbox.value));
                
                formData.forEach((value, key) => {
                    if (key !== 'goals') {
                        formObject[key] = value;
                    }
                });
                
                formObject.goals = goals;
                
                // Basic validation
                if (!formObject.companyName || !formObject.industry || !formObject.employeeCount || 
                    !formObject.contactName || !formObject.position || !formObject.email || !formObject.privacy) {
                    showNotification(@json(__('for_companies.js.fill_required')), 'error');
                    return;
                }
                
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;
                submitButton.textContent = @json(__('for_companies.js.sending'));
                submitButton.disabled = true;
                
                // Simulate form submission
                setTimeout(() => {
                    showNotification(@json(__('for_companies.js.success')), 'success');
                    b2bForm.reset();
                    
                    // Restore button state
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                    
                    // Track conversion
                    if (typeof gtag === 'function') {
                        gtag('event', 'b2b_form_submit', {
                            event_category: 'conversion',
                            company_size: formObject.employeeCount,
                            industry: formObject.industry
                        });
                    }
                }, 1500);
            });
        }
    </script>
</body>
</html>
