<?php

use PF\BowlingGame;

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{
    public function testGetScore_withAllZeros_resultIsZero()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }
        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_resultIs20()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_getsScoreWithSpareBonus()
    {
        // set up
        $game = new BowlingGame();

        $game->roll(3);
        $game->roll(7);
        $game->roll(5);

        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_getScoreWithStrikeBonus()
    {
        // set up
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(3);
        $game->roll(5);

        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(42, $score);
    }

    public function testGetScore_withAPerfectGame_scoreIs300()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }
        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(300, $score);
    }

    public function testRoll_withNegativePoints_exception()
    {
        // set up
        $game = new BowlingGame();
        $this->expectException(InvalidArgumentException::class); // assert
        $game->roll(-1);
    }

    public function testRoll_withRollScoreOfEleven_exception()
    {
        // set up
        $game = new BowlingGame();
        $this->expectException(InvalidArgumentException::class); // assert
        $game->roll(11);
    }

    public function testRoll_with25Rolls_exceptionExpected()
    {
        // set up
        $game = new BowlingGame();
        $this->expectException(InvalidArgumentException::class); // assert
        for ($i = 0; $i < 25; $i++) {
            $game->roll(10);
        }
    }

    public function testGetScore_withFiveRolls_exceptionExpected()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 5; $i++) {
            $game->roll(10);
        }
        // test
        $this->expectException(InvalidArgumentException::class); // assert
        $game->getScore();
    }

}