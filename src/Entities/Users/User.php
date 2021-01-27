<?php

namespace SM\Entities\Users;

class User
{

    private $id;
    private string $userName;
    private string $fullName;
    private string $groupName;
    private string $privileges;
    private int $groupId;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->userName = $data['user_name'];
        $this->fullName = $data['full_name'];
        $this->groupId = $data['group_id'];
        $this->groupName = $data['group_name'];
        $this->privileges = $data['privileges'];
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

    public function getGroupName()
    {
        return $this->groupName;
    }

    public function getPrivileges()
    {
        return $this->privileges;
    }

    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    public function setPrivileges(string $privileges)
    {
        $this->privileges = $privileges;
    }

    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;
    }

    public function toArray()
    {
        return [
            'id' => $this->getUserId(),
            'user-name' => $this->getUserName(),
            'full-name' => $this->getFullName(),
            'user-group-id' => $this->getGroupId(),
            'user-group-name' => $this->getGroupName(),
            'user-privileges' => $this->getPrivileges()
        ];
    }
}
