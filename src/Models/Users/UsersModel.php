<?php

namespace SM\Models\Users;

use Simple\Helpers\DB;
use SM\Models\BaseModel;

class UsersModel extends BaseModel
{
    /**
     * getAll()
     * findById(id)
     * insert(User)
     * update(User)
     * delete(id)
     */

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAll()
    {
        return $this->db->select(['userName', 'userId', 'fullName', 'groupId'])
        ->from('users')->fetch();
    }
}
