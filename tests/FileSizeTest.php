<?php

use PHPUnit\Framework\TestCase;

final class ImageSizeTest extends TestCase
{
    public function testMaxSize1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 94371840]);
        $upload->setMaxSize(1);
        $upload->check();

        $this->assertEquals($upload::ERR_LONG_SIZE, $upload->getError(false));
    }

    public function testMaxSize2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1048576]);
        $upload->setMaxSize(1);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMaxSize3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 2097152]);
        $upload->setMaxSize(10);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMinSize1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 2097152]);
        $upload->setMinSize(4);
        $upload->check();

        $this->assertEquals($upload::ERR_SMALL_SIZE, $upload->getError(false));
    }

    public function testMinSize2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 2097152]);
        $upload->setMinSize(2);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }

    public function testMinSize3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 20971520]);
        $upload->setMinSize(5);
        $upload->check();

        $this->assertEquals(null, $upload->getError(false));
    }
}
