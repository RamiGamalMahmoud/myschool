<?php

namespace SM\Repos;

use SM\Entities\Entity;

/**
 * A Repo that used for read data
 */
interface IReadRepo
{
    function getAll();
    function getById($id);
}
