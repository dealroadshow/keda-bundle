<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Redis;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\OneOf;

class RedisTrigger extends AbstractTriggerBuilder
{
    private const ADDRESS = 'address';
    private const ADDRESS_FROM_ENV = 'addressFromEnv';
    private const USERNAME = 'username';
    private const USERNAME_FROM_ENV = 'usernameFromEnv';
    private const PASSWORD = 'password';
    private const PASSWORD_FROM_ENV = 'passwordFromEnv';
    private const LIST_NAME = 'listName';
    private const LIST_LENGTH = 'listLength';
    private const ACTIVATION_LIST_LENGTH = 'activationListLength';
    private const ENABLE_TLS = 'enableTLS';
    private const UNSAFE_SSL = 'unsafeSsl';
    private const DATABASE_INDEX = 'databaseIndex';

    protected function requiredKeys(): array
    {
        return [
            new OneOf(self::ADDRESS, self::ADDRESS_FROM_ENV),
            new OneOf(self::PASSWORD, self::PASSWORD_FROM_ENV),
            self::LIST_NAME,
            self::LIST_LENGTH,
        ];
    }

    public function address(string $address): static
    {
        return $this->set(self::ADDRESS, $address);
    }

    public function addressFromEnv(string $envName): static
    {
        return $this->set(self::ADDRESS_FROM_ENV, $envName);
    }

    public function username(string $username): static
    {
        return $this->set(self::USERNAME, $username);
    }

    public function usernameFromEnv(string $envName): static
    {
        return $this->set(self::USERNAME_FROM_ENV, $envName);
    }

    public function password(string $password): static
    {
        return $this->set(self::PASSWORD, $password);
    }

    public function passwordFromEnv(string $envName): static
    {
        return $this->set(self::PASSWORD_FROM_ENV, $envName);
    }

    public function listName(string $listName): static
    {
        return $this->set(self::LIST_NAME, $listName);
    }

    public function listLength(int $length): static
    {
        return $this->set(self::LIST_LENGTH, $length);
    }

    public function activationListLength(int $length): static
    {
        return $this->set(self::ACTIVATION_LIST_LENGTH, $length);
    }

    public function enableTLS(bool $value): static
    {
        return $this->set(self::ENABLE_TLS, $value);
    }

    public function unsafeSsl(bool $value): static
    {
        return $this->set(self::UNSAFE_SSL, $value);
    }

    public function databaseIndex(int $index): static
    {
        return $this->set(self::DATABASE_INDEX, $index);
    }

    public static function forList(string $listName): static
    {
        $instance = new static();
        $instance->listName($listName);

        return $instance;
    }

    protected static function type(): string
    {
        return 'redis';
    }
}
