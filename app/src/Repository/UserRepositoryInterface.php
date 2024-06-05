<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): bool;

    public function update(User $user): bool;

    public function findById(int $id): ?User;

    public function findByName(string $name): ?User;

    public function findByEmail(string $email): ?User;
}