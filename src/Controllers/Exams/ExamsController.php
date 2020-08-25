<?php

namespace SM\Controllers\Exams;

use SM\Controllers\BaseController;
use SM\Models\Exams\ExamsModel;
use SM\Models\IModel;
use Simple\Core\Request;
use Simple\Core\View;
use Simple\Helpers\Functions;
use SM\Entities\EvaluationEntity;

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

    // public function view()
    // {
    //     $gradeNumber = $this->request->getSegment(1);
    //     $this->context['gradeNumber'] = $gradeNumber;
    //     $this->render($this->context);
    // }

    public function monitoring()
    {
        // Extracting data from the request
        $gradeNumber     = $this->request->getSegment(1);
        $monitoringTable = $this->request->getSegment(3);
        $semester        = $this->request->getSegment(4);

        $gradeName = $gradeNumber == 1 ? 'الصف الأول' : 'الصف الثاني';

        $tableData = (require CONFIG_DIR . DS . 'exams' . DS . 'monitoring.config.php')[$monitoringTable];
        $tableName = $this->tableName[$monitoringTable][$semester];

        // preparing the view context data
        $this->context['gradeName']     = $gradeName;
        $this->context['gradeNumber']   = $gradeNumber;
        $this->context['tableName']     = $tableName;
        $this->context['childTemplate'] = 'exams' . DS . $monitoringTable . '.twig';
        $this->context['degrees']       = $tableData;

        // parameters that will be sent to the repo
        $argv = [
            'gradeNumber' => $gradeNumber,
            'monitoringType' => $monitoringTable,
            'semester' => $semester
        ];

        $entities = $this->model->read($argv);
        $this->context['data'] = $entities;
        $this->render($this->context);
    }

    public function sheets()
    {
        // Extracting data from the request
        $gradeNumber     = $this->request->getSegment(1);
        $semester        = $this->request->getSegment(3);

        $gradeName = $gradeNumber == 1 ? 'الصف الأول' : 'الصف الثاني';

        /**
         * get the folder
         */

        // $this->context['gradeName']     = $gradeName;
        // $this->context['gradeNumber']   = $gradeNumber;
        // $this->context['tableName']     = $tableName;
        // $this->context['childTemplate'] = 'exams' . DS . $monitoringTable . '.twig';
        // $this->context['degrees']       = $tableData;

        $argv = [
            'gradeNumber' => $gradeNumber,
            'semester' => $semester
        ];

    }
    public function save()
    {

        $data = file_get_contents('php://input');
        $data = json_decode($data);

        $studentId = trim($data->id);
        $dataName  = trim($data->dataName);
        $dataValue = trim($data->dataValue);

        $gradeNumber     = $this->request->getSegment(1);
        $monitoringType  = $this->request->getSegment(3);
        $semester        = $this->request->getSegment(4);

        $params = [
            'gradeNumber' => $gradeNumber,
            'monitoringType' => $monitoringType,
            'semester' => $semester,
            'studentId' => $studentId,
            'dataName' => $dataName,
            'dataValue' => $dataValue
        ];

        $this->model->update($params);
    }
}
