<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Cron;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;

class CronTrigger extends AbstractTriggerBuilder
{
    private const TIMEZONE = 'timezone';
    private const START = 'start';
    private const END = 'end';
    private const DESIRED_REPLICAS = 'desiredReplicas';

    public function timezone(\DateTimeZone $timezone): static
    {
        return $this->set(self::TIMEZONE, $timezone->getName());
    }

    public function start(string $cronSchedule): static
    {
        return $this->set(self::START, $cronSchedule);
    }

    public function end(string $cronSchedule): static
    {
        return $this->set(self::END, $cronSchedule);
    }

    public function desiredReplicas(int $desiredReplicas): static
    {
        return $this->set(self::DESIRED_REPLICAS, strval($desiredReplicas));
    }

    protected function requiredKeys(): array
    {
        return [
            self::TIMEZONE,
            self::START,
            self::END,
            self::DESIRED_REPLICAS,
        ];
    }

    protected static function type(): string
    {
        return 'cron';
    }
}
