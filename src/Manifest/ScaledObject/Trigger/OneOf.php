<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger;

final readonly class OneOf
{
    public array $metadataKeys;

    public function __construct(string ...$metadataKeys)
    {
        if (count($metadataKeys) < 2) {
            throw new \InvalidArgumentException('You must provide at least 2 metadata keys');
        }

        $this->metadataKeys = $metadataKeys;
    }
}
