<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

class ScaleTrigger implements \JsonSerializable
{
    public AuthenticationReference|null $authenticationRef = null;
    public readonly \ArrayObject $metadata;

    public function __construct(public readonly string $type)
    {
        $this->metadata = new \ArrayObject();
    }


    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'authenticationRef' => $this->authenticationRef,
            'metadata' => $this->metadata,
        ];
    }
}
