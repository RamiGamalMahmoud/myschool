<?php

namespace SM\Objects\Exams\Sheets\SSObjects\Semester;

use SM\Objects\Exams\Degree;

class ActivitySemester
{
    protected string $activityName;
    protected Degree $evaluation;

    public function __construct(Degree $evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function getEvaluationDegree(): Degree
    {
        return $this->evaluation;
    }
}
