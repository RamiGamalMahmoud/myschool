<?php

namespace SM\Entities\Users;

use SM\Entities\BaseEntity;

class UserEntity extends BaseEntity
{
  public function getUserId()
  {
    return $this->get('userId');
  }

  public function getUserName()
  {
    return $this->get('userName');
  }

  public function getFullName()
  {
    return $this->get('fullName');
  }

  public function getGroupId()
  {
    return $this->get('groupeId');
  }
}
