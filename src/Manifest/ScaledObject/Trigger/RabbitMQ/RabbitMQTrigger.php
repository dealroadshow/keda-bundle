<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\RabbitMQ;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\OneOf;

class RabbitMQTrigger extends AbstractTriggerBuilder
{
    private const HOST = 'host';
    private const HOST_FROM_ENV = 'hostFromEnv';
    private const QUEUE_NAME = 'queueName';
    private const MODE = 'mode';
    private const VALUE = 'value';
    private const ACTIVATION_VALUE = 'activationValue';

    public function queue(string $queueName): static
    {
        return $this->set(self::QUEUE_NAME, $queueName);
    }

    public function host(string $host): static
    {
        return $this->set(self::HOST, $host);
    }

    public function hostFromEnv(string $envName): static
    {
        return $this->set(self::HOST_FROM_ENV, $envName);
    }

    public function mode(Mode $mode): static
    {
        return $this->set(self::MODE, $mode->value);
    }

    public function value(int|float $value): static
    {
        return $this->set(self::VALUE, $value);
    }

    public function activationValue(int|float $value): static
    {
        return $this->set(self::ACTIVATION_VALUE, $value);
    }

    public static function forQueue(string $queueName): static
    {
        $instance = new static();
        $instance->queue($queueName);

        return $instance;
    }

    protected static function type(): string
    {
        return 'rabbitmq';
    }

    protected function requiredKeys(): array
    {
        return [
            self::VALUE,
            self::MODE,
            self::QUEUE_NAME,
            new OneOf(self::HOST, self::HOST_FROM_ENV),
        ];
    }
}
