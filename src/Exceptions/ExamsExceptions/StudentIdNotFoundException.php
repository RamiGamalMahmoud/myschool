<?php

namespace SM\Exceptions\ExamsExceptions;

use Exception;

class StudentIdNotFoundException extends Exception
{
    public function __toString()
    {
        return 'Student id not existed';
    }
}
