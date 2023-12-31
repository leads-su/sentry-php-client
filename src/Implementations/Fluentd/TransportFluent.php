<?php

namespace Leads\Sentry\Implementations\Fluentd;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectedPromise;
use Sentry\Event;
use Sentry\Options;
use Sentry\Response;
use Sentry\ResponseStatus;
use \Sentry\Serializer\PayloadSerializerInterface;
use \Sentry\Transport\TransportInterface;
use \Fluent\Logger\FluentLogger;

/**
 * Реализация транспорта событий в Sentry через fluentd
 */
class TransportFluent implements TransportInterface
{
    public function __construct(
        Options $options,
        PayloadSerializerInterface $payloadSerializer,
        FluentLogger $fluentd
    ) {
        $this->options = $options;
        $this->fluentd = $fluentd;
        $this->payloadSerializer = $payloadSerializer;
    }

    /**
     * @inheritDoc
     */
    public function send(Event $event): PromiseInterface
    {
        $dsn = $this->options->getDsn();

        $json = $this->payloadSerializer->serialize($event);
        $payload = json_decode($json, true);

        $tag = sprintf(
            'sentry.store.%s.%s',
            $dsn->getProjectId(true),
            $dsn->getPublicKey()
        );

        if ($this->fluentd->post($tag, $payload)) {
            return new FulfilledPromise(
                new Response(ResponseStatus::createFromHttpStatusCode(200), $event)
            );
        } else {
            return new RejectedPromise(new Response(ResponseStatus::failed(), $event));
        }
    }

    /**
     * @inheritDoc
     */
    public function close(?int $timeout = null): PromiseInterface
    {
        return new FulfilledPromise(true);
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    /** @var Options  */
    private $options;

    /** @var FluentLogger */
    private $fluentd;

    /** @var PayloadSerializerInterface */
    private $payloadSerializer;
}
