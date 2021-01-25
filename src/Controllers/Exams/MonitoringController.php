<?php

namespace SM\Controllers\Exams;

use Exception;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\Response;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\Exams\Monitoring\WrittenRepo;
use SM\Repos\Exams\Monitoring\PracticalRepo;
use SM\Repos\Exams\Monitoring\EvaluationRepo;
use SM\Views\Exams\Monitoring\MonitoringView;
use SM\Repos\Exams\Monitoring\IMonitoringRepo;
use SM\Exceptions\ExamsExceptions\DegreeException;
use SM\Exceptions\ExamsExceptions\StudentIdNotFoundException;

class MonitoringController
{
    /**
     * @var \Simple\Core\Request $request 
     */
    protected Request $request;

    /**
     * @var \Simple\Core\Router
     */
    protected Router $router;

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

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;

        $this->gradeNumber = $this->router->get('gradeNumber');
        $this->semester = $this->router->get('semester');
        $this->monitoringType = $this->router->get('monitoringType');

        $this->view = new MonitoringView($this->gradeNumber, $this->monitoringType, $this->semester);
        $this->repo = $this->getRepo($this->monitoringType, $this->gradeNumber, $this->semester);
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
        $context['entities'] = $this->showAll();
        $this->view->render($context['entities']);
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
    public function store()
    {
        $data = $this->request->getAjaxData();
        try {
            $this->repo->save($data->id, $data->subjectName, $data->degree);
            Response::json(['degree' => $data->degree], 200);
        } catch (StudentIdNotFoundException $idException) {
            Response::json(['message' => $idException->getMessage()], 400);
        } catch (DegreeException $degreeException) {
            Response::json(['message' => $degreeException->getMessage()], 400);
        }
        exit();
    }
}
