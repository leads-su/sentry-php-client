<?php

namespace Leads\Sentry\Implementations;

use Leads\Sentry\Entities\Breadcrumb;
use Leads\Sentry\SentryInterface;
use Leads\Sentry\Entities\User;

/**
 * Реализация клиента Sentry
 */
class Sentry implements SentryInterface
{
    public function __construct(string $dsn, string $environment = 'production', array $tags = [])
    {
        \Sentry\init([
            'dsn' => $dsn,
            'environment' => $environment,
        ]);

        foreach ($tags as $tagName => $tagValue) {
            $this->setTag($tagName, $tagValue);
        }
    }

    /**
     * @inheritDoc
     */
    public function changeDsn(string $dsn): SentryInterface
    {
        \Sentry\SentrySdk::getCurrentHub()->bindClient(
            \Sentry\ClientBuilder::create(['dsn' => $dsn])->getClient()
        );
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSeverityLevel(string $severityLevel): SentryInterface
    {
        \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($severityLevel): void {
            $scope->setLevel(new \Sentry\Severity($severityLevel));
        });
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTag(string $tagName, string $tagValue): SentryInterface
    {
        \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($tagName, $tagValue): void {
            $scope->setTag($tagName, $tagValue);
        });
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setUser(User $user): SentryInterface
    {
        \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($user): void {
            $scope->setUser($user->getSentryUser());
        });
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addBreadcrumb(Breadcrumb $breadcrumb): SentryInterface
    {
        \Sentry\addBreadcrumb($breadcrumb->getSentryBreadcrumb());
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function captureException(\Exception $exception): string
    {
        return strval(\Sentry\captureException($exception));
    }

    /**
     * @inheritDoc
     */
    public function captureMessage(string $message, string $severityLevel = null): string
    {
        return strval(\Sentry\captureMessage($message, new \Sentry\Severity($severityLevel)));
    }
}
