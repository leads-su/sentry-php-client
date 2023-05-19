<?php

namespace Leads\Sentry\Implementations\Fluentd;

use Fluent\Logger\FluentLogger;
use Leads\Sentry\SentryAbstract;

class SentryFluend extends SentryAbstract
{
    public function __construct(
        string $dsn,
        FluentLogger $fluent,
        string $environment = 'production',
        string $release = '',
        array $tags = []
    ) {
        $client = \Sentry\ClientBuilder::create([
            'dsn' => $dsn,
            'environment' => $environment,
            'release' => $release,
        ]);
        $client->setTransportFactory(new TransportFluentFactory($fluent));

        \Sentry\SentrySdk::init()->bindClient($client->getClient());

        foreach ($tags as $tagName => $tagValue) {
            $this->setTag($tagName, $tagValue);
        }
    }
}