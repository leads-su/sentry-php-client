<?php

namespace Leads\Sentry;

use Leads\Sentry\Entities\Breadcrumb;
use Leads\Sentry\Entities\IntegrationsOptions;
use Leads\Sentry\Entities\User;
use Sentry\Integration\EnvironmentIntegration;
use Sentry\Integration\ErrorListenerIntegration;
use Sentry\Integration\ExceptionListenerIntegration;
use Sentry\Integration\FrameContextifierIntegration;
use Sentry\Integration\IntegrationInterface;
use Sentry\Integration\ModulesIntegration;
use Sentry\Integration\RequestIntegration;

/**
 * Реализация основных методов Sentry клиента, конструирование остается на наследниках
 */
class SentryAbstract implements SentryInterface
{
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
    public function captureException(\Throwable $e): string
    {
        return strval(\Sentry\captureException($e));
    }

    /**
     * @inheritDoc
     */
    public function captureMessage(string $message, string $severityLevel = null): string
    {
        return strval(\Sentry\captureMessage($message, new \Sentry\Severity($severityLevel)));
    }

    //######################################################################
    // PROTECTED
    //######################################################################

    /**
     * Получить массив необходимых интеграций для клиента Sentry
     *
     * @param IntegrationsOptions $intOptions
     * @return array<IntegrationInterface>
     */
    protected function getIntegrations(IntegrationsOptions $intOptions): array
    {
        $integrations = [
            new RequestIntegration(),
            new FrameContextifierIntegration(),
            new EnvironmentIntegration(),
        ];

        if ($intOptions->getAutoHandler()) {
            $integrations[] = new ExceptionListenerIntegration();
            $integrations[] = new ErrorListenerIntegration();
            $integrations[] = new FatalErrorListenerIntegration();
        }

        if ($intOptions->getPackages()) {
            $integrations[] = new ModulesIntegration();
        }

        return $integrations;
    }
}
