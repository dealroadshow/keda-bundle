<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

use Dealroadshow\K8S\Data\HorizontalPodAutoscalerBehavior;

class HPAConfig implements \JsonSerializable
{
    private string $name;
    private HorizontalPodAutoscalerBehavior $behavior;

    public function __construct()
    {
        $this->behavior = new HorizontalPodAutoscalerBehavior();
    }

    public function behavior(): HorizontalPodAutoscalerBehavior
    {
        return $this->behavior;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'behavior' => $this->behavior,
        ];
    }
}
