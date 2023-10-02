<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\ScaleTarget;

use Dealroadshow\K8S\Framework\Core\VersionedManifestReference;

final readonly class WorkloadContainerReference
{
    public function __construct(
        public VersionedManifestReference $manifestReference,
        public string|null $containerName = null
    ) {
    }
}
