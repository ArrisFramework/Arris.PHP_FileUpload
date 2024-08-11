<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;


if (isset($_FILES["file"])) {

    $upload = (new FileUpload($_FILES["file"]))->setMaxSize(20)->setPath("upload/files")->encrypt_name();

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
