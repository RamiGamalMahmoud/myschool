<?php

namespace SM\Views\Exams\Monitoring;

use Simple\Core\View;

class MonitoringView
{
    /**
     * @var string $template
     */
    private string $template;

    /**
     * @var array $context
     */
    private array $context = [];

    /**
     * @param int $gradeNumber
     * @param string $monitoringType
     * @param string $semester
     * @return void
     */
    public function __construct(int $gradeNumber, string $monitoringType, string $semester)
    {
        $this->template = 'exams/monitoring/' . $monitoringType . '.twig';
        $this->context['tableName'] = self::getTableName($monitoringType, $semester);
        $this->context['gradeName'] = self::getGradeName($gradeNumber);
    }

    /**
     * Call the View::render function for rendering
     * 
     * @param array $data
     * @return void
     */
    public function render($data)
    {
        $this->context['entities'] = $this->prepareData($data);
        View::render($this->template, $this->context);
    }

    /**
     * Preparing the data for rendering
     * 
     * @param array $data
     * @return array the prepared data
     */
    private function prepareData(array $data): array
    {
        $entities = array_map(function ($entity) {
            return $entity->toArray();
        }, $data);
        return $entities;
    }

    /**
     * Get the grade name from grade number
     * 
     * @param int $gradeNumber
     * @return string gradeName
     */
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
