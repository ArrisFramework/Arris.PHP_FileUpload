<?php

use PHPUnit\Framework\TestCase;

final class UploadTest extends TestCase
{
    public function testUploadFiles()
    {
        $uploaded_files = [];

        for ($i = 1; $i <= 10; $i++) {
            $upload = new \Arris\Toolkit\FileUpload(["name" => "foo.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
            $upload->must_be_image();
            $upload->setPath(__DIR__ . "/files");
            $upload->setName("bar");

            $this->assertEquals(true, $upload->upload(true));
            $this->assertEquals(true, $upload->check());
            $suffix = $i > 1 ? "_{$i}" : "";
            $this->assertEquals("bar{$suffix}.jpg", $upload->getName());
            $uploaded_files[] = $upload->getPath();
        }

        foreach ($uploaded_files as $file) {
            @unlink($file);
        }
    }

    public function testUploadFiles2()
    {
        $uploaded_files = [];

        for ($i = 1; $i <= 10; $i++) {
            $upload = new \Arris\Toolkit\FileUpload(["name" => "xyz.jpg", "type" => "image/jpeg", "tmp_name" => __DIR__ . "/assets/foo.jpg", "error" => 0, "size" => 1]);
            $upload->must_be_image();
            $upload->setPath(__DIR__ . "/files");

            $this->assertEquals(true, $upload->upload(true));
            $this->assertEquals(true, $upload->check());
            $suffix = $i > 1 ? "_{$i}" : "";
            $this->assertEquals("xyz{$suffix}.jpg", $upload->getName());
            $uploaded_files[] = $upload->getPath();
        }

        foreach ($uploaded_files as $file) {
            @unlink($file);
        }
    }

    public function testFromBase64()
    {
        $base64_data = base64_encode(file_get_contents(__DIR__ . "/assets/foo.jpg"));
        $upload = new \Arris\Toolkit\FileUpload(\Arris\Toolkit\FileUpload::from_base64($base64_data));
        $upload->setAllowedExtensions(array("jpg", "jpeg"));
        $upload->setAllowedTypes(array("image/jpeg"));
        $upload->setMaxDimensions(210, 60);
        $upload->setMinDimensions(210, 60);
        $upload->setName("hello.jpg", false);
        $this->assertEquals(true, $upload->upload(true));
        $this->assertEquals(true, $upload->check());
        $this->assertEquals("hello.jpg", $upload->getName());
        @unlink($upload->getPath("hello.jpg"));
    }
}
