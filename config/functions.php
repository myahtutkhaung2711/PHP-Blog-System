<?php
require_once __DIR__ . '/constants.php';

function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function flash(?string $message = null, string $type = 'info'): ?array
{
    startSession();
    if ($message !== null) {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
        return null;
    }

    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }

    return null;
}

function csrfToken(): string
{
    startSession();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function verifyCsrf(): void
{
    startSession();
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        flash('Your session expired. Please try again.', 'danger');
        redirect($_SERVER['HTTP_REFERER'] ?? url('index.php'));
    }
}

function currentUserIsAdmin(): bool
{
    startSession();
    return isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], [ROLE_ADMIN, ROLE_SUPER], true);
}

function currentUserIsSuperAdmin(): bool
{
    startSession();
    return ($_SESSION['user_role'] ?? '') === ROLE_SUPER;
}

function requireAdmin(): void
{
    if (!currentUserIsAdmin()) {
        flash('Please log in as an administrator.', 'warning');
        redirect(url('login.php'));
    }
}

function requireSuperAdmin(): void
{
    if (!currentUserIsSuperAdmin()) {
        flash('Only super admins can perform that action.', 'danger');
        redirect(url('admin/index.php'));
    }
}

function excerpt(string $text, int $length = 140): string
{
    $plain = trim(strip_tags($text));
    if (strlen($plain) <= $length) {
        return $plain;
    }
    return rtrim(substr($plain, 0, $length)) . '...';
}

function postImageUrl(?string $image): string
{
    if (!$image) {
        return url('assets/img/default-blog.svg');
    }

    $image = ltrim($image, '/');
    if (str_starts_with($image, 'uploads/')) {
        return url($image);
    }
    if (str_starts_with($image, 'blogs/')) {
        return url('uploads/' . $image);
    }
    return url('uploads/blogs/' . $image);
}

function saveUploadedImage(array $file, ?string &$error = null): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Image upload failed. Please choose another file.';
        return null;
    }

    if ($file['size'] > MAX_UPLOAD_BYTES) {
        $error = 'Image must be 2MB or smaller.';
        return null;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        $error = 'Only JPG, PNG, GIF, and WebP images are allowed.';
        return null;
    }

    $uploadDir = dirname(__DIR__) . '/uploads/blogs/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = time() . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        $error = 'Could not save the uploaded image.';
        return null;
    }

    return 'blogs/' . $filename;
}

function deletePostImage(?string $image): void
{
    if (!$image) {
        return;
    }

    $relative = ltrim($image, '/');
    if (str_starts_with($relative, 'uploads/')) {
        $relative = substr($relative, strlen('uploads/'));
    }

    $path = dirname(__DIR__) . '/uploads/' . $relative;
    if (is_file($path)) {
        unlink($path);
    }
}
?>
