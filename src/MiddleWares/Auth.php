<?php

namespace SM\MiddleWares;

use Simple\Core\Session;
use SM\Repos\Users\UserRepo;
use Simple\Core\DataAccess\MySQLAccess;

class Auth
{
    /**
     * Checks if the user has logged in
     * 
     * @return bool
     */
    public static function isAuthenticated()
    {
        return Session::has('user-id');
    }

    /**
     * Check user name and password from database
     * 
     * @param string $userName
     * @param string $password
     * @return array user data
     */
    public static function authenticate($userName, $password)
    {
        $repo = new UserRepo(new MySQLAccess());
        $user = $repo->getByNameAndPassword($userName, $password);
        if ($user !== null) {
            return [
                'user-id' => $user->getUserId(),
                'user-name' => $user->getUserName(),
                'user-full-name' => $user->getFullName(),
                'group-name' => $user->getGroupName(),
                'group-id' => $user->getGroupId(),
                'user-privileges' => $user->getPrivileges()
            ];
        }
        return [];
    }

    /**
     * Authorize the logged in user 
     * 
     * @param Simple\Core\Request $request the request object
     * @return bool
     */
    public static function authorize()
    {
        return true;
    }
}
