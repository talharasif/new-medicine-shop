<?php
class User {
    public function __construct(private PDO $db) {}

    public function customers(): array {
        $sql="SELECT id,name,email,address,phone,created_at FROM users WHERE role='customer' ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function searchCustomers(string $q): array {
        $like="%".$q."%";
        $sql="SELECT id,name,email,address,phone,created_at
              FROM users
              WHERE role='customer'
              AND (name LIKE ? OR email LIKE ? OR phone LIKE ? OR address LIKE ?)
              ORDER BY id DESC";
        $s=$this->db->prepare($sql);
        $s->execute([$like,$like,$like,$like]);
        return $s->fetchAll();
    }

    public function customerDetails(int $id): ?array {
        $sql="SELECT u.id,u.name,u.email,u.address,u.phone,u.created_at,
              COUNT(o.id) AS total_orders,
              COALESCE(SUM(CASE WHEN o.status='accepted' THEN o.total_amount ELSE 0 END),0) AS total_purchase
              FROM users u
              LEFT JOIN orders o ON o.user_id=u.id
              WHERE u.id=? AND u.role='customer'
              GROUP BY u.id,u.name,u.email,u.address,u.phone,u.created_at";
        $s=$this->db->prepare($sql); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public function customerOrders(int $id): array {
        $s=$this->db->prepare("SELECT id,total_amount,status,shipping_address,order_date FROM orders WHERE user_id=? ORDER BY order_date DESC");
        $s->execute([$id]); return $s->fetchAll();
    }

    public function findCustomer(int $id): ?array {
        $s=$this->db->prepare("SELECT id,name,email,address,phone,created_at FROM users WHERE id=? AND role='customer'");
        $s->execute([$id]); return $s->fetch() ?: null;
    }

    public function updateCustomer(int $id, string $name, string $email, string $phone, string $address): bool {
        $s=$this->db->prepare("UPDATE users SET name=?, email=?, phone=?, address=? WHERE id=? AND role='customer'");
        return $s->execute([$name,$email,$phone,$address,$id]);
    }

    public function deleteCustomer(int $id): bool {
        $this->db->beginTransaction();
        try {
            $s=$this->db->prepare("SELECT role FROM users WHERE id=?"); $s->execute([$id]);
            if ($s->fetchColumn()!=='customer') throw new RuntimeException("Only customers can be deleted.");
            $this->db->prepare("DELETE FROM cart WHERE user_id=?")->execute([$id]);
            $this->db->prepare("DELETE oi FROM order_items oi JOIN orders o ON o.id=oi.order_id WHERE o.user_id=?")->execute([$id]);
            $this->db->prepare("DELETE FROM orders WHERE user_id=?")->execute([$id]);
            $ok=$this->db->prepare("DELETE FROM users WHERE id=? AND role='customer'")->execute([$id]);
            $this->db->commit(); return $ok;
        } catch(Throwable $e) {
            if($this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }
}
