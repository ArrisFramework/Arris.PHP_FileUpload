<?php

use PHPUnit\Framework\TestCase;

final class CustomErrorsTest extends TestCase
{
    public function testInvalidExtension()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);
        $upload->setAllowedExtensions(array("baz"));
        $upload->setErrorMessages(array(
            $upload::ERR_LONG_SIZE => "Fil3 siz3 is t00 l0ng!",
            $upload::ERR_INVALID_EXT => "Inv4lid 3xt3nsi0n!",
        ));
        $upload->check();

        $this->assertEquals("Inv4lid 3xt3nsi0n!", $upload->getError());
    }

    public function testLongSize()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 999999]);
        $upload->setMaxSize(0.1);
        $upload->setErrorMessages(array(
            $upload::ERR_LONG_SIZE => "Fil3 siz3 is t00 l0ng!",
            $upload::ERR_INVALID_EXT => "Inv4lid 3xt3nsi0n!",
        ));
        $upload->check();

        $this->assertEquals("Fil3 siz3 is t00 l0ng!", $upload->getError());
    }
}
