<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\ResourceMaker;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaledObject;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaleTargetReference;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\Bundle\KedaBundle\Event\ScaledObjectGeneratedEvent;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\ScaledObjectInterface;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\ScaleTarget\WorkloadContainerReference;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuildersRegistry;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\BehaviorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\AbstractResourceMaker;
use Dealroadshow\K8S\Framework\Util\ClassName;
use Dealroadshow\K8S\Framework\Util\VersionedManifestReferencesService;

class ScaledObjectMaker extends AbstractResourceMaker
{
    public function __construct(
        private readonly VersionedManifestReferencesService $referencesService,
        private readonly TriggerBuildersRegistry $buildersRegistry
    ) {
    }

    protected function supportsClass(): string
    {
        return ScaledObjectInterface::class;
    }

    protected function makeResource(ManifestInterface|ScaledObjectInterface $manifest, AppInterface $app): ScaledObject
    {
        $scaledObject = new ScaledObject();
        $app->metadataHelper()->configureMeta($manifest, $scaledObject);

        $targetRef = $this->scaleTargetRef($manifest);
        $scaledObject->setScaleTargetRef($targetRef);
        $scaledObject
            ->setPollingInterval($manifest->pollingInterval())
            ->setCooldownPeriod($manifest->cooldownPeriod())
            ->setMinReplicaCount($manifest->minReplicaCount())
            ->setMaxReplicaCount($manifest->maxReplicaCount());

        if ($idleReplicaCount = $manifest->idleReplicaCount()) {
            $scaledObject->setIdleReplicaCount($idleReplicaCount);
        }

        if ($fallback = $manifest->fallback()) {
            $scaledObject->setFallback($fallback);
        }

        $advanced = $scaledObject->advanced();
        if (($restoreToOriginalReplicaCount = $manifest->restoreToOriginalReplicaCount()) !== null) {
            $advanced->setRestoreToOriginalReplicaCount($restoreToOriginalReplicaCount);
        }
        $hpaConfig = $advanced->horizontalPodAutoscalerConfig();
        if ($hpaName = $manifest->hpaName()) {
            $hpaConfig->setName($hpaName);
        }
        $behaviorConfigurator = new BehaviorConfigurator($advanced->horizontalPodAutoscalerConfig()->behavior());
        $manifest->behavior($behaviorConfigurator);

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

        $scaledObject->setTriggers($triggers);

        $manifest->configureScaledObject($scaledObject);

        $this->dispatcher->dispatch(new ScaledObjectGeneratedEvent($manifest, $scaledObject, $app), ScaledObjectGeneratedEvent::NAME);

        return $scaledObject;
    }

    private function scaleTargetRef(ScaledObjectInterface $manifest): ScaleTargetReference
    {
        $scaleTargetRef = $manifest->scaleTargetRef();
        if ($scaleTargetRef instanceof WorkloadContainerReference) {
            $objectRef = $this->referencesService->toCrossVersionObjectReference($scaleTargetRef->manifestReference);
            $scaleTargetRef = new ScaleTargetReference(
                name: $objectRef->getName(),
                apiVersion: $objectRef->getApiVersion(),
                kind: $objectRef->getKind(),
                envSourceContainerName: $scaleTargetRef->containerName
            );
        }

        return $scaleTargetRef;
    }
}
