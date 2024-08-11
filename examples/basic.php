<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;

if (isset($_FILES["file"])) {

    $upload = new FileUpload($_FILES["file"]);
    $upload->setAllowedExtensions(array("png", "jpg", "jpeg", "gif"));
    $upload->setAllowedTypes(array("image/png", "image/jpeg", "image/gif")); // not recommended
    $upload->setMaxSize(5); // in MB
    $upload->setMinSize(0); // in MB
    $upload->setPath("upload/files");
    $upload->encrypt_name();

    if (!$upload->upload()) {
        echo "Upload error: " . $upload->getError();
    } else {
        echo "Upload successful: " . $upload->getName();
    }

}
?>

<form enctype="multipart/form-data" action="" method="post">
    Select File: <input type="file" name="file"> <input type="submit" value="Upload">
</form>
