<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;

interface UserServiceInterface
{
    public function createUser(User $user): bool;

    public function updateUser(User $user): bool;

    public function deleteUser(User $user): bool;
}
