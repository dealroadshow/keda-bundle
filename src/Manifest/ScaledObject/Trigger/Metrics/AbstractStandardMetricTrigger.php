<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Metrics;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;

abstract class AbstractStandardMetricTrigger extends AbstractTriggerBuilder
{
    private const CONTAINER_NAME = 'containerName';
    private const VALUE = 'value';

    public function value(int $value): static
    {
        return $this->set(self::VALUE, $value);
    }

    public function containerName(string $containerName): static
    {
        return $this->set(self::CONTAINER_NAME, $containerName);
    }

    public static function withValue(int $value): static
    {
        $instance = new static();
        $instance->value($value);

        return $instance;
    }

    protected function requiredKeys(): array
    {
        return [self::VALUE];
    }
}
