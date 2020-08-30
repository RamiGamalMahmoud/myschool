<?php

namespace SM\Controllers\Exams;

use Simple\Core\View;
use Simple\Core\IRequest;
use SM\Controllers\BaseController;
use Simple\Helpers\DB;

class MonitoringController extends BaseController
{
    private $gradeNumber;

    public function __construct(IRequest $request, $params)
    {
        parent::__construct($request);

        $monitoringType = $this->request->getSegment(1);
        $semester = $this->request->getSegment(2);
        $model = 'SM\\Models\\Exams\Monitoring\\' . ucfirst($monitoringType) . 'Model';

        $this->view = 'exams/monitoring/' . $monitoringType . '.twig';
        $this->model = new $model($semester, new DB());
        $this->gradeNumber = $params['gradeNumber'];
        $this->context['tableName'] = self::getTableName($monitoringType, $semester);
    }

    /**
     * the default action
     */
    public function index()
    {
        $this->context['entities'] = $this->getAll();
        return $this->render($this->context);
    }

    public function render($context)
    {
        return View::load($this->view, $context);
    }

    /**
     * get all data in desiered monitoring table
     */
    public function getAll()
    {
        return $this->model->fetchAll($this->gradeNumber);
    }

    /**
     * save the monitored degree
     */
    public function save()
    {
        $data = $this->request->getAjaxData();
        $this->model->saveMonitoredDegree($data);
        echo $data->dataValue;
        exit();
    }

    /**
     * get the table name that will be in the view
     * 
     * @param string $monitoringType
     * @param string $semester
     * @return string the actual table name
     */
    public static function getTableName($monitoringType, $semester)
    {
        $names = [

            'evaluation' => [
                'fs' => 'تقويمات الفصل الدراسي الأول',
                'ss' => 'تقويمات الفصل الدراسي الثاني'
            ],

            'practical' => [
                'fs' => 'عملي الفصل الدراسي الأول',
                'ss' => 'عملي الفصل الدراسي الثاني'
            ],

            'written' => [
                'fs' => 'تحريري الفصل الدراسي الأول',
                'ss' => 'تحريري الفصل الدراسي الثاني'
            ]
        ];

        return $names[$monitoringType][$semester];
    }
}
