<?php
namespace App\Traits;

trait SearchableTrait {
   
    public function search(string $term, array $columns = ['title', 'author']): array {
        if (empty($columns)) {
            return [];
        }

        $term = "%{$term}%";
        $clauses = [];
        $params = [];

        foreach ($columns as $i => $col) {
          
            $clauses[] = "`{$col}` LIKE :t{$i}";
            $params[":t{$i}"] = $term;
        }

        $sql = 'SELECT * FROM `' . $this->table . '` WHERE ' . implode(' OR ', $clauses);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
