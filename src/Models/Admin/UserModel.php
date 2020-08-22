<?php

namespace SM\Models\Admin;

use SM\Models\IModel;
use Simple\Helpers\DB;

class UserModel implements IModel
{
    private DB $db;

    public function __construct()
    {
        $this->db = new DB();
    }
    public function read($argv = [])
    {
        $data = $this->db->select(['userId', 'userName', 'fullName', 'groupId'])
        ->from('users')
        ->fetch();
        return $data;
    }

    public function insert($argv = [])
    {
    }

    public function update($argv = [])
    {
    }

    public function delete($argv = [])
    {
    }
}
