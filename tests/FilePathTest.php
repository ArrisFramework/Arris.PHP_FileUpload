<?php

use PHPUnit\Framework\TestCase;

final class FilePathTest extends TestCase
{
    public function testPath1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);
        $upload->setPath("xyz/abc");
        $upload->setName("hello");

        $this->assertEquals("hello.png", $upload->getName());
        $this->assertEquals("xyz/abc/", $upload->getPath(null, false));
        $this->assertEquals("xyz/abc/456.png", $upload->getPath("456.png"));
    }

    public function testPath2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
        $upload->setPath("animals/cats");
        $upload->setName("2020/08/Tekir");

        $this->assertEquals("2020/08/Tekir.jpg", $upload->getName());
        $this->assertEquals("animals/cats/", $upload->getPath(null, false));
        $this->assertEquals("animals/cats/456.jpeg", $upload->getPath("456.jpeg"));
    }
}