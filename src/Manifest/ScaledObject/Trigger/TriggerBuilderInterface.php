<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;

interface TriggerBuilderInterface
{
    public function build(): Trigger;
}
