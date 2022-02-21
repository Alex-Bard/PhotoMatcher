<?php
require_once "businessLogic/ObjectSaverInFile.php";
use app\ObjectSaverInFile;

$saver = new ObjectSaverInFile("data");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($saver->hasFile()){
        http_response_code(200);
        echo json_encode(array("state" => "hasOld"), JSON_UNESCAPED_UNICODE);
    }
    else{
        echo json_encode(array("state" => "notHasOld"), JSON_UNESCAPED_UNICODE);
    }
}
elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $saver->deleteFile();
    http_response_code(200);
}