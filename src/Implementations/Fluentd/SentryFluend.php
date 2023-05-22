<?php

namespace Leads\Sentry\Implementations\Fluentd;

use Fluent\Logger\FluentLogger;
use Leads\Sentry\SentryAbstract;
use Sentry\ClientBuilder;
use Sentry\SentrySdk;

class SentryFluend extends SentryAbstract
{
    public function __construct(
        string $dsn,
        FluentLogger $fluent,
        string $environment = 'production',
        string $release = '',
        array $tags = []
    ) {
        $client = ClientBuilder::create([
            'dsn' => $dsn,
            'environment' => $environment,
            'release' => $release,
        ]);
        $client->setTransportFactory(new TransportFluentFactory($fluent));

        SentrySdk::init()->bindClient($client->getClient());

        foreach ($tags as $tagName => $tagValue) {
            $this->setTag($tagName, $tagValue);
        }
    }
}