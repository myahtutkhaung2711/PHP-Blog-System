<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('Please provide a valid name, email, subject, and message.', 'danger');
        redirect(url('pages/contact.php'));
    }

    $stmt = $conn->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $name, $email, $subject, $message);
    $stmt->execute();
    $stmt->close();

    flash('Thanks for reaching out. Your message has been saved.', 'success');
    redirect(url('pages/contact.php'));
}

$pageTitle = 'Contact Us - MHK Blog';
include __DIR__ . '/../includes/header.php';
?>
<main>
    <section class="page-hero compact-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6" data-animate>
                    <span class="eyebrow">Contact Us</span>
                    <h1>Let us know what you are building, reading, or improving.</h1>
                    <p class="lead text-muted">Messages go directly into the admin dashboard so they can be reviewed and managed.</p>
                    <div class="contact-stack">
                        <div><i class="icon-badge">A</i><span>Admin message inbox</span></div>
                        <div><i class="icon-badge">S</i><span>Secure CSRF-protected form</span></div>
                    </div>
                </div>
                <div class="col-lg-6" data-animate>
                    <form class="contact-form floating-form" action="<?= url('pages/contact.php'); ?>" method="POST">
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
                                <textarea name="message" class="form-control" rows="6" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-dark btn-lg w-100" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
