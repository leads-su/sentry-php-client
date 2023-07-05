<?php

namespace Leads\Sentry\Implementations\Fluentd;

use Fluent\Logger\FluentLogger;
use Leads\Sentry\Entities\IntegrationsOptions;
use Leads\Sentry\SentryAbstract;
use Sentry\ClientBuilder;
use Sentry\SentrySdk;

class SentryFluentd extends SentryAbstract
{
    public function __construct(
        string $dsn,
        IntegrationsOptions $integrations,
        FluentLogger $fluent,
        string $environment = 'production',
        string $release = '',
        array $tags = []
    ) {
        $client = ClientBuilder::create([
            'dsn' => $dsn,
            'environment' => $environment,
            'release' => $release,
            'default_integrations' => false,
            'integrations' => $this->getIntegrations($integrations),
        ]);
        $client->setTransportFactory(new TransportFluentFactory($fluent));

        SentrySdk::init()->bindClient($client->getClient());

        foreach ($tags as $tagName => $tagValue) {
            $this->setTag($tagName, $tagValue);
        }
    }
}