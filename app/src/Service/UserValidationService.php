<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\UserException;
use App\Validator\UserValidator;
use App\Repository\UserRepositoryInterface;

class UserValidationService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate(User $user): void
    {
        UserValidator::validateName($user->getName());
        UserValidator::validateEmail($user->getEmail());
        UserValidator::validateDeletedDate($user->getCreated(), $user->getDeleted());
        $this->checkIsNameUniq($user->getName());
        $this->checkIsEmailUniq($user->getEmail());
    }

    private function checkIsNameUniq(string $name): void
    {
        if ($this->userRepository->findByName($name)) {
            throw new UserException('User with this name already exists');
        }
    }

    private function checkIsEmailUniq(string $email): void
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new UserException('User with this email already exists');
        }
    }
}