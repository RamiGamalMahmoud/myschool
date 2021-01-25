<?php

namespace SM\Exceptions\ExamsExceptions;

use Exception;

class DegreeException extends Exception
{
    public function __toString()
    {
        return 'Degree is not correct';
    }
}
