<?php

namespace Leads\Sentry\Entities;

use Sentry\Integration\ErrorListenerIntegration;
use Sentry\Integration\ExceptionListenerIntegration;
use Sentry\Integration\FatalErrorListenerIntegration;
use Sentry\Integration\ModulesIntegration;

/**
 * Включение/отключение интеграций клиента Sentry
 *
 * @link https://docs.sentry.io/platforms/php/integrations/
 */
class IntegrationsOptions
{
    //**********************************************************************
    // Интеграции автоматической обработки ошибок и неперехваченных исключений:
    // - ExceptionListenerIntegration
    // - ErrorListenerIntegration
    // - FatalErrorListenerIntegration
    //**********************************************************************

    /**
     * Установить вкл/выкл интеграций автоматической обработки ошибок и неперехваченных исключений
     *  - ErrorListenerIntegration
     *  - FatalErrorListenerIntegration
     *
     * @param bool $enable
     * @return $this
     */
    public function setAutoHandler(bool $enable): self
    {
        $this->autoHandler = $enable;
        return $this;
    }

    /**
     * Получить статус вкл/выкл интеграций автоматической обработки ошибок и неперехваченных исключений
     *
     * @return bool
     */
    public function getAutoHandler(): bool
    {
        return $this->autoHandler;
    }

    //**********************************************************************
    // Интеграция сбора инфомрации об используемых пакетах ModulesIntegration
    //**********************************************************************

    /**
     * Установить вкл/выкл интеграции сбора информации об используемых пакетах
     *
     * @param bool $enable
     * @return $this
     */
    public function setPackageCollector(bool $enable): self
    {
        $this->packageCollector = $enable;
        return $this;
    }

    /**
     * Получить статус вкл/выкл интеграции сбора информации об используемых пакетах
     *
     * @return bool
     */
    public function getPackageCollector(): bool
    {
        return $this->packageCollector;
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    private $autoHandler = true;
    private $packageCollector = true;
}
