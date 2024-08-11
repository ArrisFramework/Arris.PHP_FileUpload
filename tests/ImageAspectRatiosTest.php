<?php

use PHPUnit\Framework\TestCase;

final class ImageAspectRatiosTest extends TestCase
{
    public function testAspectRatios1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_3_2.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_3_2.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("3:2", "19:1"))->check();
        $this->assertEquals(null, $upload->getError(false));
        $upload->setAspectRatios(array(3/2, 19/1))->check();
        $this->assertEquals(null, $upload->getError(false));
        $upload->setAspectRatios(array(1.5, 19))->check();
        $this->assertEquals(null, $upload->getError(false));
    }

    public function testAspectRatios2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_4_3.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_4_3.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("3:2", "4:3"))->check();
        $this->assertEquals(null, $upload->getError(false));
        $upload->setAspectRatios(array(3/2, 4/3))->check();
        $this->assertEquals(null, $upload->getError(false));
    }

    public function testAspectRatios3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_9_16.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_9_16.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("3:2", "4:3", "9:16"))->check();
        $this->assertEquals(null, $upload->getError(false));
        $upload->setAspectRatios(array(3/2, 4/3, 9/16))->check();
        $this->assertEquals(null, $upload->getError(false));
    }

    public function testAspectRatios4()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_16_9.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_16_9.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("3:2", "16:9", "4:3"))->check();
        $this->assertEquals(null, $upload->getError(false));
        $upload->setAspectRatios(array(3/2, 16/9, 4/3))->check();
        $this->assertEquals(null, $upload->getError(false));
    }

    public function testAspectRatios5()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_9_16.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_9_16.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("9:16"))->check();
        $this->assertEquals(null, $upload->getError(false));
        $upload->setAspectRatios(array(9/16))->check();
        $this->assertEquals(null, $upload->getError(false));
    }

    public function testAspectRatios6()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_9_16.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_9_16.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("3:2", "4:3"))->check();
        $this->assertEquals($upload::ERR_ASPECT_RATIO, $upload->getError(false));
        $upload->setAspectRatios(array(3/2, 4/3))->check();
        $this->assertEquals($upload::ERR_ASPECT_RATIO, $upload->getError(false));
    }

    public function testAspectRatios7()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "ratio_3_2.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/ratio_3_2.png", "error" => 0, "size" => 1]);
        $upload->setAspectRatios(array("3!^+2", "3::2", ":::"))->check();
        $this->assertEquals($upload::ERR_ASPECT_RATIO, $upload->getError(false));
    }
}