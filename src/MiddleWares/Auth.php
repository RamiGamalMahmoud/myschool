<?php

namespace SM\MiddleWares;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Request;
use Simple\Core\Session;
use SM\Repos\Users\UsersRepo;

class Auth
{
    private static array $usersTypes = [
        'admin',
        'exams',
        'student',
        'employee',
        'employeesAffairs',
        'studentAffairs'
    ];

    public function isAuthenticated()
    {
        return Session::has('user-id');
    }
    /**
     * Check if the user is logged in
     * @param Simple\Core\Request $request the request object
     * @return array
     */
    public static function authenticate($userName, $password)
    {
        $repo = new UsersRepo(new MySQLAccess());
        $user = $repo->getByNameAndPassword($userName, $password);
        if ($user !== null) {
            return [
                'user-id' => $user->getUserId(),
                'user-name' => $user->getUserName(),
                'user-full-name' => $user->getFullName(),
                'user-type' => self::$usersTypes[$user->getGroupId()]
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
    public static function authorize(Request $request)
    {
        return true;
    }
}
