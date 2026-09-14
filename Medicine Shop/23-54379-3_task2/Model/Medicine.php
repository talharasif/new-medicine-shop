<?php
class Medicine {
    public function __construct(private PDO $db) {}

    public function all(): array {
        return $this->db->query("SELECT m.*,c.name category_name,c.category_type
          FROM medicines m JOIN categories c ON c.id=m.category_id ORDER BY m.id DESC")->fetchAll();
    }

    public function search(string $q,string $category,string $type): array {
        $sql="SELECT m.*,c.name category_name,c.category_type
              FROM medicines m JOIN categories c ON c.id=m.category_id WHERE 1=1";
        $v=[];
        if($q!==''){ $sql.=" AND (m.name LIKE ? OR m.vendor_name LIKE ?)"; $like="%".$q."%"; $v[]=$like;$v[]=$like; }
        if($category!==''){ $sql.=" AND m.category_id=?"; $v[]=(int)$category; }
        if($type!==''){ $sql.=" AND c.category_type=?"; $v[]=$type; }
        $sql.=" ORDER BY m.id DESC";
        $s=$this->db->prepare($sql);$s->execute($v);return $s->fetchAll();
    }

    public function find(int $id): ?array {
        $s=$this->db->prepare("SELECT * FROM medicines WHERE id=?");$s->execute([$id]);return $s->fetch() ?: null;
    }

    public function details(int $id): ?array {
        $s=$this->db->prepare("SELECT m.*,c.name category_name,c.category_type
          FROM medicines m JOIN categories c ON c.id=m.category_id WHERE m.id=?");
        $s->execute([$id]);return $s->fetch() ?: null;
    }

    public function create(array $d): bool {
        return $this->db->prepare("INSERT INTO medicines(name,category_id,vendor_name,price,availability,description,image_path) VALUES(?,?,?,?,?,?,?)")
        ->execute([$d['name'],$d['category_id'],$d['vendor_name'],$d['price'],$d['availability'],$d['description'],$d['image_path']]);
    }

    public function update(int $id,array $d): bool {
        $sql="UPDATE medicines SET name=?,category_id=?,vendor_name=?,price=?,availability=?,description=?";
        $v=[$d['name'],$d['category_id'],$d['vendor_name'],$d['price'],$d['availability'],$d['description']];
        if($d['image_path']!==null){$sql.=",image_path=?";$v[]=$d['image_path'];}
        $sql.=" WHERE id=?";$v[]=$id;
        return $this->db->prepare($sql)->execute($v);
    }

    public function delete(int $id): bool {
        $s=$this->db->prepare("SELECT COUNT(*) FROM order_items oi JOIN orders o ON o.id=oi.order_id WHERE oi.medicine_id=? AND o.status='pending'");
        $s->execute([$id]);
        if((int)$s->fetchColumn()>0) throw new RuntimeException("Cannot delete medicine because it exists in a pending order.");
        $m=$this->find($id); if(!$m)return false;
        if(!empty($m['image_path'])){$p=__DIR__."/../public/".ltrim($m['image_path'],"/");if(is_file($p))unlink($p);}
        return $this->db->prepare("DELETE FROM medicines WHERE id=?")->execute([$id]);
    }
}
