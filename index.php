<?php
require_once __DIR__ . '/config/connection.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'Blog. - PHP Blog System';

$posts = $conn->query("
    SELECT posts.*, categories.name AS category_name
    FROM posts
    LEFT JOIN categories ON posts.category_id = categories.id
    WHERE posts.status = 'published'
    ORDER BY posts.created_at DESC, posts.id DESC
    LIMIT 9
");

$categories = $conn->query("
    SELECT categories.*, COUNT(posts.id) AS post_count
    FROM categories
    LEFT JOIN posts ON posts.category_id = categories.id AND posts.status = 'published'
    GROUP BY categories.id
    ORDER BY categories.name
");

include __DIR__ . '/includes/header.php';
?>

<main>
    <section id="home" class="hero-section hero-advanced">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7" data-animate>
                    <span class="eyebrow">PHP + MySQL Blog Platform</span>
                    <h1 class="display-5 fw-bold mt-3">Clean stories, useful ideas, and a polished admin workflow.</h1>
                    <p class="lead text-muted mt-3">A responsive blog system with categories, featured images, contact messages, and a practical dashboard for content management.</p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="#blog" class="btn btn-dark btn-lg">Explore Posts</a>
                        <a href="#contact" class="btn btn-outline-dark btn-lg">Contact Us</a>
                    </div>
                    <div class="hero-trust mt-4">
                        <span><i class="icon-dot"></i>Secure forms</span>
                        <span><i class="icon-dot"></i>Responsive UI</span>
                        <span><i class="icon-dot"></i>Admin CRUD</span>
                    </div>
                </div>
                <div class="col-lg-5" data-animate>
                    <div class="hero-panel hero-dashboard-preview">
                        <div class="preview-toolbar"><span></span><span></span><span></span></div>
                        <p class="text-uppercase small fw-bold text-muted mb-2">Project Highlights</p>
                        <div class="metric-row"><span><i class="icon-badge">P</i>Posts</span><strong><?= $posts ? mysqli_num_rows($posts) : 0; ?>+</strong></div>
                        <div class="metric-row"><span><i class="icon-badge">C</i>Categories</span><strong><?= $categories ? mysqli_num_rows($categories) : 0; ?></strong></div>
                        <div class="metric-row"><span><i class="icon-badge">S</i>Stack</span><strong>Pure PHP</strong></div>
                        <div class="preview-bars">
                            <span style="width: 82%"></span>
                            <span style="width: 64%"></span>
                            <span style="width: 74%"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="section-pad">
        <div class="container">
            <div class="section-heading d-flex flex-column flex-lg-row justify-content-between gap-3">
                <div>
                    <span class="eyebrow">Latest Blog</span>
                    <h2>Recent Posts</h2>
                </div>
                <form class="mini-search" action="<?= url('pages/search.php'); ?>" method="GET">
                    <input type="search" name="q" class="form-control" placeholder="Search posts">
                    <button class="btn btn-dark" type="submit">Search</button>
                </form>
            </div>
            <div class="row g-4">
                <?php if ($posts && mysqli_num_rows($posts) > 0): ?>
                    <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                        <div class="col-md-6 col-lg-4" data-animate>
                            <article class="post-card h-100">
                                <div class="post-image-wrap">
                                    <img src="<?= e(postImageUrl($post['image'])); ?>" alt="<?= e($post['title']); ?>">
                                </div>
                                <div class="post-card-body">
                                    <span class="badge text-bg-light"><?= e($post['category_name'] ?? 'Uncategorized'); ?></span>
                                    <h3><?= e($post['title']); ?></h3>
                                    <p><?= e(excerpt($post['content'])); ?></p>
                                    <a href="<?= url('pages/post.php?id=' . (int) $post['id']); ?>" class="stretched-link read-link">Read More <span>-></span></a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">No published posts yet.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="about" class="section-pad bg-soft section-layered">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6" data-animate>
                    <span class="eyebrow">About Us</span>
                    <h2>A blog system built for real content workflows.</h2>
                    <p class="text-muted">MHK Blog demonstrates a complete full stack PHP project: visitors can browse posts by category, read articles, and send contact messages while administrators manage content from a secure dashboard.</p>
                    <a class="btn btn-outline-dark mt-2" href="<?= url('pages/about.php'); ?>">Learn More</a>
                </div>
                <div class="col-lg-6" data-animate>
                    <div class="feature-grid">
                        <div><i class="icon-badge">1</i><strong>CRUD</strong><span>Posts, categories, users, and messages.</span></div>
                        <div><i class="icon-badge">2</i><strong>Security</strong><span>Prepared statements, CSRF checks, validated uploads.</span></div>
                        <div><i class="icon-badge">3</i><strong>Responsive</strong><span>Modern layouts that work across screen sizes.</span></div>
                        <div><i class="icon-badge">4</i><strong>Deployable</strong><span>No required external PHP packages.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="section-pad">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5" data-animate>
                    <span class="eyebrow">Contact Us</span>
                    <h2>Send a message</h2>
                    <p class="text-muted">Questions, feedback, and project inquiries are stored for admin review.</p>
                    <div class="contact-stack">
                        <div><i class="icon-badge">M</i><span>Messages are saved to the admin panel.</span></div>
                        <div><i class="icon-badge">R</i><span>Admins can review and mark messages read.</span></div>
                    </div>
                </div>
                <div class="col-lg-7" data-animate>
                    <form class="contact-form" action="<?= url('pages/contact.php'); ?>" method="POST">
                        <?= csrfField(); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required maxlength="150">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" required maxlength="180">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-dark btn-lg" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
