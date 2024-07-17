<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Metric\TargetType;
use Dealroadshow\K8S\Framework\Util\StringMapProxy;

class Trigger implements \JsonSerializable
{
    public AuthenticationReference|null $authenticationRef = null;
    public readonly StringMap $metadata;
    public TargetType|null $metricType = null;
    public bool $useCachedMetrics = false;

    public function __construct(public readonly string $type)
    {
        $this->metadata = StringMapProxy::make(new StringMap());
    }


    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'metricType' => $this->metricType?->value,
            'authenticationRef' => $this->authenticationRef,
            'metadata' => $this->metadata,
        ];
    }
}
