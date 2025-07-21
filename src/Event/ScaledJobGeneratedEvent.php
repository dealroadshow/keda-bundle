<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Event;

use Dealroadshow\Bundle\KedaBundle\API\ScaledJob\ScaledJob;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\ScaledJobInterface;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Event\ManifestGeneratedEventInterface;

readonly class ScaledJobGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.scaled_job';

    public function __construct(
        private ScaledJobInterface $manifest,
        private ScaledJob $apiResource,
        private AppInterface $app
    ) {
    }

    public function manifest(): ManifestInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->apiResource;
    }

    public function scaledJob(): ScaledJob
    {
        return $this->apiResource;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
