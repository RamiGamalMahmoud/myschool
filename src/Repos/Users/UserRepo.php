<?php

namespace SM\Repos\Users;

use SM\Entities\Users\User;
use Simple\Core\DataAccess\Query;
use Simple\Core\DataAccess\IDataAccess;
use SM\Exceptions\EntityNotFoundException;

class UserRepo implements IUserRepo
{
    private IDataAccess $dataAccess;

    private array $columns = ['users.id', 'user_name', 'full_name', 'privileges', 'group_id', 'groups.group_name'];

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getById($id): ?User
    {
        $query = new Query();
        $query->select($this->columns)
            ->from('users')
            ->join('groups')
            ->on('users.group_id', 'groups.id')
            ->where('users.id', '=', $id)
            ->limit(1);
        $user = $this->dataAccess->get($query);
        if (!$user) {
            throw new EntityNotFoundException();
        }
        return new User($user);
    }

    public function getAll()
    {
        $query = new Query();
        $query->select($this->columns)
            ->from('users')
            ->join('groups')
            ->on('users.group_id', 'groups.id')
            ->orderBy(['user_name', 'group_id']);
        $data = $this->dataAccess->getAll($query);
        $entities = array_map(function ($user) {
            return new User($user);
        }, $data);
        return $entities;
    }

    public function create(User $user)
    {
    }

    public function update(User $user)
    {
        $query = new Query();
        $query->update('users')
            ->set(['user_name' => $user->getUserName(), 'group_id' => $user->getGroupId(), 'privileges' => $user->getPrivileges()])
            ->where('id', '=', $user->getUserId());
        return $this->dataAccess->run($query);
    }

    public function remove($id)
    {
    }

    /**
     * Get the logged user from database
     * 
     * @param string $userName
     * @param string $password
     * @return \SM\Entities\Users\User
     */
    public function getByNameAndPassword(string $userName, string $password): ?User
    {
        $query = new Query();
        $query->select($this->columns)
            ->from('users')
            ->join('groups')
            ->on('users.group_id', 'groups.id')
            ->where('user_name', '=', $userName)
            ->andWhere('password', '=', $password)
            ->limit(1);
        $data = $this->dataAccess->get($query);
        if ($data !== false)
            return new User($data);
        return null;
    }
}
