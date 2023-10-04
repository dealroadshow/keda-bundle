<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\ScaledObjectInterface;

interface ScalableWorkloadInterface
{
    public function scaledObject(): ScaledObjectInterface;
}
