<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

readonly class ScaleTargetReference implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public string $apiVersion = 'apps/v1',
        public string $kind = 'Deployment',
        public string|null $envSourceContainerName = null
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'apiVersion' => $this->apiVersion,
            'kind' => $this->kind,
            'envSourceContainerName' => $this->envSourceContainerName,
        ];
    }
}
