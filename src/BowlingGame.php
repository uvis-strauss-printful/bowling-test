<?php

namespace PF;

use InvalidArgumentException;

class BowlingGame
{

    private array $rolls = [];

    public function roll(int $points): void
    {
        $this->validateRollInput($points);
        $this->rolls[] = $points;
    }

    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        $this->validateRollCount(true);

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += $this->getStrikeScore($roll);
                $roll++;
                continue;
            }
            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    /**
     * @param $roll
     * @return mixed
     */
    public function getNormalScore($roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param $roll
     * @return bool
     */
    public function isSpare($roll)
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param $roll
     * @return mixed
     */
    public function getSpareBonus($roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param $roll
     * @return mixed
     */
    public function getStrikeScore($roll)
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param $roll
     * @return bool
     */
    public function isStrike($roll)
    {
        return $this->rolls[$roll] === 10;
    }

    /**
     * @param int $points
     */
    public function validateRollInput(int $points)
    {
        $this->validateRollCount();
        if ($points < 0) {
            throw new InvalidArgumentException("Roll points can only be positive!");
        }
        if ($points > 10) {
            throw new InvalidArgumentException("Roll points must be 10 or less!");
        }
    }

    /**
     * @param bool $final
     */
    public function validateRollCount($final = false)
    {
        if (count($this->rolls) >= 22) {
            throw new InvalidArgumentException("Max rolls in game are 22!");
        }
        if ($final && count($this->rolls) < 12) {
            throw new InvalidArgumentException("Must be at least 12 scored rolls!");
        }
    }
}
