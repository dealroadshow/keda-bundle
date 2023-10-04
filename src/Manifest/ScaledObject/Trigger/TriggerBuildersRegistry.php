<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger;

final class TriggerBuildersRegistry
{
    /**
     * @var TriggerBuilderInterface[]
     */
    private array $map = [];

    /**
     * @param TriggerBuilderInterface[] $builders
     */
    public function __construct(iterable $builders)
    {
        foreach ($builders as $builder) {
            if (!$builder instanceof TriggerBuilderInterface) {
                throw new \InvalidArgumentException(sprintf('Each builder must be an instance of %s', TriggerBuilderInterface::class));
            }

            $this->map[$builder::class] = $builder;
        }
    }

    public function get(string $builderClass): TriggerBuilderInterface|null
    {
        return $this->map[$builderClass] ?? null;
    }
}
