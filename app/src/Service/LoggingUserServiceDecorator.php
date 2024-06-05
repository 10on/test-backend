<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;

class LoggingUserServiceDecorator implements UserServiceInterface
{
    private UserServiceInterface $userService;
    private LoggerInterface $logger;

    public function __construct(UserServiceInterface $userService, LoggerInterface $logger)
    {
        $this->userService = $userService;
        $this->logger = $logger;
    }

    public function createUser(User $user): bool
    {
        $result = $this->userService->createUser($user);
        $this->logger->info('User created', ['id' => $user->getId()]);
        return $result;
    }

    public function updateUser(User $user): bool
    {
        $result = $this->userService->updateUser($user);
        if ($result) {
            $this->logger->info('User updated', ['id' => $user->getId()]);
        } else {
            $this->logger->error('Failed to update user', ['id' => $user->getId()]);
        }
        return $result;
    }

    public function deleteUser(User $user): bool
    {
        $result = $this->userService->deleteUser($user);
        if ($result) {
            $this->logger->info('User deleted', ['id' => $user->getId()]);
        } else {
            $this->logger->error('Failed to delete user', ['id' => $user->getId()]);
        }
        return $result;
    }
}
