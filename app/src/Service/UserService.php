<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
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
