<?php

namespace SM\Helpers;

use Exception;
use InvalidArgumentException;
use PhpParser\Node\Expr\FuncCall;
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

        // filter not assigned degs
        $assignedDegs = array_filter($degs, function ($deg) {
            if ($deg->isAssigned()) {
                return $deg;
            }
        });

        // filter abscense degs
        if (empty($assignedDegs)) {
            return null;
        }

        $notAbscense = array_filter($assignedDegs, function ($deg) {
            if (!$deg->isAbsence()) {
                return $deg;
            }
        });

        if (empty($notAbscense)) {
            return -1;
        }

        // clac total
        $total = array_reduce($notAbscense, function ($carry, $deg) {
            return $carry + $deg->getValue();
        }, 0);

        return $total;
        if (empty($degs)) {
            throw new InvalidArgumentException('Degress array should not be empty');
        }

        if (!self::isAllAssigned($degs)) {
            return null;
        }

        $acceptedDegs = self::getAcceptedDegs($degs);

        if (empty($acceptedDegs)) {
            return null;
        }

        $total = array_reduce($acceptedDegs, function ($carry, $item) {
            return $carry + $item->getValue();
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
        $isAllAssigned = true;

        foreach ($degs as $deg) {
            if (!$deg instanceof Degree) {
                throw new Exception("Degree should be instance of " . Degree::class . " found " . gettype($deg));
            }
            $isAllAssigned &= $deg->isAssigned();
        }

        return $isAllAssigned;
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
     * @return string
     * @throws \Exception
     */
    public static function getGrade(float $max, ?float $degree)
    {
        if ($degree === null) return null;
        $percent = $degree / $max * 100;

        if ($degree < 0) {
            return 'ABS';
        } elseif ($percent < 50) {
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
