<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\PostgreSQL;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\OneOf;

class PostgreSQLTrigger extends AbstractTriggerBuilder
{
    private const CONNECTION = 'connection';
    private const CONNECTION_FROM_ENV = 'connectionFromEnv';
    private const QUERY = 'query';
    private const TARGET_QUERY_VALUE = 'targetQueryValue';
    private const ACTIVATION_TARGET_QUERY_VALUE = 'activationTargetQueryValue';

    public function connection(string $connectionString): static
    {
        return $this->set(self::CONNECTION, $connectionString);
    }

    public function connectionFromEnv(string $envName): static
    {
        return $this->set(self::CONNECTION_FROM_ENV, $envName);
    }

    public function query(string $query): static
    {
        return $this->set(self::QUERY, $query);
    }

    public function targetQueryValue(int|float $value): static
    {
        return $this->set(self::TARGET_QUERY_VALUE, $value);
    }

    public function activationTargetQueryValue(int|float $value): static
    {
        return $this->set(self::ACTIVATION_TARGET_QUERY_VALUE, $value);
    }

    public static function withQuery(string $query): static
    {
        $instance = new static();
        $instance->query($query);

        return $instance;
    }

    protected function requiredKeys(): array
    {
        return [
            OneOf::fromValues(self::CONNECTION, self::CONNECTION_FROM_ENV),
            self::QUERY,
            self::TARGET_QUERY_VALUE,
            self::ACTIVATION_TARGET_QUERY_VALUE,
        ];
    }

    protected static function type(): string
    {
        return 'postgresql';
    }
}
