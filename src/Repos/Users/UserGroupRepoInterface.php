<?php

namespace SM\Repos\Users;

interface UserGroupRepoInterface
{
    public function getAll();

    public function addGroup();

    public function editGroup();

    public function updateGroup();
}
