<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Service\UserService;
use App\Repository\UserRepositoryInterface;

class UserServiceTest extends TestCase
{
    private $userRepository;
    private $userService;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function testCreateUserSuccessfully(): void
    {
        $user = new User();
        $user->setName('Billy Harrington');
        $user->setEmail('billy@example.com');

        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (User $user) {
                $this->assertInstanceOf(\DateTime::class, $user->getCreated());
                return true;
            }))
            ->willReturn(true);

        $this->assertTrue($this->userService->createUser($user));
    }

    public function testCreateUserFailsWhenNameAlreadyExists(): void
    {
        $user = new User();
        $user->setName('Billy Harrington');
        $user->setEmail('billy@example.com');

        $existingUser = new User();
        $existingUser->setName('Billy Harrington');
        $existingUser->setEmail('billy@example.com');

        $this->userRepository->method('findByName')
            ->with($this->equalTo('Billy Harrington'))
            ->willReturn($existingUser);

        $this->userRepository->method('findByEmail')
            ->with($this->equalTo('billy@example.com'))
            ->willReturn(null);

        $this->assertFalse($this->userService->createUser($user));
    }
}