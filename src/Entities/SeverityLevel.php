<?php

namespace Leads\Sentry\Entities;

/**
 * Уровень сторогости сообщения
 */
class SeverityLevel
{
    public const DEBUG = 'debug';

    public const INFO = 'info';

    public const WARNING = 'warning';

    public const ERROR = 'error';

    public const FATAL = 'fatal';
}
