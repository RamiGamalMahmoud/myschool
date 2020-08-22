<?php

namespace SM\Models;

interface IWrite
{
    function insert($argv = []);
    function update($argv = []);
    function delete($argv = []);
}
