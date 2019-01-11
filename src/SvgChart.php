<?php

namespace Src;

class SvgChart
{
    private $score;
    private $unit;
    const UNITS = 566; // 566 units in circumference

    public function __construct($score, $maxScore)
    {
        $this->score = $score;
        $this->unit = self::UNITS / $maxScore;
    }

    private function calculateArray() : array
    {
        $dashArray = [0, 0, 0, 0];

        if ($this->score < 25) {
            $dashArray = $this->calculateFirstQuarter();
        }
        if ($this->score >= 25 && $this->score < 50) {
            $dashArray = $this->calculateSecondQuarter();
        }
        if ($this->score >= 50 && $this->score <= 100) {
            $dashArray = $this->calculateSecondHalf();
        }

        return $dashArray;
    }

    private function calculateFirstQuarter() : array
    {
        return [
            0,
            75 * $this->unit,
            $this->score * $this->unit,
            0,
        ];
    }

    private function calculateSecondQuarter() : array
    {
        return [
            (75 * $this->unit) - $this->g1(),
            $this->g1(),
            25 * $this->unit,
            0,
        ];
    }

    private function calculateSecondHalf() : array
    {
        return [
            (75 * $this->unit) - $this->g1(),
            $this->g1(),
            0,
            0,
        ];
    }

    private function g1()
    {
        return (100 - $this->score) * $this->unit;
    }

    public function dashArray() : string
    {
        $dashArray = $this->calculateArray();

        return implode(' ', $dashArray);
    }
}
