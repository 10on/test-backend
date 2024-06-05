<?php declare(strict_types=1);

namespace App\Repository;

use App\DataBase\DatabaseInterface;
use App\Entity\User;
use App\Exception\UserException;

class UserRepository implements UserRepositoryInterface
{
    private DatabaseInterface $db;

    private string $tableName;

    public function __construct(DatabaseInterface $db, string $tableName = 'users')
    {
        $this->db = $db;
        $this->tableName = $tableName;
    }

    public function save(User $user): bool
    {
        return (bool)$this->db::insert($this->tableName, [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created' => $user->getCreated(),
            'deleted' => $user->getDeleted(),
            'notes' => $user->getNotes()
        ]);
    }

    public function update(User $user): bool
    {
        return (bool)$this->db::update($this->tableName, [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created' => $user->getCreated(),
            'deleted' => $user->getDeleted(),
            'notes' => $user->getNotes()
        ], ['id' => $user->getId()]);
    }

    public function findById(int $id): ?User
    {
        $result = $this->db::query('SELECT * FROM ' . $this->tableName . ' WHERE id=%d', $id);
        if ($result) {
            return User::fromArray($result[0]);
        }
        return null;
    }

    public function findByName(string $name): ?User
    {
        $result = $this->db::query('SELECT * FROM ' . $this->tableName . ' WHERE id=%s', $name);
        if ($result) {
            return User::fromArray($result[0]);
        }
        return null;
    }

    public function findByEmail(string $email): ?User
    {
        $result = $this->db::query('SELECT * FROM ' . $this->tableName . ' WHERE id=%s', $email);
        if ($result) {
            return User::fromArray($result[0]);
        }
        return null;
    }

    private function checkIsNameUniq(string $name): void
    {
        // Possible checking with using MYSQL "EXISTS" operator
        if ($this->findByName($name)) {
            throw new UserException('User with this name already exists');
        }
    }

    private function checkIsEmailUniq(string $email): void
    {
        // Possible checking with using MYSQL "EXISTS" operator
        if ($this->findByEmail($email)) {
            throw new UserException('User with this email already exists');
        }
    }
}
