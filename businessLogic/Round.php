<?php

namespace app;
require_once "Pair.php";

class Round{
    private $pairList = array();
    private $currentPair;


    public static function getInitInstance(array $photoList):Round {
        $round = new Round();
        foreach ($photoList as $photo){
            array_push($round->pairList, Pair::createWithWinnerPhoto($photo));
        }
        return Round::getNewRoundInstance($round);
    }

    public function getNext(): array{
        $matchedPhotos = array(
            'one' => array(),
            'two' => array()
        );
        foreach ($this->pairList as &$pair){ //?
            if ($pair->isPlayedOut() == false){
                array_push($matchedPhotos['one'],$pair->getLeftMatchedPair()->getWinnerPhoto()->getInfo());
                array_push($matchedPhotos['two'],$pair->getRightMatchedPair()->getWinnerPhoto()->getInfo());
                $this->currentPair = $pair;
                return $matchedPhotos;
            }
        }
        throw new \http\Exception\RuntimeException("Played out pair not found");
    }

    public function setWinnerLeft(){
        $this->currentPair->setWinnerLeft();
    }
    public function setWinnerRight(){
        $this->currentPair->setWinnerRight();
    }

    public static function getNewRoundInstance($finishedRound){
        $nextRound = new Round();
        for ($i = 0; $i + 1 < count($finishedRound->pairList);$i += 2){
            array_push(
                $nextRound->pairList, new Pair($finishedRound->pairList[$i], $finishedRound->pairList[$i + 1])
            );
        }
        if (count($finishedRound->pairList) % 2 != 0){
            array_push($nextRound->pairList,
                Pair::createWithWinnerPhoto(
                    $finishedRound->pairList[count($finishedRound->pairList) - 1]->getWinnerPhoto())
                );
        }
        return $nextRound;
    }

    public function hasNextPair(): bool {
        foreach ($this->pairList as $pair){
            if ($pair->isPlayedOut() == false){
                return true;
            }
        }
        return false;
    }

    public function hasNextRound(): bool {
        if (count($this->pairList) > 1){
            return true;
        }
        else{
            return false;
        }
    }
    public function getEndWinner(){
        return $this->currentPair->getWinnerPhoto()->getInfo();
    }

}