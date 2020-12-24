<?php

namespace SM\Services;

use Simple\Core\Session;

/**
 * Manage Users data in local storage [sessions, cockies, local storage]
 */
class SessionUserData
{
    /**
     * Get the user name from sessions
     * @return string ther user name
     */
    public function getUserName()
    {
        Session::start();
        return Session::get('fullName');
    }
}
