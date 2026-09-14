<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('blog.meta.title') }}</title>
    <meta name="description" content="{{ __('blog.meta.description') }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ __('blog.meta.og_title') }}">
    <meta property="og:description" content="{{ __('blog.meta.og_description') }}">
    <meta property="og:type" content="website">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $styleVersion }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
    @include('partials.header', ['active' => 'blog'])

    <!-- Main Content -->
    <main>
        <!-- Blog Hero -->
        <section class="blog-hero">
            <div class="container">
                <div class="blog-hero-content">
                    <div class="breadcrumb">
                        <a href="/">{{ __('blog.hero.breadcrumb_home') }}</a> / <span>{{ __('blog.hero.breadcrumb_current') }}</span>
                    </div>
                    <h1>{{ __('blog.hero.title') }}</h1>
                    <p class="blog-subtitle">{{ __('blog.hero.subtitle') }}</p>
                    
                    <div class="blog-stats">
                        <div class="blog-stat">
                            <span class="stat-number">150+</span>
                            <span class="stat-label">{{ __('blog.hero.stat_1') }}</span>
                        </div>
                        <div class="blog-stat">
                            <span class="stat-number">70+</span>
                            <span class="stat-label">{{ __('blog.hero.stat_2') }}</span>
                        </div>
                        <div class="blog-stat">
                            <span class="stat-number">25K+</span>
                            <span class="stat-label">{{ __('blog.hero.stat_3') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Filters -->
        <section class="blog-filters">
            <div class="container">
                <div class="filter-container">
                    <div class="filter-group">
                        <h3>{{ __('blog.filters.categories') }}</h3>
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-category="all">{{ __('blog.filters.all') }}</button>
                            <button class="filter-btn" data-category="prevention">{{ __('blog.filters.prevention') }}</button>
                            <button class="filter-btn" data-category="cardiology">{{ __('blog.filters.cardiology') }}</button>
                            <button class="filter-btn" data-category="endocrinology">{{ __('blog.filters.endocrinology') }}</button>
                            <button class="filter-btn" data-category="neurology">{{ __('blog.filters.neurology') }}</button>
                            <button class="filter-btn" data-category="nutrition">{{ __('blog.filters.nutrition') }}</button>
                            <button class="filter-btn" data-category="mental-health">{{ __('blog.filters.mental_health') }}</button>
                            <button class="filter-btn" data-category="lifestyle">{{ __('blog.filters.lifestyle') }}</button>
                        </div>
                    </div>
                    
                    <div class="search-group">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="{{ __('blog.filters.search_placeholder') }}" id="blogSearch">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Article -->
        <section class="featured-article">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('blog.featured.section_title') }}</h2>
                </div>
                
                <article class="featured-post">
                    <div class="featured-content">
                        <div class="post-meta">
                            <span class="post-category cardiology">{{ __('blog.featured.category') }}</span>
                            <span class="post-date">{{ __('blog.featured.date') }}</span>
                            <span class="post-read-time">{{ __('blog.featured.read_time') }}</span>
                        </div>
                        
                        <h2><a href="blog/managing-hypertension-2024.html">{{ __('blog.featured.title') }}</a></h2>
                        
                        <p class="post-excerpt">{{ __('blog.featured.excerpt') }}</p>
                        
                        <div class="post-author">
                            <div class="author-info">
                                <div class="author-name">{{ __('blog.featured.author_name') }}</div>
                                <div class="author-title">{{ __('blog.featured.author_title') }}</div>
                            </div>
                        </div>
                        
                        <a href="blog/managing-hypertension-2024.html" class="btn btn-outline">{{ __('blog.featured.read_article') }}</a>
                    </div>
                    
                    <div class="featured-image">
                        <div class="image-placeholder">
                            <i class="fas fa-heartbeat"></i>
                            <span>{{ __('blog.featured.image_label') }}</span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Blog Posts -->
        <section class="blog-posts">
            <div class="container">
                <div class="blog-layout">
                    <div class="posts-grid" id="postsGrid">
                        <!-- Post 1 -->
                        <article class="post-card" data-category="prevention nutrition">
                            <div class="post-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-apple-alt"></i>
                                </div>
                                <div class="post-category-badge prevention">{{ __('blog.posts.post_1.category') }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">{{ __('blog.posts.post_1.date') }}</span>
                                    <span class="post-read-time">{{ __('blog.posts.post_1.read_time') }}</span>
                                </div>
                                <h3><a href="blog/diabetes-prevention-guide.html">{{ __('blog.posts.post_1.title') }}</a></h3>
                                <p class="post-excerpt">{{ __('blog.posts.post_1.excerpt') }}</p>
                                <div class="post-author">
                                    <span class="author-name">{{ __('blog.posts.post_1.author_name') }}</span>
                                    <span class="author-specialty">{{ __('blog.posts.post_1.author_specialty') }}</span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 2 -->
                        <article class="post-card" data-category="mental-health lifestyle">
                            <div class="post-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <div class="post-category-badge mental-health">{{ __('blog.posts.post_2.category') }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">{{ __('blog.posts.post_2.date') }}</span>
                                    <span class="post-read-time">{{ __('blog.posts.post_2.read_time') }}</span>
                                </div>
                                <h3><a href="blog/stress-management-techniques.html">{{ __('blog.posts.post_2.title') }}</a></h3>
                                <p class="post-excerpt">{{ __('blog.posts.post_2.excerpt') }}</p>
                                <div class="post-author">
                                    <span class="author-name">{{ __('blog.posts.post_2.author_name') }}</span>
                                    <span class="author-specialty">{{ __('blog.posts.post_2.author_specialty') }}</span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 3 -->
                        <article class="post-card" data-category="neurology prevention">
                            <div class="post-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <div class="post-category-badge neurology">{{ __('blog.posts.post_3.category') }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">{{ __('blog.posts.post_3.date') }}</span>
                                    <span class="post-read-time">{{ __('blog.posts.post_3.read_time') }}</span>
                                </div>
                                <h3><a href="blog/sleep-hygiene-guide.html">{{ __('blog.posts.post_3.title') }}</a></h3>
                                <p class="post-excerpt">{{ __('blog.posts.post_3.excerpt') }}</p>
                                <div class="post-author">
                                    <span class="author-name">{{ __('blog.posts.post_3.author_name') }}</span>
                                    <span class="author-specialty">{{ __('blog.posts.post_3.author_specialty') }}</span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 4 -->
                        <article class="post-card" data-category="nutrition prevention">
                            <div class="post-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div class="post-category-badge nutrition">{{ __('blog.posts.post_4.category') }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">{{ __('blog.posts.post_4.date') }}</span>
                                    <span class="post-read-time">{{ __('blog.posts.post_4.read_time') }}</span>
                                </div>
                                <h3><a href="blog/mediterranean-diet-benefits.html">{{ __('blog.posts.post_4.title') }}</a></h3>
                                <p class="post-excerpt">{{ __('blog.posts.post_4.excerpt') }}</p>
                                <div class="post-author">
                                    <span class="author-name">{{ __('blog.posts.post_4.author_name') }}</span>
                                    <span class="author-specialty">{{ __('blog.posts.post_4.author_specialty') }}</span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 5 -->
                        <article class="post-card" data-category="cardiology lifestyle">
                            <div class="post-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-running"></i>
                                </div>
                                <div class="post-category-badge cardiology">{{ __('blog.posts.post_5.category') }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">{{ __('blog.posts.post_5.date') }}</span>
                                    <span class="post-read-time">{{ __('blog.posts.post_5.read_time') }}</span>
                                </div>
                                <h3><a href="blog/cardio-exercise-guide.html">{{ __('blog.posts.post_5.title') }}</a></h3>
                                <p class="post-excerpt">{{ __('blog.posts.post_5.excerpt') }}</p>
                                <div class="post-author">
                                    <span class="author-name">{{ __('blog.posts.post_5.author_name') }}</span>
                                    <span class="author-specialty">{{ __('blog.posts.post_5.author_specialty') }}</span>
                                </div>
                            </div>
                        </article>

                        <!-- Post 6 -->
                        <article class="post-card" data-category="endocrinology prevention">
                            <div class="post-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="post-category-badge endocrinology">{{ __('blog.posts.post_6.category') }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">{{ __('blog.posts.post_6.date') }}</span>
                                    <span class="post-read-time">{{ __('blog.posts.post_6.read_time') }}</span>
                                </div>
                                <h3><a href="blog/thyroid-health-guide.html">{{ __('blog.posts.post_6.title') }}</a></h3>
                                <p class="post-excerpt">{{ __('blog.posts.post_6.excerpt') }}</p>
                                <div class="post-author">
                                    <span class="author-name">{{ __('blog.posts.post_6.author_name') }}</span>
                                    <span class="author-specialty">{{ __('blog.posts.post_6.author_specialty') }}</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    
                    <!-- Sidebar -->
                    <aside class="blog-sidebar">
                        <div class="sidebar-widget">
                            <h3>{{ __('blog.sidebar.popular_topics') }}</h3>
                            <div class="topics-cloud">
                                <a href="#" class="topic-tag" data-category="prevention">{{ __('blog.sidebar.topic_1') }}</a>
                                <a href="#" class="topic-tag" data-category="nutrition">{{ __('blog.sidebar.topic_2') }}</a>
                                <a href="#" class="topic-tag" data-category="cardiology">{{ __('blog.sidebar.topic_3') }}</a>
                                <a href="#" class="topic-tag" data-category="mental-health">{{ __('blog.sidebar.topic_4') }}</a>
                                <a href="#" class="topic-tag" data-category="lifestyle">{{ __('blog.sidebar.topic_5') }}</a>
                                <a href="#" class="topic-tag" data-category="endocrinology">{{ __('blog.sidebar.topic_6') }}</a>
                                <a href="#" class="topic-tag" data-category="neurology">{{ __('blog.sidebar.topic_7') }}</a>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget">
                            <h3>{{ __('blog.sidebar.our_authors') }}</h3>
                            <div class="authors-list">
                                <div class="author-item">
                                    <div class="author-avatar">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div class="author-info">
                                        <div class="author-name">{{ __('blog.sidebar.author_1_name') }}</div>
                                        <div class="author-specialty">{{ __('blog.sidebar.author_1_specialty') }}</div>
                                    </div>
                                </div>
                                <div class="author-item">
                                    <div class="author-avatar">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div class="author-info">
                                        <div class="author-name">{{ __('blog.sidebar.author_2_name') }}</div>
                                        <div class="author-specialty">{{ __('blog.sidebar.author_2_specialty') }}</div>
                                    </div>
                                </div>
                                <div class="author-item">
                                    <div class="author-avatar">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div class="author-info">
                                        <div class="author-name">{{ __('blog.sidebar.author_3_name') }}</div>
                                        <div class="author-specialty">{{ __('blog.sidebar.author_3_specialty') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget cta-widget">
                            <h3>{{ __('blog.sidebar.consultation_title') }}</h3>
                            <p>{{ __('blog.sidebar.consultation_text') }}</p>
                            <a href="index.html#contact-form" class="btn btn-primary btn-small">{{ __('blog.sidebar.consultation_cta') }}</a>
                        </div>
                        
                        <div class="sidebar-widget newsletter-widget">
                            <h3>{{ __('blog.sidebar.newsletter_title') }}</h3>
                            <p>{{ __('blog.sidebar.newsletter_text') }}</p>
                            <form class="newsletter-form" id="newsletterForm">
                                <input type="email" placeholder="{{ __('blog.sidebar.newsletter_placeholder') }}" required>
                                <button type="submit" class="btn btn-outline btn-small">{{ __('blog.sidebar.newsletter_button') }}</button>
                            </form>
                        </div>
                    </aside>
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                        {{ __('blog.pagination.previous') }}
                    </button>
                    <div class="pagination-numbers">
                        <button class="pagination-number active">1</button>
                        <button class="pagination-number">2</button>
                        <button class="pagination-number">3</button>
                        <span class="pagination-dots">...</span>
                        <button class="pagination-number">8</button>
                    </div>
                    <button class="pagination-btn">
                        {{ __('blog.pagination.next') }}
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>

        <!-- Blog CTA -->
        <section class="blog-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>{{ __('blog.cta.title') }}</h2>
                    <p>{{ __('blog.cta.subtitle') }}</p>
                    <div class="cta-actions">
                        <a href="services/checkup.html" class="btn btn-primary btn-large">{{ __('blog.cta.primary') }}</a>
                        <a href="index.html#contact-form" class="btn btn-outline btn-large">{{ __('blog.cta.secondary') }}</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer', [
        'showFooterSocial' => true,
    ])

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}?v={{ $mainJsVersion }}"></script>
    
    <!-- Blog-specific JavaScript -->
    <script>
        // Blog filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const topicTags = document.querySelectorAll('.topic-tag');
            const postCards = document.querySelectorAll('.post-card');
            const searchInput = document.getElementById('blogSearch');

            // Filter by category
            function filterPosts(category) {
                postCards.forEach(card => {
                    const cardCategories = card.dataset.category.split(' ');
                    if (category === 'all' || cardCategories.includes(category)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.3s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Filter button events
            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterButtons.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    btn.classList.add('active');
                    // Filter posts
                    const category = btn.dataset.category;
                    filterPosts(category);
                });
            });

            // Topic tag events
            topicTags.forEach(tag => {
                tag.addEventListener('click', (e) => {
                    e.preventDefault();
                    const category = tag.dataset.category;
                    
                    // Update active filter button
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active');
                        if (btn.dataset.category === category) {
                            btn.classList.add('active');
                        }
                    });
                    
                    // Filter posts
                    filterPosts(category);
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                postCards.forEach(card => {
                    const title = card.querySelector('h3 a').textContent.toLowerCase();
                    const excerpt = card.querySelector('.post-excerpt').textContent.toLowerCase();
                    const author = card.querySelector('.author-name').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || excerpt.includes(searchTerm) || author.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Newsletter form
            const newsletterForm = document.getElementById('newsletterForm');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = this.querySelector('input[type="email"]').value;
                    
                    if (email) {
                        showNotification(@json(__('blog.js.newsletter_success')), 'success');
                        this.reset();
                    }
                });
            }

            // Pagination (basic functionality)
            const paginationNumbers = document.querySelectorAll('.pagination-number');
            paginationNumbers.forEach(btn => {
                btn.addEventListener('click', () => {
                    paginationNumbers.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    // Scroll to top of posts
                    document.querySelector('.blog-posts').scrollIntoView({ 
                        behavior: 'smooth' 
                    });
                });
            });

            // Add fade in animation CSS
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>
