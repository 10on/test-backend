<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;

interface UserValidationServiceInterface
{
    public function validate(User $user): void;
}