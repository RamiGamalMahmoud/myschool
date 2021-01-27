<?php

namespace SM\Repos\Users;

use SM\Entities\Users\User;

interface IUserRepo
{
    function create(User $user);
    function update(User $user);
    function getAll();
    function getById($id);
    function remove($id);
}
