<?php

namespace SM\Repos\Students;

use SM\Entities\Entity;

interface IStudentRepo
{
    function create(Entity $entity);
    function edit(Entity $entity);
    function getAll();
    function getById($id);
    function remove($id);
}
