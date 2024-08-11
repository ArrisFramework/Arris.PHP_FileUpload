<?php
require __DIR__ . '/../src/FileUpload.php';

use Arris\Toolkit\FileUpload;

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {

    $upload = new FileUpload(FileUpload::from_raw_input());
    $upload->setMaxSize(5); // in MB
    $upload->setPath("upload/files");

    // While uploading file from raw input data, you need to change upload function
    // to "copy", otherwise file can not be uploaded!

    if (! $upload->upload(true)) {
        echo "Upload error: " . $upload->getError() . PHP_EOL;
    } else {
        echo "Upload successful: " . $upload->getName() . PHP_EOL;
    }

} else {

    echo <<<HTML

Sending files with raw input, allows you sending files from command line:
<br/>
<pre>
curl --upload-file ./hello.txt http://upload.local/examples/raw_input.php
</pre>

HTML;

}
