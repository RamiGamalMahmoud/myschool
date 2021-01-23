<?php

namespace SM\Repos\Users;

use Simple\Core\DataAccess\IDataAccess;
use SM\Repos\IRepo;
use Simple\Core\DataAccess\Query;
use SM\Entities\Entity;
use SM\Entities\Users\User;

class UsersRepo implements IRepo
{
    private IDataAccess $dataAccess;
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getById($id)
    {
    }

    public function getAll()
    {
        $query = new Query();
        $query->select(['id', 'user_name', 'full_name', 'group_id'])
            ->from('users');
        return $this->dataAccess->getAll($query);
    }

    public function create(Entity $entity)
    {
    }

    public function edit(Entity $entity)
    {
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
        $query->select(['id', 'user_name', 'full_name', 'group_id'])
            ->from('users')
            ->where('user_name', '=', $userName)
            ->andWhere('password', '=', $password)
            ->limit(1);
        $data = $this->dataAccess->get($query);
        if ($data !== false)
            return new User($data);
        return null;
    }
}
