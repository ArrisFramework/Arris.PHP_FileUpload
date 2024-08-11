<?php

use PHPUnit\Framework\TestCase;

final class MustBeImageTest extends TestCase
{
    public function testMustBeImage1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->must_be_image();
        $upload->check();

        $this->assertEquals($upload->getError(false), $upload::ERR_NOT_AN_IMAGE);
    }

    public function testMustBeImage2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.img", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);
        $upload->must_be_image();
        $upload->check();

        $this->assertEquals($upload->getError(false), null);
    }

    public function testMustBeImage3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpeg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->must_be_image();
        $upload->check();

        $this->assertEquals($upload->getError(false), null);
    }
}