<?php
require_once "businessLogic/Match.php";
require_once "businessLogic/ObjectSaverInFile.php";
require_once "businessLogic/Photo.php";
use app\Match;
use app\Photo;
use app\ObjectSaverInFile;

$match = null;
$saver = new ObjectSaverInFile("data");
if ($saver->hasFile()){
    $match = $saver->getObjectFromFile();
}
else {
    $photos = Photo::createListPhotosInDirectory();
    $match = new Match($photos);
    $saver->saveObjectInFile($match);
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['hasNext'])) {
        http_response_code(200);
        echo json_encode(array("hasNext" =>$match->hasNextStep()), JSON_UNESCAPED_UNICODE);
    }
    elseif(isset($_GET['pair'])) {
        http_response_code(200);
        echo json_encode($match->nextStep(), JSON_UNESCAPED_UNICODE);
    }
    elseif(isset($_GET['win'])){
        http_response_code(200);
        echo json_encode($match->getResult(), JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Bad request"), JSON_UNESCAPED_UNICODE);
    }

}
elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->winner)) {
        if ($data->winner == "left"){
            $match->setWinnerLeft();
            http_response_code(200);
        }else{
            $match->setWinnerRight();
            http_response_code(200);
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Bad request"), JSON_UNESCAPED_UNICODE);
    }

}

$saver->saveObjectInFile($match);