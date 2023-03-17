<?php

namespace Leads\Sentry\Entities;

use Sentry\UserDataBag;

/**
 * Пользователь/клиент затронутый проблемой
 *
 * @link https://docs.sentry.io/platforms/php/enriching-events/identify-user/
 */
class User
{
    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $segment например группа пользователя
     */
    public function __construct(int $id, string $username = '', string $email = '', string $segment = '')
    {
        $this->sentryUser = UserDataBag::createFromArray([
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'segment' => $segment
        ]);
    }

    public function getSentryUser(): UserDataBag
    {
        return $this->sentryUser;
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    /** @var UserDataBag */
    private $sentryUser;
}
