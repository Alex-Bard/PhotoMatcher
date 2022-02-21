<?php

namespace test;
require_once(__DIR__.'/../../businessLogic/ObjectSaverInFile.php');
use app\ObjectSaverInFile;
use PHPUnit\Framework\TestCase;

class ObjectSaverInFileTest extends TestCase
{


    public function testGetObjectFromFile()
    {
        $testFileName = "123";
        $obj = new ObjectSaverInFile("123");
        $saver = new ObjectSaverInFile($testFileName);
        $saver->saveObjectInFile($obj);
        $recObj = $saver->getObjectFromFile();
        self::assertEquals($obj,$recObj);
        unlink($testFileName);
    }

    public function testDeleteFile()
    {
        $testFileName = "123";
        $saver = new ObjectSaverInFile($testFileName);
        file_put_contents($testFileName, "123");
        $saver->deleteFile();
        self::assertFalse(file_exists($testFileName));
    }

    public function testHasFile(){
        $testFileName = "123";
        $saver = new ObjectSaverInFile($testFileName);
        file_put_contents($testFileName, "123");
        self::assertTrue($saver->hasFile());
        unlink($testFileName);
        self::assertFalse($saver->hasFile());
    }

}
