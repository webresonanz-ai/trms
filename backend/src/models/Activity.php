<?php

declare(strict_types=1);

namespace TRMS\Models;

use TRMS\Core\Model;

class Activity extends Model
{
    protected string $table = 'activities';

    public function recent(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?"
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return array_reverse($stmt->fetchAll());
    }
}
