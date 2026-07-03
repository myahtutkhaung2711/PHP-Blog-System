<?php
require_once __DIR__ . '/../config/functions.php';

$pageTitle = 'About Us - MHK Blog';
include __DIR__ . '/../includes/header.php';
?>
<main>
    <section class="page-hero compact-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7" data-animate>
                    <span class="eyebrow">About Us</span>
                    <h1>A portfolio-ready PHP blog with real product thinking.</h1>
                    <p class="lead text-muted">MHK Blog combines a clean visitor experience with a practical content management workflow for administrators.</p>
                </div>
                <div class="col-lg-5" data-animate>
                    <div class="about-orbit">
                        <div><i class="icon-badge">D</i><span>Design</span></div>
                        <div><i class="icon-badge">C</i><span>Code</span></div>
                        <div><i class="icon-badge">S</i><span>Security</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-pad">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-animate>
                    <div class="info-card h-100">
                        <i class="icon-badge">01</i>
                        <h2>Visitor Experience</h2>
                        <p>Readers can browse posts, open categories, search content, and send messages from a responsive interface.</p>
                    </div>
                </div>
                <div class="col-md-4" data-animate>
                    <div class="info-card h-100">
                        <i class="icon-badge">02</i>
                        <h2>Admin Workflow</h2>
                        <p>Administrators manage posts, categories, uploads, messages, and users through a clean dashboard.</p>
                    </div>
                </div>
                <div class="col-md-4" data-animate>
                    <div class="info-card h-100">
                        <i class="icon-badge">03</i>
                        <h2>Secure Foundation</h2>
                        <p>The project uses prepared statements, CSRF tokens, escaped output, and validated image uploads.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
