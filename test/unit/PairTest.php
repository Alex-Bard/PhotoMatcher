<?php

require_once(__DIR__.'/../../businessLogic/Pair.php');
use app\Pair;
use PHPUnit\Framework\TestCase;

class PairTest extends TestCase
{
    public function testCreateWithWinnerPhoto()
    {
        $winnerPhoto = new Pair(null,null);
        $pair = Pair::createWithWinnerPhoto($winnerPhoto);
        self::assertTrue($pair->isPlayedOut());
        self::assertEquals($winnerPhoto,$pair->getWinnerPhoto());
    }
    public function testCreatingPairsAndSetWinner(){
        $winnerPhoto1 = 1;
        $winnerPhoto2 = 2;
        $pair1 = Pair::createWithWinnerPhoto($winnerPhoto1);
        $pair2 = Pair::createWithWinnerPhoto($winnerPhoto2);

        $testPair = new Pair($pair1,$pair2);
        self::assertFalse($testPair->isPlayedOut());

        $testPair->setWinnerRight();
        self::assertTrue($testPair->isPlayedOut());
        self::assertEquals($pair2, $testPair->getWinnerPair());
        self::assertEquals($winnerPhoto2, $testPair->getWinnerPhoto());

        $testPair->setWinnerLeft();
        self::assertEquals($pair1, $testPair->getWinnerPair());
        self::assertEquals($winnerPhoto1, $testPair->getWinnerPhoto());
    }

}
