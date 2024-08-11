<?php

namespace Arris\Toolkit;

class FileUpload implements FileUploadInterface
{
    const ERR_EMPTY_FILE    = 1;
    const ERR_INVALID_EXT   = 2;
    const ERR_INVALID_TYPE  = 3;
    const ERR_LONG_SIZE     = 4;
    const ERR_SMALL_SIZE    = 5;
    const ERR_UNKNOWN_ERROR = 6;
    const ERR_NOT_AN_IMAGE  = 7;
    const ERR_MAX_DIMENSION = 8;
    const ERR_MIN_DIMENSION = 9;
    const ERR_ASPECT_RATIO  = 10;

    /**
     * Error ID
     * @var int|null
     */
    private ?int $error = null;

    /**
     * The file array
     *
     * @var array
     */
    private array $file = [];

    /**
     * Default error messages
     * @var array
     */
    private array $error_messages = array(
        self::ERR_EMPTY_FILE    => "No file selected.",
        self::ERR_INVALID_EXT   => "Invalid file extension.",
        self::ERR_INVALID_TYPE  => "Invalid file mime type.",
        self::ERR_LONG_SIZE     => "File size is too large.",
        self::ERR_SMALL_SIZE    => "File size is too small.",
        self::ERR_UNKNOWN_ERROR => "Unknown error occurred.",
        self::ERR_NOT_AN_IMAGE  => "The selected file must be an image.",
        self::ERR_MAX_DIMENSION => "The dimensions of the image is too large.",
        self::ERR_MIN_DIMENSION => "The dimensions of the image is too small.",
        self::ERR_ASPECT_RATIO  => "The aspect ratio of the image is not as specified.",
    );

    /**
     * Customized error messages
     * @var array
     */
    public array $custom_error_messages = [];

    /**
     * @var array
     */
    public array $allowed_extensions = [];

    /**
     * @var array
     */
    public array $disallowed_extensions = [];

    /**
     * @var array
     */
    public array $types = [];

    /**
     * @var array
     */
    public array $disallowed_types = [];

    /**
     * @var int|null
     */
    public ?int $max_size = null;

    /**
     * @var int|null
     */
    public ?int $min_size = null;

    /**
     * @var string|null
     */
    public ?string $path = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var boolean
     */
    public bool $auto_extension = true;

    /**
     * @var boolean
     */
    public bool $must_be_image = false;

    /**
     * @var array
     */
    public array $max_image_dimensions = [];

    /**
     * @var array
     */
    public array $min_image_dimensions = [];

    /**
     * @var array
     */
    public array $image_aspect_ratios = [];

    /**
     * @var boolean
     */
    public bool $encrypt_name = false;

    /**
     * @var boolean
     */
    public bool $override = false;

    /**
     * Set the file array ($_FILES or equivalent of this)
     *
     * @param array $file
     */
    public function __construct(array $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Allowed file extensions (example: png, gif, jpg)
     * @param array $extensions
     * @return $this
     */
    public function setAllowedExtensions(array $extensions = []): FileUpload
    {
        $this->allowed_extensions = $extensions;
        return $this;
    }

    /**
     * Disallowed file extensions (example: html, php, dmg)
     * @param array $extensions
     * @return $this
     */
    public function setDisallowedExtensions(array $extensions = []): FileUpload
    {
        $this->disallowed_extensions = $extensions;
        return $this;
    }

    /**
     * Allowed mime types (example: image/png, image/jpeg)
     * @param array $types
     * @return $this
     */
    public function setAllowedTypes(array $types = []): FileUpload
    {
        $this->types = $types;
        return $this;
    }

    /**
     * Disallowed mime types
     * @param array $types
     * @return $this
     */
    public function setDisallowedTypes(array $types = []): FileUpload
    {
        $this->disallowed_types = $types;
        return $this;
    }

    /**
     * Maximum file size in MB
     * @param int|float $size
     * @return $this
     */
    public function setMaxSize($size = null): FileUpload
    {
        $this->max_size = $size;
        return $this;
    }

    /**
     * Minimum file size in MB
     * @param int|float $size
     * @return $this
     */
    public function setMinSize($size = null): FileUpload
    {
        $this->min_size = $size;
        return $this;
    }

    /**
     * Maximum dimensions of the image
     * @param int|float|null $width
     * @param int|float|null $height
     * @return $this
     */
    public function setMaxDimensions($width, $height): FileUpload
    {
        $this->max_image_dimensions = [$width, $height];
        return $this;
    }

    /**
     * Minimum dimensions of the image
     * @param int|float|null $width
     * @param int|float|null $height
     * @return $this
     */
    public function setMinDimensions($width, $height): FileUpload
    {
        $this->min_image_dimensions = [$width, $height];
        return $this;
    }

    /**
     * Image aspect ratios has to be
     * @param array $aspect_ratios
     * @return $this
     */
    public function setAspectRatios(array $aspect_ratios = []): FileUpload
    {
        $this->image_aspect_ratios = $aspect_ratios;
        return $this;
    }

    /**
     * Override (write over) the file with the same name
     * @return $this
     */
    public function override(): FileUpload
    {
        $this->override = true;
        return $this;
    }

    /**
     * The path where files will be uploaded
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): FileUpload
    {
        $this->path = \rtrim($path, "/");
        return $this;
    }

    /**
     * Rename the uploaded file (example: foo)
     * @param string $name
     * @param boolean $auto_extension
     * @return $this
     */
    public function setName(string $name, bool $auto_extension = true): FileUpload
    {
        $this->name = $name;
        $this->auto_extension = $auto_extension;
        return $this;
    }

    /**
     * Encrypt file name to hide the original name
     *
     * @return $this
     */
    public function encrypt_name(): FileUpload
    {
        $this->encrypt_name = true;
        return $this;
    }

    /**
     * Verify that the file is an image
     * @return $this
     */
    public function must_be_image(): FileUpload
    {
        $this->must_be_image = true;
        return $this;
    }

    /**
     * Set custom error messages
     * @param array $errors
     * @return $this
     */
    public function setErrorMessages(array $errors = []): FileUpload
    {
        $this->custom_error_messages = $errors;
        return $this;
    }

    /**
     * Get error message
     * @param string $error_id
     * @return string|null
     */
    public function getErrorMessage(string $error_id): ?string
    {
        if (!empty($this->custom_error_messages) && isset($this->custom_error_messages[$error_id])) {
            return $this->custom_error_messages[$error_id];
        }
        return $this->error_messages[$error_id] ?? null;
    }

    /**
     * Get file name
     * @return string
     */
    public function getName():string
    {
        if ($this->name === null) {
            $this->name = $this->file["name"];
            $this->auto_extension = false;
        }

        if ($this->encrypt_name) {
            $this->name = self::hashed($this->name) . self::getExtension($this->file["name"], true);
            $this->encrypt_name = false;
            $this->auto_extension = false;
        }

        if ($this->auto_extension) {
            return $this->name . self::getExtension($this->file["name"], true);
        } else {
            return $this->name;
        }
    }

    /**
     * Get the name of the temporary file
     * @return string
     */
    public function getTempName(): ?string
    {
        return $this->file["tmp_name"] ?? null;
    }

    /**
     * Get the mime type of the file
     * @return string
     */
    public function getType(): ?string
    {
        return $this->file["type"] ?? null;
    }

    /**
     * Get the size of the file
     * @return int
     */
    public function getSize(): ?int
    {
        return $this->file["size"] ?? null;
    }

    /**
     * Get the data URL of the temporary file
     * @return string
     */
    public function getDataURL(): ?string
    {
        return self::data_url($this->getTempName());
    }

    /**
     * Check the file can be uploaded
     * @return boolean
     */
    public function check(): bool
    {
        if (empty($this->file) || !is_null($this->error)) {
            return false;
        }

        // Standard validations
        if (!isset($this->file["name"]) || !isset($this->file["tmp_name"]) || !isset($this->file["type"]) || !isset($this->file["size"]) || !isset($this->file["error"])) {
            $this->error = self::ERR_EMPTY_FILE;
        } else if (strlen($this->file["name"]) == 0 || strlen($this->file["tmp_name"]) == 0 || strlen($this->file["type"]) == 0 || $this->file["size"] == 0) {
            $this->error = self::ERR_EMPTY_FILE;
        } else if (!empty($this->allowed_extensions) && !in_array(self::getExtension($this->file["name"]), $this->allowed_extensions)) {
            $this->error = self::ERR_INVALID_EXT;
        } else if (!empty($this->disallowed_extensions) && in_array(self::getExtension($this->file["name"]), $this->disallowed_extensions)) {
            $this->error = self::ERR_INVALID_EXT;
        } else if (!empty($this->types) && !in_array($this->file["type"], $this->types)) {
            $this->error = self::ERR_INVALID_TYPE;
        } else if (!empty($this->disallowed_types) && in_array($this->file["type"], $this->disallowed_types)) {
            $this->error = self::ERR_INVALID_TYPE;
        } else if (!is_null($this->max_size) && $this->file["size"] > self::mb_to_byte($this->max_size)) {
            $this->error = self::ERR_LONG_SIZE;
        } else if (!is_null($this->min_size) && $this->file["size"] < self::mb_to_byte($this->min_size)) {
            $this->error = self::ERR_SMALL_SIZE;
        } else if ($this->file["error"] == 1 || $this->file["error"] == 2) {
            $this->error = self::ERR_LONG_SIZE;
        } else if ($this->file["error"] == 4) {
            $this->error = self::ERR_EMPTY_FILE;
        } else if ($this->file["error"] > 0) {
            $this->error = self::ERR_UNKNOWN_ERROR;
        }

        if ($this->error !== null) {
            return false;
        }

        // Image validations
        if (!empty($this->max_image_dimensions) || !empty($this->min_image_dimensions) || !empty($this->image_aspect_ratios)) {
            $image_dimensions = getimagesize($this->file["tmp_name"]);
            if (!$image_dimensions) {
                $this->error = self::ERR_NOT_AN_IMAGE;
                return false;
            }
            if (!empty($this->max_image_dimensions)) {
                for ($i = 0; $i <= 1; $i++) {
                    if (isset($this->max_image_dimensions[$i]) && is_numeric($this->max_image_dimensions[$i]) && $image_dimensions[$i] > $this->max_image_dimensions[$i]) {
                        $this->error = self::ERR_MAX_DIMENSION;
                        return false;
                    }
                }
            }
            if (!empty($this->min_image_dimensions)) {
                for ($i = 0; $i <= 1; $i++) {
                    if (isset($this->min_image_dimensions[$i]) && is_numeric($this->min_image_dimensions[$i]) && $image_dimensions[$i] < $this->min_image_dimensions[$i]) {
                        $this->error = self::ERR_MIN_DIMENSION;
                        return false;
                    }
                }
            }
            if (!empty($this->image_aspect_ratios)) {
                foreach ($this->image_aspect_ratios as $aspect_ratio) {
                    if (self::validate_aspect_ratio($aspect_ratio, $image_dimensions[0], $image_dimensions[1])) {
                        if ($this->error === self::ERR_ASPECT_RATIO) {
                            $this->error = null;
                        }
                        break; // Validation completed.
                    } else {
                        $this->error = self::ERR_ASPECT_RATIO;
                    }
                }
            }
        } else if ($this->must_be_image) {
            // If the file must be an image and getimagesize() didn't check the file, we need to use exif_imagetype instead of getimagesize for the performance.
            if (!exif_imagetype($this->file["tmp_name"])) {
                $this->error = self::ERR_NOT_AN_IMAGE;
                return false;
            }
        }

        return $this->error === null;
    }

    /**
     * Get error if exists
     * @param boolean $with_message (optional)
     * @return string
     */
    public function getError(bool $with_message = true)
    {
        return $with_message ? $this->getErrorMessage($this->error) : $this->error;
    }

    /**
     * Upload the file.
     *
     * @param boolean $copy_file (optional)
     * @return boolean
     */
    public function upload(bool $copy_file = false): bool
    {
        if ($this->check()) {
            $upload_dir = $this->getPath(null, false);
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }
            $filepath = $this->getPath();
            if ($this->override === false && file_exists($filepath)) {
                $number = 2;
                $filename = pathinfo($filepath, PATHINFO_FILENAME);
                do {
                    $this->setName($filename . (($number) ? "_{$number}" : ""), true);
                    $number++;
                } while (file_exists($this->getPath()));
            }
            if ($copy_file) {
                copy($this->file["tmp_name"], $this->getPath());
            } else {
                move_uploaded_file($this->file["tmp_name"], $this->getPath());
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the full path
     * @param string|null $filename (optional)
     * @param bool $include_filename (optional)
     * @return string
     */
    public function getPath(?string $filename = null, bool $include_filename = true): string
    {
        $path = "";
        if ($this->path !== null) {
            $path = $this->path . "/";
        }
        if (!$include_filename) {
            return $path;
        }

        if ($filename === null) {
            $filename = $this->getName();
        }
        return $path . $filename;
    }

    /**
     * Get extension by filename
     * @param string $filename
     * @param boolean $with_dot
     * @return string
     */
    public static function getExtension(string $filename, bool $with_dot = false): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($with_dot && $extension) {
            return "." . $extension;
        }
        return $extension;
    }

    /**
     * Validate aspect ratio
     * @param mixed $aspect_ratio
     * @param int $width
     * @param int $height
     * @return bool
     */
    public static function validate_aspect_ratio($aspect_ratio, $width, $height): bool
    {
        if (!is_numeric($aspect_ratio)) {
            if (is_string($aspect_ratio)) {
                $aspect_ratio_pieces = explode(":", $aspect_ratio);
            } else if (is_array($aspect_ratio)) {
                $aspect_ratio_pieces = $aspect_ratio;
            }
            if (empty($aspect_ratio_pieces[0]) || empty($aspect_ratio_pieces[1])) {
                return false;
            }
            $aspect_ratio = (int)$aspect_ratio_pieces[0] / (int)$aspect_ratio_pieces[1];
        }

        return ($width / $height) === $aspect_ratio;
    }

    /**
     * Calculate the bytes
     * @param int $filesize
     * @return int
     */
    public static function mb_to_byte(int $filesize):int
    {
        return $filesize * 1048576; // equivalent of "pow(1024, 2)"
    }

    /**
     * Create multiple file array
     * @param array $file_array
     * @return array
     */
    public static function getUploadedFiles(array $file_array):array
    {
        $files = [];
        foreach ($file_array as $files_key => $files_array) {
            foreach ($files_array as $i => $val) {
                $files[$i][$files_key] = $val;
            }
        }
        return $files;
    }

    /**
     * Create file array from base64 encoded file
     * @param string $base64
     * @param array $mime_map (optional)
     * @return array
     */
    public static function from_base64(string $base64, array $mime_map = []):array
    {
        $encoded = explode(";base64,", $base64, 2);
        if (isset($encoded[1])) {
            $base64 = $encoded[1];
        }
        return self::create_temp_file(base64_decode($base64), $mime_map);
    }

    /**
     * Create file array from raw input
     * @param array $mime_map (optional)
     * @return array
     */
    public static function from_raw_input(array $mime_map = []): array
    {
        return self::create_temp_file(file_get_contents("php://input"), $mime_map);
    }

    /**
     * Create a temporary file from source
     * @param string $source
     * @param array $mime_map (optional)
     * @return array
     */
    public static function create_temp_file(string $source, array $mime_map = []): array
    {
        $temp = tmpfile();
        fwrite($temp, $source);
        $meta = stream_get_meta_data($temp);
        $mime = mime_content_type($meta["uri"]);

        if (isset($mime_map[$mime])) {
            $ext = $mime_map[$mime];
        } else {
            $arr = explode("/", $mime);
            $ext = end($arr);
        }

        register_shutdown_function(function () use ($temp) {
            fclose($temp);
        });

        return array(
            "name" => self::hashed($meta["uri"]) . "." . $ext,
            "size" => filesize($meta["uri"]),
            "type" => $mime,
            "tmp_name" => $meta["uri"],
            "error" => 0
        );
    }

    /**
     * Hashed text
     * @param string $filename
     * @return string
     */
    public static function hashed(string $filename): string
    {
        return sha1($filename . "-" . rand(10000, 99999) . "-" . time());
    }

    /**
     * Get the data URL by the file path
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/Data_URIs
     *
     * @param string $filepath
     * @return string
     */
    public static function data_url(string $filepath): ?string
    {
        if (file_exists($filepath)) {
            $mime = mime_content_type($filepath);
            $source = file_get_contents($filepath);
            $encoded = base64_encode($source);
            return 'data:' . $mime . ';base64,' . $encoded;
        }
        return null;
    }
}
