<?php

declare(strict_types=1);

namespace TRMS\Models;

use TRMS\Core\Model;

class Event extends Model
{
    protected string $table = 'events';

    public function upcoming(int $limit = 5): array
    {
        $today = date('Y-m-d');
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE date >= ? ORDER BY date ASC LIMIT ?"
        );
        $stmt->bindValue(1, $today);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function forMonth(int $month): array
    {
        $year = date('Y');
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE MONTH(date) = ? AND YEAR(date) = ? ORDER BY date ASC"
        );
        $stmt->execute([$month, $year]);
        return $stmt->fetchAll();
    }
}
