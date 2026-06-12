<?php

declare(strict_types=1);

namespace TRMS\Models;

use TRMS\Core\Database;
use TRMS\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->first($this->table, 'email', $email);
    }

    public function createUser(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return parent::create($this->table, $data);
    }

    public function updateProfile(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        unset($data['password']);
        return parent::update($this->table, $id, $data);
    }
}
