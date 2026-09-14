<?php
class Order {
    public function __construct(private PDO $db) {}

    public function all(): array {
        return $this->search("", "all");
    }

    public function search(string $q,string $status): array {
        $sql="SELECT o.*,u.name customer_name,u.email FROM orders o JOIN users u ON u.id=o.user_id WHERE 1=1";
        $v=[];
        if($q!==""){
            $sql.=" AND (CAST(o.id AS CHAR) LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";
            $like="%".$q."%";$v=[$like,$like,$like];
        }
        if($status!=="" && $status!=="all"){
            $sql.=" AND o.status=?";$v[]=$status;
        }
        $sql.=" ORDER BY o.order_date DESC";
        $s=$this->db->prepare($sql);$s->execute($v);return $s->fetchAll();
    }

    public function recent(int $limit=5): array {
        $limit=max(1,min(20,$limit));
        return $this->db->query("SELECT o.id,o.status,o.total_amount,o.order_date,u.name customer_name
          FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.order_date DESC LIMIT ".$limit)->fetchAll();
    }

    public function acceptedHistory(): array {
        return $this->db->query("SELECT o.id order_id,o.order_date,o.total_amount,o.shipping_address,u.name customer_name,u.email,u.phone,
        GROUP_CONCAT(CONCAT(m.name,' x',oi.quantity) SEPARATOR ', ') items
        FROM orders o JOIN users u ON u.id=o.user_id JOIN order_items oi ON oi.order_id=o.id JOIN medicines m ON m.id=oi.medicine_id
        WHERE o.status='accepted' GROUP BY o.id ORDER BY o.order_date DESC")->fetchAll();
    }

    public function updateStatus(int $id,string $status): bool {
        if(!in_array($status,['accepted','rejected'],true)) throw new RuntimeException("Invalid status.");
        $s=$this->db->prepare("UPDATE orders SET status=? WHERE id=? AND status='pending'");
        $s->execute([$status,$id]);return $s->rowCount()===1;
    }
}
