<?php

namespace SM\Repos;

use SM\Entities\Entity;

interface IRepo
{
    function create(Entity $entity);
    function edit(Entity $entity);
    function getAll();
    function getById($id);
    function remove($id);
}
