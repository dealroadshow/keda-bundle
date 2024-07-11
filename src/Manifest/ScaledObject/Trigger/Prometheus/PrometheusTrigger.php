<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Prometheus;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\AbstractTriggerBuilder;
use Dealroadshow\K8S\Framework\Util\Str;

class PrometheusTrigger extends AbstractTriggerBuilder
{
    // Required fields
    private const SERVER_ADDRESS = 'serverAddress';
    private const QUERY = 'query';
    private const THRESHOLD = 'threshold';
    private const ACTIVATION_THRESHOLD = 'activationThreshold';

    // Optional fields
    private const NAMESPACE = 'namespace';
    private const CUSTOM_HEADERS = 'customHeaders';
    private const IGNORE_NULL_VALUES = 'ignoreNullValues';
    private const QUERY_PARAMETERS = 'queryParameters';
    private const UNSAFE_SSL = 'unsafeSsl';

    private function __construct(string $query)
    {
        $this->set(self::QUERY, $query);

        parent::__construct();
    }

    public function serverAddress(string $serverAddress): static
    {
        $this->set(self::SERVER_ADDRESS, $serverAddress);

        return $this;
    }

    public function threshold(int|float $threshold): static
    {
        $this->set(self::THRESHOLD, $threshold);

        return $this;
    }

    public function activationThreshold(int|float $activationThreshold): static
    {
        $this->set(self::ACTIVATION_THRESHOLD, $activationThreshold);

        return $this;
    }

    public function namespace(string $namespace): static
    {
        $this->set(self::NAMESPACE, $namespace);

        return $this;
    }

    public function customHeaders(array $customHeaders): static
    {
        $this->set(self::CUSTOM_HEADERS, $this->mapToString($customHeaders));

        return $this;
    }

    public function ignoreNullValues(bool $ignoreNullValues): static
    {
        $this->set(self::IGNORE_NULL_VALUES, Str::stringify($ignoreNullValues));

        return $this;
    }

    public function queryParameters(array $queryParameters): static
    {
        $this->set(self::QUERY_PARAMETERS, $this->mapToString($queryParameters));

        return $this;
    }

    public function unsafeSsl(bool $unsafeSsl): static
    {
        $this->set(self::UNSAFE_SSL, Str::stringify($unsafeSsl));

        return $this;
    }

    public static function withQuery(string $query): static
    {
        return new static($query);
    }


    protected function requiredKeys(): array
    {
        return [
            self::SERVER_ADDRESS,
            self::QUERY,
            self::THRESHOLD,
            self::ACTIVATION_THRESHOLD,
        ];
    }

    protected static function type(): string
    {
        return 'prometheus';
    }

    private function mapToString(array $map): string
    {
        $expressions = [];
        foreach ($map as $name => $value) {
            $expressions[] = sprintf('%s=%s', $name, $value);
        }

        return implode(',', $expressions);
    }
}
