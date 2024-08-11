<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;


if (isset($_FILES["file"])) {

    $upload = new FileUpload($_FILES["file"]);
    $upload->setAllowedExtensions(array("png", "jpg", "jpeg", "gif"));
    $upload->setMaxSize(5); // in MB

    if (!$upload->check()) {
        echo "An error occurred: " . $upload->getError();
    } else {
        echo 'Base64 encoded data URL:<br /><textarea cols=80 rows=10>'.$upload->getDataURL().'</textarea>';
    }

}
?>

<form enctype="multipart/form-data" action="" method="post">
    Select File: <input type="file" name="file"> <input type="submit" value="Upload">
</form>
