<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\MySQL;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\OneOf;

class MySQLTrigger extends AbstractTriggerBuilder
{
    /**
     * Format of connection string is "user:password@tcp(mysql:3306)/db_name"
     */
    private const CONNECTION_STRING = 'connectionString';
    private const CONNECTION_STRING_FROM_ENV = 'connectionStringFromEnv';
    private const HOST = 'host';
    private const HOST_FROM_ENV = 'hostFromEnv';
    private const QUERY = 'query';
    private const QUERY_VALUE = 'queryValue';
    private const ACTIVATION_QUERY_VALUE = 'activationQueryValue';
    private const PORT = 'port';
    private const PORT_FROM_ENV = 'portFromEnv';
    private const DB_NAME = 'dbName';
    private const USERNAME = 'username';
    private const PASSWORD = 'password';
    private const PASSWORD_FROM_ENV = 'passwordFromEnv';

    public function connectionString(string $connectionString): static
    {
        return $this->set(self::CONNECTION_STRING, $connectionString);
    }

    public function connectionStringFromEnv(string $envName): static
    {
        return $this->set(self::CONNECTION_STRING_FROM_ENV, $envName);
    }

    public function query(string $query): static
    {
        return $this->set(self::QUERY, $query);
    }

    public function queryValue(string $value): static
    {
        return $this->set(self::QUERY_VALUE, $value);
    }

    public function activationQueryValue(string $value): static
    {
        return $this->set(self::ACTIVATION_QUERY_VALUE, $value);
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
            OneOf::fromValues(self::CONNECTION_STRING, self::CONNECTION_STRING_FROM_ENV),
            self::QUERY,
            self::QUERY_VALUE,
            self::ACTIVATION_QUERY_VALUE,
        ];
    }

    protected static function type(): string
    {
        return 'mysql';
    }
}
