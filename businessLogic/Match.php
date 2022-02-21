<?php


namespace app;
require_once "Round.php";
class Match{
    private $roundList = array();
    private $correntRound;
    private $photoList = array();

    public function __construct(array $photoList) {
        $this->photoList = $photoList;
        $this->correntRound = Round::getInitInstance($photoList);
        array_push($this->roundList,   $this->correntRound);
    }

    public function hasNextStep():bool{
         if ($this->correntRound->hasNextPair() || $this->correntRound->hasNextRound()){
             return true;
         }
         else return false;
    }
    public function nextStep() {
         if ($this->correntRound->hasNextPair()){
             return $this->correntRound->getNext();
         }
         elseif($this->correntRound->hasNextRound()){
             $this->setNextRound();
             return $this->correntRound->getNext();
         }
         else{
             //throw new \http\Exception\RuntimeException("????");
         }
    }

    public function getResult(){
        return $this->correntRound->getEndWinner();
    }

    public function setWinnerLeft(){
        $this->correntRound->setWinnerLeft();
    }
    public function setWinnerRight(){
        $this->correntRound->setWinnerRight();
    }

    private function setNextRound(){
        $this->correntRound = Round::getNewRoundInstance($this->correntRound);
        array_push($this->roundList,   $this->correntRound);
    }


}