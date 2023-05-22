<?php

namespace Leads\Sentry\Implementations\Fluentd;

use Fluent\Logger\FluentLogger;
use Sentry\Options;
use \Sentry\Serializer\PayloadSerializer;
use \Sentry\Transport\TransportFactoryInterface;
use Sentry\Transport\TransportInterface;

class TransportFluentFactory implements TransportFactoryInterface
{
    public function __construct(FluentLogger $fluent)
    {
        $this->fluent = $fluent;
    }

    public function create(Options $options): TransportInterface
    {
        return new TransportFluent(
            $options,
            new PayloadSerializer($options),
            $this->fluent
        );
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    /** @var FluentLogger */
    private $fluent;
}
