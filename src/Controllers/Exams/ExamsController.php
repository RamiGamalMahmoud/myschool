<?php

namespace SM\Controllers\Exams;

use Simple\Core\Request;
use Simple\Core\View;
use Simple\Helpers\Functions;
use SM\Controllers\BaseController;

class ExamsController extends BaseController
{

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

    public function __construct(Request $request, $params = null)
    {
        $linkPrefex = isset($params['linkPrefex']) ? $params['linkPrefex'] . '/exams': '/exams';
        $this->request = $request;
        $this->context = $params;
        $this->context['linkPrefex'] = $linkPrefex;
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

    public function monitoring()
    {

    }

    public function sheets()
    {


    }
    public function save()
    {

    }
}
