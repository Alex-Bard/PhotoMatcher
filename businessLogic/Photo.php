<?php


namespace app;
ini_set ("memory_limit", "5000M" );
require 'miniature.php';

class Photo
{
    private $name;
    private $path;
    private $pathToThumb;

    public function __construct($name, $path, $pathToThumb)
    {
        $this->name = $name;
        $this->path = $path;
        $this->pathToThumb = $pathToThumb;
    }

    public function getName(){
        return $this -> name;
    }

    public function getPath()
    {
        return $this->path;
    }
    public function getInfo():array
    {
        return array("name"=>$this->getName(),
            "path"=>$this->getPath(),
            "pathToThumb"=>$this->pathToThumb);
    }

    public static function createListPhotosInDirectory(){
        $photos = array();
        $files = scandir("files/forAdding");
        foreach ($files as &$file) {
            if(strlen($file)>5) {
                $tipeFile = mime_content_type("files/forAdding/$file");
                if (strripos($tipeFile, "image") !== false) {

                    rotateImage("files/forAdding/$file", "files/full/$file");
                    cropImage("files/forAdding/$file", "files/thumb/m_$file", 300, 300);

                    unlink("files/forAdding/$file");
                }
            }
        }
        $files = scandir("files/full");
        foreach ($files as $file) {
            if(strlen($file)>5) {
                array_push($photos,new Photo($file,"files/full/$file","files/thumb/m_$file"));
            }
        }
        return $photos;
    }
    public static function deleteAllPhotos(){
        $files = scandir("files/forAdding");
        foreach ($files as &$file) {
            unlink("files/forAdding/$file");
        }
        $files = scandir("files/thumb");
        foreach ($files as &$file) {
            unlink("files/thumb/$file");
        }
        $files = scandir("files/temp");
        foreach ($files as &$file) {
            unlink("files/temp/$file");
        }
        $files = scandir("files/full");
        foreach ($files as &$file) {
            unlink("files/full/$file");
        }
    }
}