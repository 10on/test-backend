<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Validator\UserValidator;
use App\Exception\UserException;

class UserValidatorTest extends TestCase
{
    private array $forbiddenWords = ['badword', 'forbidden'];
    private $unreliableDomains = ['unreliable.com', 'spam.com'];

    protected function setUp(): void
    {
        new UserValidator($this->forbiddenWords, $this->unreliableDomains);
    }

    public function testValidateNameSuccess(): void
    {
        $this->expectNotToPerformAssertions();
        UserValidator::validateName('somename');
    }

    public function testValidateNameFormatFails(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Invalid name format');
        UserValidator::validateName('short');
    }

    public function testValidateNameContainsForbiddenWordFails(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Name contains forbidden word');
        UserValidator::validateName('validbadwordname');
    }

    public function testValidateEmailSuccess(): void
    {
        $this->expectNotToPerformAssertions();
        UserValidator::validateEmail('validemail@example.com');
    }

    public function testValidateEmailFormatFails(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Invalid email format');
        UserValidator::validateEmail('invalid-email');
    }

    public function testValidateEmailDomainFails(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Email domain is unreliable');
        UserValidator::validateEmail('user@unreliable.com');
    }

    public function testValidateDeletedDateSuccess(): void
    {
        $this->expectNotToPerformAssertions();
        $created = new DateTime('2023-01-01');
        $deleted = new DateTime('2023-01-02');
        UserValidator::validateDeletedDate($created, $deleted);
    }

    public function testValidateDeletedDateFails(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Deleted date should be bigger or equal than created date');
        $created = new DateTime('2023-01-02');
        $deleted = new DateTime('2023-01-01');
        UserValidator::validateDeletedDate($created, $deleted);
    }
}