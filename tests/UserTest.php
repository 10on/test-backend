<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTest extends TestCase
{
    public function testUserCanBeCreated(): void
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserCanSetAndGetName(): void
    {
        $user = new User();
        $user->setName('Billy Harrington');
        $this->assertEquals('Billy Harrington', $user->getName());
    }

    public function testUserCanSetAndGetEmail(): void
    {
        $user = new User();
        $user->setEmail('billy@example.com');
        $this->assertEquals('billy@example.com', $user->getEmail());
    }
}