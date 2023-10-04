<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\RabbitMQ;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuilderInterface;

class RabbitMQTrigger implements TriggerBuilderInterface
{
    private const TRIGGER_TYPE = 'rabbitmq';
    private const METADATA_KEY_HOST = 'host';
    private const METADATA_KEY_HOST_FROM_ENV = 'hostFromEnv';
    private const METADATA_KEY_QUEUE_NAME = 'queueName';
    private const METADATA_KEY_MODE = 'mode';
    private const METADATA_KEY_VALUE = 'value';
    private const METADATA_KEY_ACTIVATION_VALUE = 'activationValue';
    private Trigger $trigger;

    private function __construct(string $queueName)
    {
        $this->trigger = new Trigger(self::TRIGGER_TYPE);
        $this->trigger->metadata->add(self::METADATA_KEY_QUEUE_NAME, $queueName);
    }

    public function host(string $host): static
    {
        $this->trigger->metadata->add(self::METADATA_KEY_HOST, $host);

        return $this;
    }

    public function hostFromEnv(string $envName): static
    {
        $this->trigger->metadata->add(self::METADATA_KEY_HOST_FROM_ENV, $envName);

        return $this;
    }

    public function mode(Mode $mode): static
    {
        $this->trigger->metadata->add(self::METADATA_KEY_MODE, $mode->value);

        return $this;
    }

    public function value(int|float $value): static
    {
        $this->trigger->metadata->add(self::METADATA_KEY_VALUE, $value);

        return $this;
    }

    public function activationValue(int|float $value): static
    {
        $this->trigger->metadata->add(self::METADATA_KEY_ACTIVATION_VALUE, $value);

        return $this;
    }


    public function build(): Trigger
    {
        $this->ensureHostIsSet();
        $this->ensureMetadataKeyIsSet(self::METADATA_KEY_VALUE);
        $this->ensureMetadataKeyIsSet(self::METADATA_KEY_MODE);

        return $this->trigger;
    }

    public static function forQueue(string $queueName): static
    {
        return new static($queueName);
    }

    private function ensureHostIsSet(): void
    {
        $meta = $this->trigger->metadata;
        if (!$meta->has(self::METADATA_KEY_HOST) && !$meta->has(self::METADATA_KEY_HOST_FROM_ENV)) {
            throw new \LogicException(
                sprintf(
                    'You must provide either "%s" or "%s", but none provided',
                    self::METADATA_KEY_HOST,
                    self::METADATA_KEY_HOST_FROM_ENV
                )
            );
        }

        if ($meta->has(self::METADATA_KEY_HOST) && $meta->has(self::METADATA_KEY_HOST_FROM_ENV)) {
            throw new \LogicException(
                sprintf(
                    'You must provide either "%s" or "%s", but both provided',
                    self::METADATA_KEY_HOST,
                    self::METADATA_KEY_HOST_FROM_ENV
                )
            );
        }
    }

    private function ensureMetadataKeyIsSet(string $key): void
    {
        if (!$this->trigger->metadata->has($key)) {
            throw new \LogicException(sprintf('You must provide "%s"', $key));
        }
    }
}
