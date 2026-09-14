<?php
abstract class BaseController {
    protected PDO $db;
    public function __construct() { requireAdmin(); $this->db = Database::connect(); }
    protected function view(string $path, array $data = []): void { extract($data); require __DIR__ . '/../View/' . $path . '.php'; }
    protected function redirect(string $action): never { header('Location: index.php?action=' . urlencode($action)); exit; }
    protected function flash(string $message): void { $_SESSION['flash'] = $message; }
}
