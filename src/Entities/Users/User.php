<?php

namespace SM\Entities\Users;

class User
{

    private $id;
    private string $userName;
    private string $fullName;
    private int $groupId;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->userName = $data['user_name'];
        $this->fullName = $data['full_name'];
        $this->groupId = $data['group_id'];
    }
    public function getUserId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }
}
