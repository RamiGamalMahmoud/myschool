<?php

namespace SM\Controllers\Exams;

use Exception;
use config\DBConfig;
use Simple\Core\Request;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\Exams\Monitoring\WrittenRepo;
use SM\Repos\Exams\Monitoring\PracticalRepo;
use SM\Repos\Exams\Monitoring\EvaluationRepo;
use SM\Views\Exams\Monitoring\MonitoringView;
use SM\Repos\Exams\Monitoring\IMonitoringRepo;

class MonitoringController
{
    /**
     * @var array $context Array represents the data that will be used in the view template
     */
    protected ?array $context;

    /**
     * @var \Simple\Core\Request $request 
     */
    protected Request $request;

    /**
     * @var int
     */
    private $gradeNumber;

    /**
     * @var \SM\Repos\Exams\Monitoring\IMonitoringRepo
     */
    private IMonitoringRepo $repo;

    /**
     * @var \SM\Views\Exams\Monitoring\MonitoringView
     */
    private MonitoringView $view;

    public function __construct(Request $request, $params)
    {
        $this->request = $request;
        $this->context = $params;

        $monitoringType = $this->request->getSegment(1);
        $semester = $this->request->getSegment(2);
        $gradeNumber = $params['gradeNumber'];

        $this->gradeNumber = $gradeNumber;
        $this->view = new MonitoringView($this->gradeNumber, $monitoringType, $semester);
        $this->repo = $this->getRepo($monitoringType, $this->gradeNumber, $semester);
    }

    private function getRepo(string $monitoringType, int $gradeNumber, string $semester)
    {
        $dataAccess = new MySQLAccess();
        switch ($monitoringType) {
            case 'evaluation':
                return new EvaluationRepo($semester, $gradeNumber, $dataAccess);

            case 'practical':
                return new PracticalRepo($semester, $gradeNumber, $dataAccess);

            case 'written':
                return new WrittenRepo($semester, $gradeNumber, $dataAccess);
        }
        throw new Exception('TABLE_NOT_EXISTS');
    }

    /**
     * the default action
     */
    public function index()
    {
        $this->context['entities'] = $this->showAll();
        return $this->view->load($this->context['entities']);
    }

    /**
     * Show monitoring data for an id
     */
    public function show($id)
    {
        return $this->repo->getById($id);
    }

    /**
     * Returns all data in the monitoring table
     */
    public function showAll()
    {
        return $this->repo->getAll();
    }

    /**
     * save the monitored degree
     */
    public function save()
    {
        $data = $this->request->getAjaxData();
        if ($this->repo->save($data->id, $data->dataName, $data->dataValue) > 0) {
            echo $data->dataValue;
        }
        exit();
    }
}
