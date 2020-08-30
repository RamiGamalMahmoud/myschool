<?php

namespace SM\Models\Exams\Monitoring;

use Simple\Helpers\DB;

interface IMonitoringModel
{
    function __construct(string $semester, DB $db);
    function fetchAll($gradeNumber);
    function saveMonitoredDegree($data);
}