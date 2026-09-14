<?php
class Category {
    public function __construct(private PDO $db) {}
    public function all(): array { return $this->db->query('SELECT * FROM categories ORDER BY name')->fetchAll(); }
    public function find(int $id): ?array { $s=$this->db->prepare('SELECT * FROM categories WHERE id=?'); $s->execute([$id]); return $s->fetch() ?: null; }
    public function save(?int $id, string $name, string $type): bool {
        if ($id) return $this->db->prepare('UPDATE categories SET name=?, category_type=? WHERE id=?')->execute([$name,$type,$id]);
        return $this->db->prepare('INSERT INTO categories(name,category_type) VALUES(?,?)')->execute([$name,$type]);
    }
    public function delete(int $id): bool {
        $s=$this->db->prepare('SELECT COUNT(*) FROM medicines WHERE category_id=?'); $s->execute([$id]);
        if ((int)$s->fetchColumn()>0) throw new RuntimeException('Cannot delete category because medicines exist in it.');
        return $this->db->prepare('DELETE FROM categories WHERE id=?')->execute([$id]);
    }
}
