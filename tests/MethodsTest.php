<?php

use PHPUnit\Framework\TestCase;

final class MethodsTest extends TestCase
{
    public function testGetTmpName()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);

        $this->assertNotNull($upload->getTempName());
    }

    public function testGetDataUrl()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);

        $this->assertEquals(trim(file_get_contents(__DIR__ . "/assets/foo.base64")), $upload->getDataURL());
    }

    public function testGetType()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);

        $this->assertEquals("image/png", $upload->getType());
    }

    public function testGetSize()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);

        $this->assertEquals(1, (int)$upload->getSize());
    }

    public function testValidateAspectRatio()
    {
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio("3:2", 300, 200));
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio(3/2, 300, 200));
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio(1.5, 300, 200));
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio("1:1", 300, 300));
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio(1, 300, 300));
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio("16:9", 1920, 1080));
        $this->assertTrue(\Arris\Toolkit\FileUpload::validate_aspect_ratio(16/9, 1920, 1080));
        $this->assertFalse(\Arris\Toolkit\FileUpload::validate_aspect_ratio("1:1", 300, 300.1));
        $this->assertFalse(\Arris\Toolkit\FileUpload::validate_aspect_ratio(1, 300, 300.1));
        $this->assertFalse(\Arris\Toolkit\FileUpload::validate_aspect_ratio("1:1", 300, 399));
        $this->assertFalse(\Arris\Toolkit\FileUpload::validate_aspect_ratio(1, 300, 399));
    }
}