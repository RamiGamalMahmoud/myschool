<?php

namespace SM\MiddleWares;

use config\DBConfig;
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
    Session::start();
    return Session::exists('userId');
  }
  /**
   * Check if the user is logged in
   * @param Simple\Core\Request $request the request object
   * @return bool
   */
  public static function authenticate(Request $request)
  {
    $params = $request->getRequestBody()['post'];
    $userName = isset($params['userName']) && !empty($params['userName']) ? $params['userName'] : false;
    $password = isset($params['password']) && !empty($params['password']) ? $params['password'] : false;

    if (!$userName) {
      exit('!! EMPTY USER NAME NOT ALLOWED !!');
    }

    if (!$password) {
      exit('!! EMPTY PASSWORD NOT ALLOWED !!');
    }

    $repo = new UsersRepo(new MySQLAccess(new DBConfig()));
    $data = $repo->auth($userName, $password);

    if ($data) {
      foreach ($data as $key => $value) {
        Session::start();
        Session::set($key, $value);
      }
      Session::set('userType', self::$usersTypes[$data['groupId']]);
      return true;
    }
    return false;
  }

  /**
   * Authorize the logged in user 
   * @param Simple\Core\Request $request the request object
   * @return bool
   */
  public static function authorize(Request $request)
  {
    $path = $request->getPath();
    $groupId = Session::get('groupId');

    $userType = explode('/', $path)[0];

    $groupType = self::$usersTypes[$groupId];

    return $groupType === $userType;
  }
}
