<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if ($action === 'mark_read') {
        $stmt = $conn->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        flash('Message marked as read.', 'success');
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare('DELETE FROM contact_messages WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        flash('Message deleted.', 'success');
    }
    redirect(url('admin/messages.php'));
}

$pageTitle = 'Contact Messages - MHK Admin';
$messages = $conn->query('SELECT * FROM contact_messages ORDER BY created_at DESC');

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading"><h1>Contact Messages</h1></div>
        <div class="content-panel table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Sender</th><th>Subject</th><th>Message</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                <?php if ($messages->num_rows > 0): ?>
                    <?php while ($message = $messages->fetch_assoc()): ?>
                        <tr class="<?= $message['is_read'] ? '' : 'table-warning'; ?>">
                            <td><strong><?= e($message['name']); ?></strong><br><a href="mailto:<?= e($message['email']); ?>"><?= e($message['email']); ?></a></td>
                            <td><?= e($message['subject']); ?></td>
                            <td><?= e(excerpt($message['message'], 120)); ?></td>
                            <td><?= date('M d, Y', strtotime($message['created_at'])); ?></td>
                            <td class="text-end">
                                <?php if (!$message['is_read']): ?>
                                    <form method="POST" class="d-inline">
                                        <?= csrfField(); ?>
                                        <input type="hidden" name="id" value="<?= (int) $message['id']; ?>">
                                        <input type="hidden" name="action" value="mark_read">
                                        <button class="btn btn-sm btn-outline-dark" type="submit">Mark Read</button>
                                    </form>
                                <?php endif; ?>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this message?')">
                                    <?= csrfField(); ?>
                                    <input type="hidden" name="id" value="<?= (int) $message['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">No contact messages yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
