<?php

use PHPUnit\Framework\TestCase;
use SM\Controllers\Exams\MonitoringController;
include 'TRequest.php';

class MonitoringTest extends TestCase
{
    public function testResult()
    {
        $request = new TRequest('exams/1/monitoring/evaluation/fs');
        $ctrl = new MonitoringController($request, ['gradeNumber' => 1]);
        $tableName = $ctrl->getTableName('written', 'fs');
        $this->assertEquals('تحريري الفصل الدراسي الأول', $tableName);
    }
}