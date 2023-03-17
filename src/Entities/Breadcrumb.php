<?php

namespace Leads\Sentry\Entities;

/**
 * Хлебные крошки - события произошедшие до возникновения проблемы
 *
 * @link https://develop.sentry.dev/sdk/event-payloads/breadcrumbs/
 * @link https://docs.sentry.io/platforms/php/enriching-events/breadcrumbs/
 */
class Breadcrumb
{
    /**
     * @param string $level из констант класса SeverityLevel
     * @param string $category произвольное значения для указание модуля/категории события
     * @param string|null $message человекочитаемое сообщение о событии
     * @param array $metadata словарь дополнительных данных
     *
     * @see SeverityLevel
     */
    public function __construct(
        string $level,
        string $category,
        ?string $message = null,
        array $metadata = []
    ) {
        $this->sentryBreadcrumbs = new \Sentry\Breadcrumb(
            $level,
            \Sentry\Breadcrumb::TYPE_DEFAULT,
            $category,
            $message,
            $metadata,
            date(DATE_RFC3339)
        );
    }

    public function getSentryBreadcrumb(): \Sentry\Breadcrumb
    {
        return $this->sentryBreadcrumbs;
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    /** @var \Sentry\Breadcrumb */
    private $sentryBreadcrumbs;
}
