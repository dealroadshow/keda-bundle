<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

readonly class Fallback implements \JsonSerializable
{
    public function __construct(public int $failureThreshold, public int $replicas)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'failureThreshold' => $this->failureThreshold,
            'replicas' => $this->replicas,
        ];
    }
}
