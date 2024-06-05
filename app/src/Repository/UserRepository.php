<?php declare(strict_types=1);

namespace App\Repository;

use App\DataBase\DatabaseInterface;
use App\Entity\User;
use App\Exception\UserException;
use App\Validator\UserValidator;


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
        if ($this->validateUser($user)) {
            $this->db::insert($this->tableName, [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'created' => $user->getCreated(),
                'deleted' => $user->getDeleted(),
                'notes' => $user->getNotes()
            ]);

            return true;
        }

        return false;
    }

    public function update(User $user): bool
    {
        if ($this->validateUser($user)) {
            $this->db::update($this->tableName, [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'created' => $user->getCreated(),
                'deleted' => $user->getDeleted(),
                'notes' => $user->getNotes()
            ], ['id' => $user->getId()]);

            return true;
        }

        return false;
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

    private function validateUser(User $user): bool
    {
        try {
            UserValidator::validateName($user->getName());
            UserValidator::validateEmail($user->getEmail());
            UserValidator::validateDeletedDate($user->getCreated(), $user->getDeleted());
            $this->checkIsNameUniq($user->getName());
            $this->checkIsEmailUniq($user->getEmail());
        } catch (UserException $exception) {
            //TODO Implement logging or custom handling if need
            return false;
        }

        return true;
    }
}
