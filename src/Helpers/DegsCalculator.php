<?php

namespace SM\Helpers;

use Exception;
use Simple\Helpers\Functions;
use SM\Objects\Exams\Degree;

class DegsCalculator
{
    /**
     * Calculate degrees total
     * @param array $degs
     * @return null|float
     */
    public static function calcTotal(array $degs) //: ?float
    {
        if (!self::isAllAssigned($degs)) {
            return null;
        }

        // filter abscense degs
        $notAbscense = array_filter($degs, function ($deg) {
            return !$deg->isAbsence();
        });

        if (empty($notAbscense)) {
            return -1;
        }

        // clac total
        $total = array_reduce($notAbscense, function ($carry, $deg) {
            return $carry + $deg->getValue();
        }, 0);

        return $total;
    }

    /**
     * Checks if every degree in degrees is assigned
     * @param array $degs
     * @return bool
     */
    public static function isAllAssigned(array $degs)
    {
        $result = array_reduce($degs, function ($carry, $deg) {
            return $carry && $deg->isAssigned();
        }, true);

        return $result;
    }

    /**
     * Extract the valid degrees for calculation.
     * Valid degree that is not absence and is assigned
     * @var array $degs
     * @return null|array
     */
    public static function getAcceptedDegs(array $degs)
    {
        $acceptedDegs = array_filter($degs, function ($deg) {
            if ($deg->isAssigned() === true && !$deg->isAbsence()) {
                return $deg;
            } else {
                Functions::dump($deg);
            }
        });
        return $acceptedDegs;
    }

    /**
     * Get the subject grade.
     * @param float $max the max degree
     * @param float $degree the student degree
     * @return null|string
     * @throws \Exception
     */
    public static function getGrade(float $max, ?float $degree): ?string
    {
        if ($degree === null) return null;
        $percent = $degree / $max * 100;

        if ($percent < 50) {
            return 'F';
        } elseif ($percent < 65) {
            return 'D';
        } elseif ($percent < 75) {
            return 'C';
        } elseif ($percent < 85) {
            return 'B';
        } elseif ($percent <= 100) {
            return 'A';
        } else {
            throw new Exception('Student degree should not be grater than max value');
        }
    }
}
