<?php

use PHPUnit\Framework\TestCase;

final class ImageDimensionsTest extends TestCase
{
    public function testMaxImageDimension1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMaxDimensions(200, 50);
        $upload->check();

        $this->assertEquals($upload::ERR_MAX_DIMENSION, $upload->getError(false));
    }

    public function testMaxImageDimension2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMaxDimensions(210, 20);
        $upload->check();

        $this->assertEquals($upload::ERR_MAX_DIMENSION, $upload->getError(false));
    }

    public function testMaxImageDimension3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMaxDimensions(210, 60);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMaxImageDimension4()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMaxDimensions(400, 80);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMinImageDimension1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMinDimensions(300, 20);
        $upload->check();

        $this->assertEquals($upload::ERR_MIN_DIMENSION, $upload->getError(false));
    }

    public function testMinImageDimension2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMinDimensions(210, 80);
        $upload->check();

        $this->assertEquals($upload::ERR_MIN_DIMENSION, $upload->getError(false));
    }

    public function testMinImageDimension3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMinDimensions(210, 60);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMinImageDimension4()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setMinDimensions(100, 20);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }
}