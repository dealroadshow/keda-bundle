<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\RabbitMQ;

enum Mode: string
{
    case QueueLength = 'QueueLength';
    case MessageRate = 'MessageRate';
}
