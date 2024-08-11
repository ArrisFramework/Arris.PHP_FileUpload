### Uploader 🚀

Safe, simple and useful file upload class

### Installing
```
composer require karelwintersky/arris.php-file-upload
```

### Examples
Basic:
```php
use Arris\Toolkit\FileUpload;

if (isset($_FILES["file"])) {
    $upload = new FileUpload($_FILES["file"]);
    $upload->setAllowedExtensions(array("png", "jpg", "jpeg", "gif"));
    $upload->setMaxSize(5); // in MB
    $upload->setPath("upload/files");
    $upload->setName("foo");
    
    if (! $upload->upload()) {
        echo "Upload error: " . $upload->getError();
    } else {
        echo "Upload successful!";
    }
}
```

Inline using:
```php
use Arris\Toolkit\FileUpload;

if (isset($_FILES["file"])) {
    $upload = (new FileUpload($_FILES["file"]))->setMaxSize(20)->setPath("upload/files")->encrypt_name();
    
    if (! $upload->upload()) {
        echo "Upload error: " . $upload->getError();
    } else {
        echo "Upload successful!";
    }
}
```

More examples in the "[examples](/examples)" directory.

### Methods
| Name                                           | Description                                                  |
|------------------------------------------------|--------------------------------------------------------------|
| `setAllowedExtensions(array $extensions)`      | Allowed file extensions (example: png, gif, jpg)             |
| `setDisallowedExtensions(array $extensions)`   | Disallowed file extensions (example: html, php, dmg)         |
| `setAllowedTypes(array $types)`                | Allowed mime types (example: image/png, image/jpeg)          |
| `setDisallowedTypes(array $types)`             | Disallowed mime types                                        |
| `setMaxSize(int $size)`                        | Maximum file size (as MB)                                    |
| `setMinSize(int $size)`                        | Minimum file size (as MB)                                    |
| `override()`                                   | Override the file with the same name                         |
| `setPath(string $path)`                        | Set the path where files will be uploaded                    |
| `setName(string $name)`                        | Rename the uploaded file (example: foo)                      |
| `encrypt_name()`                               | Encrypt file name to hide the original name                  |
| `must_be_image()`                              | Check the file is image                                      |
| `setMaxDimensions(int $width, int $height)`    | Maximum image dimensions                                     |
| `setMinDimensions(int $width, int $height)`    | Minimum image dimensions                                     |
| `setAspectRatios(array $aspect_ratios)`        | Image aspect ratios that has to be (example: 1:1, 4:3, 16:9) |
| `setErrorMessages(array $errors)`              | Custom error messages                                        |

| Name            | Description                                      | Return  |
|-----------------|--------------------------------------------------|---------|
| `upload()`      | Upload the file and return output of the check() | boolean |
| `check()`       | Check the file can be uploaded                   | boolean |
| `getName()`     | Get the uploaded file name                       | string  |
| `getPath()`     | Get the uploaded file name with full path        | string  |
| `getTempName()` | Get the temporary file path                      | string  |
| `getSize()`     | Get the uploaded file size in bytes              | string  |
| `getType()`     | Get the uploaded file mime type                  | string  |
| `getDataURL()`  | Get the file as base64 encoded data URL          | string  |
| `getError()`    | Get error message if an error occurred           | string  |

### Notes
`exif` and `fileinfo` extensions must be enabled.

Based on https://github.com/iamdual/uploader 