<?php

namespace Leads\Sentry\Implementations;

use Leads\Sentry\Entities\IntegrationsOptions;
use Leads\Sentry\SentryAbstract;

/**
 * Реализация клиента SentryHttp
 */
class SentryHttp extends SentryAbstract
{
    public function __construct(
        string $dsn,
        IntegrationsOptions $integrations,
        string $environment = 'production',
        string $release = '',
        array $tags = []
    ) {
        \Sentry\init([
            'dsn' => $dsn,
            'environment' => $environment,
            'release' => $release,
            'default_integrations' => false,
            'integrations' => $this->getIntegrations($integrations),
        ]);

        foreach ($tags as $tagName => $tagValue) {
            $this->setTag($tagName, $tagValue);
        }
    }
}
