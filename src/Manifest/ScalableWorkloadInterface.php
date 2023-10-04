<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaledObject;

interface ScalableWorkloadInterface
{
    public function scaledObject(): ScaledObject;
}
