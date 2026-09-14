<?php
class Dashboard {
    public function __construct(private PDO $db) {}
    public function counts(): array {
        return [
            'medicines'=>(int)$this->db->query("SELECT COUNT(*) FROM medicines")->fetchColumn(),
            'categories'=>(int)$this->db->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
            'customers'=>(int)$this->db->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),
            'pending_orders'=>(int)$this->db->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetchColumn()
        ];
    }
    public function recentCustomers(): array {
        return $this->db->query("SELECT id,name,email,created_at FROM users WHERE role='customer' ORDER BY created_at DESC LIMIT 5")->fetchAll();
    }
    public function lowStock(): array {
        return $this->db->query("SELECT name,availability FROM medicines WHERE availability<=10 ORDER BY availability ASC LIMIT 5")->fetchAll();
    }
}
