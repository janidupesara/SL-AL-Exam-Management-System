<?php
class Controller {
    protected function view(string $name, array $data = []): void {
        extract($data);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $name . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
    protected function redirect(string $path): never {
        header('Location: index.php?url=' . urlencode($path));
        exit;
    }
    protected function requireLogin(): void {
        if (empty($_SESSION['user_id'])) $this->redirect('auth/login');
    }
    protected function csrfField(): string {
        if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
        return '<input type="hidden" name="csrf" value="' . htmlspecialchars($_SESSION['csrf']) . '">';
    }
    protected function verifyCsrf(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
            http_response_code(419);
            exit('Invalid form token. Please go back and try again.');
        }
    }
}

