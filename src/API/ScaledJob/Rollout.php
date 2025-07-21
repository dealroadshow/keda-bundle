<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledJob;

final class Rollout implements \JsonSerializable
{
    private string $strategy = 'default';
    private string $propagationPolicy = 'background';

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function setStrategy(string $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function getPropagationPolicy(): string
    {
        return $this->propagationPolicy;
    }

    public function setPropagationPolicy(string $propagationPolicy): void
    {
        $this->propagationPolicy = $propagationPolicy;
    }

    public function jsonSerialize(): array
    {
        return [
            'strategy' => $this->strategy,
            'propagationPolicy' => $this->propagationPolicy,
        ];
    }
}
