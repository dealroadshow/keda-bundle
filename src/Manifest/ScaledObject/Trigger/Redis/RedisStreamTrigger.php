<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Redis;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\OneOf;

class RedisStreamTrigger extends AbstractTriggerBuilder
{
    private const ADDRESS = 'address';
    private const HOST = 'host';
    private const PORT = 'port';
    private const USERNAME_FROM_ENV = 'usernameFromEnv';
    private const PASSWORD_FROM_ENV = 'passwordFromEnv';
    private const STREAM = 'stream';
    private const CONSUMER_GROUP = 'consumerGroup';
    private const PENDING_ENTRIES_COUNT = 'pendingEntriesCount';
    private const STREAM_LENGTH = 'streamLength';
    private const LAG_COUNT = 'lagCount';
    private const ACTIVATION_LAG_COUNT = 'activationLagCount';
    private const ENABLE_TLS = 'enableTLS';
    private const UNSAFE_SSL = 'unsafeSsl';
    private const DATABASE_INDEX = 'databaseIndex';
    private const ADDRESS_FROM_ENV = 'addressFromEnv';
    private const HOST_FROM_ENV = 'hostFromEnv';
    private const PORT_FROM_ENV = 'portFromEnv';

    private string|null $triggerName = null;

    public function address(string $address): static
    {
        return $this->set(self::ADDRESS, $address);
    }

    public function host(string $host): static
    {
        return $this->set(self::HOST, $host);
    }

    public function port(int|string $port): static
    {
        return $this->set(self::PORT, $port);
    }

    public function usernameFromEnv(string $envVarName): static
    {
        return $this->set(self::USERNAME_FROM_ENV, $envVarName);
    }

    public function passwordFromEnv(string $envVarName): static
    {
        return $this->set(self::PASSWORD_FROM_ENV, $envVarName);
    }

    public function stream(string $stream): static
    {
        return $this->set(self::STREAM, $stream);
    }

    public function consumerGroup(string $consumerGroup): static
    {
        return $this->set(self::CONSUMER_GROUP, $consumerGroup);
    }

    public function pendingEntriesCount(int|string $pendingEntriesCount): static
    {
        return $this->setTrigger(self::PENDING_ENTRIES_COUNT, $pendingEntriesCount);
    }

    public function streamLength(int|string $streamLength): static
    {
        return $this->setTrigger(self::STREAM_LENGTH, $streamLength);
    }

    public function lagCount(int|string $lagCount): static
    {
        return $this->setTrigger(self::LAG_COUNT, $lagCount);
    }

    public function activationLagCount(int|string $activationLagCount): static
    {
        return $this->set(self::ACTIVATION_LAG_COUNT, $activationLagCount);
    }

    public function enableTLS(bool $enableTLS): static
    {
        return $this->set(self::ENABLE_TLS, $enableTLS);
    }

    public function unsafeSsl(bool $unsafeSsl): static
    {
        return $this->set(self::UNSAFE_SSL, $unsafeSsl);
    }

    public function databaseIndex(int|string $databaseIndex): static
    {
        return $this->set(self::DATABASE_INDEX, $databaseIndex);
    }

    public function addressFromEnv(string $envVarName): static
    {
        return $this->set(self::ADDRESS_FROM_ENV, $envVarName);
    }

    public function hostFromEnv(string $envVarName): static
    {
        return $this->set(self::HOST_FROM_ENV, $envVarName);
    }

    public function portFromEnv(int|string $envVarName): static
    {
        return $this->set(self::PORT_FROM_ENV, $envVarName);
    }

    public static function forStream(string $stream): static
    {
        $instance = new static();
        $instance->stream($stream);

        return $instance;
    }

    protected function requiredKeys(): array
    {
        return [
            new OneOf(self::ADDRESS, self::ADDRESS_FROM_ENV),
            new OneOf(self::PENDING_ENTRIES_COUNT, self::STREAM_LENGTH, self::LAG_COUNT),
            self::PASSWORD_FROM_ENV,
            self::STREAM,
        ];
    }

    protected static function type(): string
    {
        return 'redis-streams';
    }

    private function setTrigger(string $triggerName, int|string $triggerValue): static
    {
        if ($this->triggerName !== null && $this->triggerName !== $triggerName) {
            throw new \LogicException(sprintf('Scale trigger is already set to "%s" and cannot be rewritten with the new value "%s".', $this->triggerName, $triggerName));
        }

        $this->triggerName = $triggerName;

        return $this->set($triggerName, $triggerValue);
    }
}
