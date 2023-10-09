<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Metric\TargetType;

abstract class AbstractTriggerBuilder implements TriggerBuilderInterface
{
    protected Trigger $trigger;

    /**
     * @return string[]|OneOf[]
     */
    abstract protected function requiredKeys(): array;
    abstract protected static function type(): string;

    public function __construct()
    {
        $this->trigger = new Trigger(static::type());
    }

    public function build(): Trigger
    {
        foreach ($this->requiredKeys() as $requiredKey) {
            if ($requiredKey instanceof OneOf) {
                $this->ensureOneOfTheKeysIsSet($requiredKey->metadataKeys);

                continue;
            }

            $this->ensureMetadataKeyIsSet($requiredKey);
        }

        return $this->trigger;
    }

    public function metricType(TargetType $type): static
    {
        $this->trigger->metricType = $type;

        return $this;
    }

    protected function set(string $key, mixed $value): static
    {
        $this->trigger->metadata->add($key, $value);

        return $this;
    }

    protected function ensureOneOfTheKeysIsSet(array $keys): static
    {
        $meta = $this->trigger->metadata;
        $set = [];
        foreach ($keys as $key) {
            if ($meta->has($key)) {
                $set[] = $key;
            }
        }

        if (0 === count($set)) {
            throw new \LogicException(
                sprintf(
                    'You must provide one of keys ("%s"), but none provided',
                    implode('", "', $keys)
                )
            );
        } elseif (1 < count($set)) {
            throw new \LogicException(
                sprintf(
                    'You must provide only one of keys ("%s"), but "%s" provided',
                    implode('", "', $keys),
                    implode('", "', $set)
                )
            );
        }

        return $this;
    }

    protected function ensureMetadataKeyIsSet(string $key): static
    {
        if (!$this->trigger->metadata->has($key)) {
            throw new \LogicException(sprintf('You must provide "%s"', $key));
        }

        return $this;
    }
}
