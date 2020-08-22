<?php

namespace SM\Controllers\Exams;

use SM\Controllers\BaseController;
use SM\Models\Exams\ExamsModel;
use SM\Models\IModel;
use Simple\Core\Request;
use Simple\Core\View;

class ExamsController extends BaseController
{
    private $context;
    protected Request $request;
    protected IModel $model;

    private $tableName = [

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

    public function __construct(Request $request, $context = null)
    {
        $this->model = new ExamsModel();
        $this->request = $request;
        $this->context = $context;
        $this->view = 'exams/exams.twig';
    }

    /**
     * View the default state of the exams page
     */
    public function index()
    {
        $this->render($this->context);
    }

    public function render(array $context)
    {
        View::render($this->view, $context);
    }

    public function view()
    {
        $gradeNumber = $this->request->getSegment(2);
        $this->context['gradeNumber'] = $gradeNumber;
        $this->render($this->context);
    }

    public function monitoring()
    {
        $gradeNumber = $this->request->getSegment(2);
        $this->context['gradeNumber'] = $gradeNumber;

        $gradeName = $gradeNumber == 1? 'الصف الأول' : 'الصف الثاني';

        $this->context['gradeName'] = $gradeName;

        $monitoringTable = $this->request->getSegment(4);
        $semester = $this->request->getSegment(5);

        $tableName = $this->tableName[$monitoringTable][$semester];

        $this->context['tableName'] = $tableName;

        $tableData = (require CONFIG_DIR . DS . 'exams' . DS . 'monitoring.config.php')[$monitoringTable];
        $this->context['childTemplate'] = 'exams' . DS . $monitoringTable . '.twig';
        $this->context['degrees'] = $tableData;

        $params = [
            'gradeNumber' => $gradeNumber,
            'dataTable' => $monitoringTable,
            'semester' => $semester
        ];
        
        $data = $this->model->read($params);
        $this->context['data'] = $data;
        $this->render($this->context);
    }

    public function save()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data);

        $studentId = trim($data->id);
        $dataName  = trim($data->dataName);
        $dataValue = trim($data->dataValue);

        $gradeNumber = $this->request->getSegment(2);
        $monitoringTable = $this->request->getSegment(4);
        $semester = $this->request->getSegment(5);

        $params = [
            'gradeNumber' => $gradeNumber,
            'dataTable' => $monitoringTable,
            'semester' => $semester,
            'studentId' => $studentId,
            'dataName' => $dataName,
            'dataValue' => $dataValue
        ];

        $this->model->update($params);
    }
}
