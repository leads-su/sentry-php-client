<?php

namespace Leads\Sentry;
use Leads\Sentry\Entities\Breadcrumb;
use Leads\Sentry\Entities\User;

/**
 * Интерфейс клиента Sentry
 */
interface SentryInterface
{
    /**
     * Установить уровень строгости оповещения
     *
     * @param string $severityLevel
     * @return $this
     *
     * @see \Leads\Sentry\Entities\SeverityLevel
     */
    public function setSeverityLevel(string $severityLevel): self;

    /**
     * Установить тег
     *
     * @param string $tagName
     * @param string $tagValue
     * @return $this
     */
    public function setTag(string $tagName, string $tagValue): self;

    /**
     * Установить пользователя/клиента
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self;

    /**
     * Добавить логический этап исполнения в стэк операций
     *
     * @param Breadcrumb $breadcrumb
     * @return $this
     */
    public function addBreadcrumb(Breadcrumb $breadcrumb): self;

    //######################################################################

    /**
     * Отправка исключения/ошибки в Sentry
     * @param \Throwable $e
     * @return string
     */
    public function captureException(\Throwable $e): string;

    /**
     * Отправка сообщения в Sentry
     *
     * @param string $message
     * @param string|null $severityLevel уровень строгости оповещения
     * @return string
     *
     * @see \Leads\Sentry\Entities\SeverityLevel
     */
    public function captureMessage(string $message, string $severityLevel = null): string;
}
