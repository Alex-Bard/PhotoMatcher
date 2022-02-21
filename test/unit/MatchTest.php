<?php

namespace test;

require_once(__DIR__.'/../../businessLogic/Match.php');
require_once(__DIR__.'/../../businessLogic/Photo.php');

use app\Photo;

use app\Match;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{

    public function testCreationAndPassageMatchWithTwoPhotos()
    {
        $photo1 = $this->createMock(Photo::class);
        $photo2 = $this->createMock(Photo::class);
        $photo1->method('getInfo')
            ->willReturn(array(1));
        $photo2->method('getInfo')
            ->willReturn(array(2));

        $photos = array($photo1,$photo2);

        $match = new Match($photos);

        $expectesRes = array(
            'one' => array(),
            'two' => array()
        );
        array_push($expectesRes['one'],array(1));
        array_push($expectesRes['two'],array(2));
        self::assertTrue($match->hasNextStep());
        $this->assertSame($expectesRes, $match->nextStep());

        $match->setWinnerLeft();
        self::assertFalse($match->hasNextStep());
        self::assertSame(array(1),$match->getResult());

        $match->setWinnerRight();
        self::assertSame(array(2),$match->getResult());
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

        $match = new Match($photos);

        $expectesRes = array(
            'one' => array(),
            'two' => array()
        );
        array_push($expectesRes['one'],array(1));
        array_push($expectesRes['two'],array(2));
        self::assertTrue($match->hasNextStep());
        $this->assertSame($expectesRes, $match->nextStep());

        $match->setWinnerLeft();
        self::assertTrue($match->hasNextStep());
        self::assertSame(array(1),$match->getResult());

        $match->setWinnerRight();
        self::assertSame(array(2),$match->getResult());

        $expectesRes = array(
            'one' => array(),
            'two' => array()
        );
        array_push($expectesRes['one'],array(2));
        array_push($expectesRes['two'],array(3));
        //$match->nextStep();
        self::assertSame($expectesRes, $match->nextStep());

        $match->setWinnerLeft();
        self::assertFalse($match->hasNextStep());
        self::assertSame(array(2),$match->getResult());

        $match->setWinnerRight();
        self::assertSame(array(3),$match->getResult());
    }

}
