<?php

namespace Leads\Sentry\Implementations;

use Leads\Sentry\Entities\Breadcrumb;
use Leads\Sentry\SentryAbstract;
use Leads\Sentry\SentryInterface;
use Leads\Sentry\Entities\User;

/**
 * Реализация клиента SentryHttp
 */
class SentryHttp extends SentryAbstract
{
    public function __construct(string $dsn, string $environment = 'production', string $release = '', array $tags = [])
    {
        \Sentry\init([
            'dsn' => $dsn,
            'environment' => $environment,
            'release' => $release,
        ]);

        foreach ($tags as $tagName => $tagValue) {
            $this->setTag($tagName, $tagValue);
        }
    }
}
