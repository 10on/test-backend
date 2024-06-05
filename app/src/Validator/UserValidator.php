<?php declare(strict_types=1);

namespace App\Validator;

use App\Exception\UserException;

class UserValidator
{
    private static array $forbiddenWords;
    private static array $unreliableDomains;

    public function __construct(array $forbiddenWords, array $unreliableDomains)
    {
        $this::$forbiddenWords = $forbiddenWords;
        $this::$unreliableDomains = $unreliableDomains;
    }

    public static function validateName(string $name): void
    {
        if (!preg_match('/^[a-z0-9]{8,}$/', $name)) {
            throw new UserException('Invalid name format');
        }
        foreach (self::$forbiddenWords as $word) {
            if (str_contains($name, $word) !== false) {
                throw new UserException('Name contains forbidden word');
            }
        }
    }

    public static function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new UserException('Invalid email format');
        }
        $domain = substr(strrchr($email, "@"), 1);
        if (in_array($domain, self::$unreliableDomains)) {
            throw new UserException('Email domain is unreliable');
        }
    }

    public static function validateDeletedDate(\DateTime $created, ?\DateTime $deleted): void
    {
        if ($deleted !== null && $deleted < $created) {
            throw new UserException('Deleted date should be bigger or equal than created date');
        }
    }
}
