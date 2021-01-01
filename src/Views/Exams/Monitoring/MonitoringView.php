<?php

namespace SM\Views\Exams\Monitoring;

use Simple\Core\View;
use Simple\Helpers\Functions;

class MonitoringView
{
    private string $template;
    private ?array $context;

    public function __construct(int $gradeNumber, string $monitoringType, string $semester)
    {
        $this->template = 'exams/monitoring/' . $monitoringType . '.twig';
        $this->context['tableName'] = self::getTableName($monitoringType, $semester);
        $this->context['gradeName'] = self::getGradeName($gradeNumber);
    }

    public function load($data)
    {
        $this->context['entities'] = $data;
        return View::load($this->template, $this->context);
    }

    private static function getGradeName(int $gradeNumber)
    {
        $gradeNames = [
            1 => 'الصف الأول',
            2 => 'الصف الثاني'
        ];
        return $gradeNames[$gradeNumber];
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
