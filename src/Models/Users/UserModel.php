<?php

namespace SM\Models\Users;

use Simple\Helpers\DB;

class UserModel
{
    private $db;
    
    public function __construct($userName, $password)
    {
        $this->db = new DB($userName, $password);
    }

    public function login($userName, $password)
    {
        // TODO: encrypt the password
        $data = $this->db->select(['userId', 'userName', 'fullName', 'groupId'])
        ->from('users')
        ->where('userName', '=', $userName)
        ->andWhere('password', '=', $password)
        ->fetchFirst();

        return $data;
    }
}