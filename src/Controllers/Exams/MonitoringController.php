<?php

namespace SM\Controllers\Exams;

use Simple\Core\View;
use Simple\Core\IRequest;
use Simple\Core\DataAccess\MySQLAccess;
use config\DBConfig;
use SM\Controllers\BaseController;
use SM\Repos\Exams\Monitoring\AbstractMonitoringRepo;
use SM\Repos\Exams\Monitoring\EvaluationRepo;
use SM\Repos\Exams\Monitoring\PracticalRepo;
use SM\Repos\Exams\Monitoring\WrittenRepo;

class MonitoringController extends BaseController
{
    private $gradeNumber;
    private AbstractMonitoringRepo $repo;

    public function __construct(IRequest $request, $params)
    {
        parent::__construct($request, $params);

        $monitoringType = $this->request->getSegment(1);
        $semester = $this->request->getSegment(2);

        $this->view = 'exams/monitoring/' . $monitoringType . '.twig';

        $this->gradeNumber = $params['gradeNumber'];
        $this->context['tableName'] = self::getTableName($monitoringType, $semester);
        $this->repo = $this->getRepo($monitoringType, $this->gradeNumber, $semester);
    }

    private function getRepo(string $monitoringType, int $gradeNumber, string $semester)
    {
        $dataAccess = new MySQLAccess(new DBConfig());
        switch ($monitoringType) {
            case 'evaluation':
                return new EvaluationRepo($semester, $gradeNumber, $dataAccess);
                break;

            case 'practical':
                return new PracticalRepo($semester, $gradeNumber, $dataAccess);
                exit;

            case 'written':
                return new WrittenRepo($semester, $gradeNumber, $dataAccess);
                exit;
        }
        return null;
    }

    /**
     * the default action
     */
    public function index()
    {
        $this->context['entities'] = $this->show();
        return $this->loadView($this->context);
    }

    public function loadView(array $context)
    {
        return View::load($this->view, $context);
    }

    /**
     * Returns all data in the monitoring table
     */
    public function show($id = '')
    {
        return $this->repo->getAll();
    }

    /**
     * save the monitored degree
     */
    public function save()
    {
        $data = $this->request->getAjaxData();
        if ($this->repo->saveDegree($data->id, $data->dataName, $data->dataValue) > 0) {
            echo $data->dataValue;
        }
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
