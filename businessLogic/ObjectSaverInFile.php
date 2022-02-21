<?php
namespace app;
class ObjectSaverInFile{
    private $pathToFile;

    public function __construct($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }


    public function hasFile():bool{
        if (file_exists($this->pathToFile)){
            return true;
        }
        else {
            return false;
        }
    }
    public function getObjectFromFile(){
        return unserialize(file_get_contents($this->pathToFile));
    }
    public function saveObjectInFile($obj){
        file_put_contents($this->pathToFile, serialize($obj));
    }
    public function deleteFile(){
        unlink($this->pathToFile);
    }
}