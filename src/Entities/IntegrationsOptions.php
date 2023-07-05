<?php

namespace Leads\Sentry\Entities;

/**
 * Включение/отключение интеграций клиента Sentry
 * https://docs.sentry.io/platforms/php/integrations/
 */
class IntegrationsOptions
{
    public function setAutoHandler(bool $enable): self
    {
        $this->autoHandler = $enable;
        return $this;
    }

    public function getAutoHandler(): bool
    {
        return $this->autoHandler;
    }

    //**********************************************************************

    public function setPackages(bool $enable): self
    {
        $this->packages = $enable;
        return $this;
    }

    public function getPackages(): bool
    {
        return $this->packages;
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    private $autoHandler = true;
    private $packages = true;
}
