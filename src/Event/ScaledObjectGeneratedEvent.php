<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Event;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaledObject;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\ScaledObjectInterface;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Event\ManifestGeneratedEventInterface;

readonly class ScaledObjectGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.scaled_object';

    public function __construct(private ScaledObjectInterface $manifest, private ScaledObject $apiResource, private AppInterface $app)
    {
    }

    public function manifest(): ManifestInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->apiResource;
    }

    public function scaledObject(): ScaledObject
    {
        return $this->apiResource;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
