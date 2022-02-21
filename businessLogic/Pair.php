<?php

namespace app;
require_once "Pair.php";
class Pair{
    private $winnerPhoto;
    private $winnerPair;
    private $isPlayedOut = false;

    public function setWinnerLeft(){
        $this->setWinnerPhoto($this->leftMatchedPair->getWinnerPhoto());
        $this->setWinnerPair($this->leftMatchedPair);
        $this->isPlayedOut = true;
    }
    public function setWinnerRight(){
        $this->setWinnerPhoto($this->rightMatchedPair->getWinnerPhoto());
        $this->setWinnerPair($this->rightMatchedPair);
        $this->isPlayedOut = true;
    }

    private $leftMatchedPair;
    private $rightMatchedPair;

    /**
     * @param $leftMatchedPair
     * @param $rightMatchedPair
     */
    public function __construct($leftMatchedPair, $rightMatchedPair){

        $this->winnerPair = null;
        $this->winnerPhoto = null;

        $this->leftMatchedPair = $leftMatchedPair;
        $this->rightMatchedPair = $rightMatchedPair;
    }
    public static function createWithWinnerPhoto($winnerPhoto){
        $pair = new Pair(null,null);
        $pair->winnerPhoto = $winnerPhoto;
        $pair->isPlayedOut = true;
        return $pair;
    }

    public function getLeftMatchedPair()
    {
        return $this->leftMatchedPair;
    }

    public function getRightMatchedPair()
    {
        return $this->rightMatchedPair;
    }

    public function getWinnerPhoto()
    {
        return $this->winnerPhoto;
    }



    private function setWinnerPhoto($winnerPhoto)
    {
        $this->winnerPhoto = $winnerPhoto;
    }

    public function getWinnerPair()
    {
        return $this->winnerPair;
    }

    private function setWinnerPair($winnerPair)
    {
        $this->winnerPair = $winnerPair;
    }

    /**
     * @return bool
     */
    public function isPlayedOut(): bool
    {
        return $this->isPlayedOut;
    }


}