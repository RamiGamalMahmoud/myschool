<?php

namespace SM\Repos\Users;

use Simple\Core\DataAccess\IDataAccess;
use SM\Repos\IRepo;
use Simple\Core\DataAccess\Query;
use SM\Entities\Entity;

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
    $query->select(['userName', 'userId', 'fullName', 'groupId'])
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

  public function auth(string $userName, string $password)
  {
    $query = new Query();
    $query->select(['userId', 'userName', 'fullName', 'groupId'])
      ->from('users')
      ->where('userName', '=', $userName)
      ->andWhere('password', '=', $password);
    return $this->dataAccess->get($query);
  }
}
