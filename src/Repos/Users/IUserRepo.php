<?php

namespace SM\Repos\Users;

use SM\Entities\Entity;

interface IUserRepo
{
    function create(Entity $entity);
    function edit(Entity $entity);
    function getAll();
    function getById($id);
    function remove($id);
}
