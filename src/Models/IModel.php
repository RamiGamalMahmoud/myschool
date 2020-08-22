<?php

namespace SM\Models;

interface IModel
{
    function read($argv = []);
    function insert($argv = []);
    function update($argv = []);
    function delete($argv = []);
}
