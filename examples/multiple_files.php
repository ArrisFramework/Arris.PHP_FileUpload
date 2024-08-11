<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;


if (isset($_FILES["file"])) {

    $files = FileUpload::getUploadedFiles($_FILES["file"]);

    foreach ($files as $file) {
        $upload = new FileUpload($file);
        $upload->setAllowedExtensions(array("png", "jpg", "jpeg", "gif"));
        $upload->setMaxSize(5); // in MB
        $upload->setPath("upload/files");
        $upload->encrypt_name();

        if (!$upload->upload()) {
            echo $upload->getName() . ": Upload error: " . $upload->getError() . "<br />";
        } else {
            echo $upload->getName() . ": Upload successful! <br />";
        }
    }

}
?>

<form enctype="multipart/form-data" action="" method="post">
    Select Multiple Files: <input type="file" name="file[]" multiple> <input type="submit" value="Upload">
</form>
