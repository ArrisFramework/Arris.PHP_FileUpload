<?php

use PHPUnit\Framework\TestCase;

final class FileNameTest extends TestCase
{
    public function testName1()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);
        $upload->setName("bar");

        $this->assertEquals("bar.png", $upload->getName());
    }

    public function testName2()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);

        $this->assertEquals("foo.png", $upload->getName());
    }

    public function testName3()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.png", "type" => "image/png", "tmp_name" => __DIR__ . "/assets/foo.png", "error" => 0, "size" => 1]);
        $upload->setName("bar.xyz", false);

        $this->assertEquals("bar.xyz", $upload->getName());
    }

    public function testName4()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setName("foo");

        $this->assertEquals("foo.jpg", $upload->getName());
    }

    public function testName5()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setName("foo");
        $upload->encrypt_name();

        $this->assertNotEquals("foo.json", $upload->getName());
        $this->assertEquals(false, $upload->encrypt_name); // Because it's setting to 'true' once
    }

    public function testName6()
    {
        $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.json", "error" => 0, "size" => 1]);
        $upload->setName("folder1/folder2/foo.xyz", false);

        $this->assertEquals("folder1/folder2/foo.xyz", $upload->getName());
    }
}
