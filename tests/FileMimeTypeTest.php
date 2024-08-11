<?php

use PHPUnit\Framework\TestCase;

final class FileMimeTypeTest extends TestCase
{
    public function testMimeType1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setAllowedTypes(array("image/jpeg", "image/png"));
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMimeType2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.json", "type" => "application/json", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setAllowedTypes(array("image/jpeg", "image/png"));
        $upload->check();

        $this->assertEquals($upload::ERR_INVALID_TYPE, $upload->getError(false));
    }

    public function testMimeType3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.json", "type" => "application/json", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setDisallowedTypes(array("image/jpeg", "image/png"));
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }
}
