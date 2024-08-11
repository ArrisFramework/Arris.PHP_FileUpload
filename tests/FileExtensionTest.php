<?php

use PHPUnit\Framework\TestCase;

final class FileExtensionTest extends TestCase
{
    public function testExtension1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);
        $upload->setAllowedExtensions(array("png", "gif"));
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testExtension2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.json", "type" => "application/json", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setAllowedExtensions(array("png", "gif"));
        $upload->check();

        $this->assertEquals($upload::ERR_INVALID_EXT, $upload->getError(false));
    }

    public function testExtension3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.json", "type" => "application/json", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setDisallowedExtensions(array("png", "gif"));
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }
}
