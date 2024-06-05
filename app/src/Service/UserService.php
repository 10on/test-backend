<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(User $user): bool
    {
        //TODO: Set by database for more accuracy, if possible
        $user->setCreated(new \DateTime());
        return $this->userRepository->save($user);
    }

    public function updateUser(User $user): bool
    {
        return $this->userRepository->update($user);
    }

    public function deleteUser(User $user): bool
    {
        $user->softDelete(new \DateTime());
        return $this->updateUser($user);
    }
}
