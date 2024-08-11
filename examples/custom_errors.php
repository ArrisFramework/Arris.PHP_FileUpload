<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;


if (isset($_FILES["file"])) {

    $upload = new FileUpload($_FILES["file"]);
    $upload->setErrorMessages(array(
        $upload::ERR_LONG_SIZE => "Fil3 siz3 is t00 l0ng!",
        $upload::ERR_INVALID_EXT => "Inv4lid 3xt3nsi0n!",
    ));
    $upload->setMaxSize(0.2); // in MB
    $upload->setAllowedExtensions(array("baz"));
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
