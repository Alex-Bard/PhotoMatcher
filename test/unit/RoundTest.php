<?php

namespace test;

//require_once dirname(__FILE__) . '/../../Photo.php';
//require_once dirname(__FILE__) . '/../../Round.php';
use app\Photo;
use app\Round;
use PHPUnit\Framework\TestCase;

class RoundTest extends TestCase
{

    public function testCreationAndPassageTheFirstRoundWithTwoPhotos()
    {
        $photo1 = $this->createMock(Photo::class);
        $photo2 = $this->createMock(Photo::class);
        $photo1->method('getInfo')
            ->willReturn(array(1));
        $photo2->method('getInfo')
            ->willReturn(array(2));

        $photos = array($photo1,$photo2);

        $round = Round::getInitInstance($photos);

        $expectesRes = array(
            'one' => array(),
            'two' => array()
        );
        array_push($expectesRes['one'],array(1));
        array_push($expectesRes['two'],array(2));
        self::assertTrue($round->hasNextPair());
        $this->assertSame($expectesRes, $round->getNext());

        $round->setWinnerLeft();
        self::assertFalse($round->hasNextPair());
        self::assertFalse($round->hasNextRound());
        self::assertSame(array(1),$round->getEndWinner());

        $round->setWinnerRight();
        self::assertSame(array(2),$round->getEndWinner());
    }

    public function testCreationAndPassageTheFirstRoundWithThreePhotos()
    {
        $photo1 = $this->createMock(Photo::class);
        $photo2 = $this->createMock(Photo::class);
        $photo3 = $this->createMock(Photo::class);
        $photo1->method('getInfo')
            ->willReturn(array(1));
        $photo2->method('getInfo')
            ->willReturn(array(2));
        $photo3->method('getInfo')
            ->willReturn(array(3));

        $photos = array($photo1,$photo2,$photo3);

        $round = Round::getInitInstance($photos);

        $expectesRes = array(
            'one' => array(),
            'two' => array()
        );
        array_push($expectesRes['one'],array(1));
        array_push($expectesRes['two'],array(2));
        self::assertTrue($round->hasNextPair());
        $this->assertSame($expectesRes, $round->getNext());

        $round->setWinnerLeft();
        self::assertFalse($round->hasNextPair());
        self::assertTrue($round->hasNextRound());
        self::assertSame(array(1),$round->getEndWinner());

        $round->setWinnerRight();
        self::assertSame(array(2),$round->getEndWinner());

        $round = Round::getNewRoundInstance($round);
        $expectesRes = array(
            'one' => array(),
            'two' => array()
        );
        array_push($expectesRes['one'],array(2));
        array_push($expectesRes['two'],array(3));
        self::assertTrue($round->hasNextPair());
        $this->assertSame($expectesRes, $round->getNext());

        $round->setWinnerLeft();
        self::assertFalse($round->hasNextPair());
        self::assertFalse($round->hasNextRound());
        self::assertSame(array(2),$round->getEndWinner());

        $round->setWinnerRight();
        self::assertSame(array(3),$round->getEndWinner());
    }





}
