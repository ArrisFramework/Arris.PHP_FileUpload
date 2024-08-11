<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;


if (isset($_FILES["file"])) {

    $upload = new FileUpload($_FILES["file"]);
    $upload->must_be_image();
    $upload->setMaxSize(5); // in MB
    $upload->setPath("upload/files");

    if (!$upload->upload()) {
        echo "Upload error: " . $upload->getError();
    } else {
        echo "Upload successful!";
    }

}
?>

<form enctype="multipart/form-data" action="" method="post">
    Select File: <input type="file" name="file"> <input type="submit" value="Upload">
</form>
