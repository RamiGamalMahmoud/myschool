<?php

namespace SM\Repos\Exams\Monitoring;

interface IMonitoringRepo
{
    function getAll();
    function getById($id);
    function remove($id);
    function save($studentId, $dataName, $dataValue);
}
