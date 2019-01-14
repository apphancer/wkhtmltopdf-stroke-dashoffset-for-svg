<?php

namespace Src;

class SvgChart
{
    private $score;
    private $maxScore;
    private $unit;
    const UNITS = 566; // 566 units in circumference

    public function __construct($score, $maxScore)
    {
        $this->score = $score;
        $this->maxScore = $maxScore;
        $this->unit = self::UNITS / $maxScore;
    }

    private function oneQuarter()
    {
        return $this->maxScore / 4;
    }

    private function threeQuarters()
    {
        return $this->oneQuarter() * 3;
    }

    private function oneHalf()
    {
        return $this->maxScore / 2;
    }

    private function calculateArray() : array
    {
        $dashArray = [0, 0, 0, 0];

        if ($this->score < $this->oneQuarter()) {
            $dashArray = $this->calculateFirstQuarter();
        }
        if ($this->score >= $this->oneQuarter() && $this->score < $this->oneHalf()) {
            $dashArray = $this->calculateSecondQuarter();
        }
        if ($this->score >= $this->oneHalf() && $this->score <= $this->maxScore) {
            $dashArray = $this->calculateSecondHalf();
        }

        return $dashArray;
    }

    private function calculateFirstQuarter() : array
    {
        return [
            0,
            $this->threeQuarters() * $this->unit,
            $this->score * $this->unit,
            0,
        ];
    }

    private function calculateSecondQuarter() : array
    {
        return [
            ($this->threeQuarters() * $this->unit) - $this->secondStroke(),
            $this->secondStroke(),
            $this->oneQuarter() * $this->unit,
            0,
        ];
    }

    private function calculateSecondHalf() : array
    {
        return [
            ($this->threeQuarters() * $this->unit) - $this->secondStroke(),
            $this->secondStroke(),
            0,
            0,
        ];
    }

    private function secondStroke()
    {
        return ($this->maxScore - $this->score) * $this->unit;
    }

    public function dashArray() : string
    {
        $dashArray = $this->calculateArray();

        return implode(' ', $dashArray);
    }
}
