<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\ResourceMaker;

use Dealroadshow\Bundle\KedaBundle\API\ScaledJob\ScaledJob;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\Bundle\KedaBundle\Event\ScaledJobGeneratedEvent;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator\RolloutConfigurator;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator\ScalingStrategyConfigurator;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\ScaledJobInterface;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuildersRegistry;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\AbstractResourceMaker;
use Dealroadshow\K8S\Framework\Util\ClassName;

class ScaledJobMaker extends AbstractResourceMaker
{
    public function __construct(private readonly TriggerBuildersRegistry $buildersRegistry)
    {
    }

    protected function supportsClass(): string
    {
        return ScaledJobInterface::class;
    }

    protected function makeResource(ManifestInterface|ScaledJobInterface $manifest, AppInterface $app): ScaledJob
    {
        $jobTargetRef = $manifest->jobTargetRef();

        $scaledJob = new ScaledJob($jobTargetRef);
        $app->metadataHelper()->configureMeta($manifest, $scaledJob);

        if ($envSourceContainerName = $manifest->envSourceContainerName()) {
            $scaledJob->setEnvSourceContainerName($envSourceContainerName);
        }

        $scaledJob
            ->setPollingInterval($manifest->pollingInterval())
            ->setSuccessfulJobsHistoryLimit($manifest->successfulJobsHistoryLimit())
            ->setFailedJobsHistoryLimit($manifest->failedJobsHistoryLimit())
            ->setMinReplicaCount($manifest->minReplicaCount())
            ->setMaxReplicaCount($manifest->maxReplicaCount());

        $scalingStrategy = new ScalingStrategyConfigurator($scaledJob->scalingStrategy());
        $manifest->scalingStrategy($scalingStrategy);

        $rollout = new RolloutConfigurator($scaledJob->rollout());
        $manifest->rollout($rollout);

        $triggers = [];
        foreach ($manifest->triggers($this->buildersRegistry) as $trigger) {
            if (!$trigger instanceof Trigger) {
                throw new \TypeError(
                    sprintf(
                        'Each element of %s::triggers() must be an instance of %s, %s given',
                        ClassName::real($manifest),
                        Trigger::class,
                        is_object($trigger) ? $trigger::class : gettype($trigger)
                    )
                );
            }

            $triggers[] = $trigger;
        }

        $scaledJob->setTriggers($triggers);

        $manifest->configureScaledJob($scaledJob);

        $this->dispatcher->dispatch(
            new ScaledJobGeneratedEvent($manifest, $scaledJob, $app),
            ScaledJobGeneratedEvent::NAME
        );

        return $scaledJob;
    }
}
