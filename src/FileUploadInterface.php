<?php

namespace Arris\Toolkit;

interface FileUploadInterface
{
    public function __construct(array $file);

    public function setAllowedExtensions(array $extensions = []): FileUpload;
    public function setDisallowedExtensions(array $extensions = []): FileUpload;

    public function setAllowedTypes(array $types = []): FileUpload;
    public function setDisallowedTypes(array $types = []): FileUpload;

    public function setMaxSize($size = null): FileUpload;
    public function setMinSize($size = null): FileUpload;

    public function setMaxDimensions($width, $height): FileUpload;
    public function setMinDimensions($width, $height): FileUpload;

    public function setAspectRatios(array $aspect_ratios = []): FileUpload;

    public function override(): FileUpload;

    public function setPath(string $path): FileUpload;
    public function setName(string $name, bool $auto_extension = true): FileUpload;

    public function encrypt_name(): FileUpload;
    public function must_be_image(): FileUpload;

    public function getName():string;
    public function getTempName(): ?string;
    public function getType(): ?string;
    public function getSize(): ?int;
    public function getPath(?string $filename = null, bool $include_filename = true): string;

    public function getDataURL(): ?string;

    public function check(): bool;
    public function upload(bool $copy_file = false): bool;

    public function getError(bool $with_message = true);
    public function setErrorMessages(array $errors = []): FileUpload;
    public function getErrorMessage(string $error_id): ?string;

    public static function from_base64(string $base64, array $mime_map = []):array;
    public static function from_raw_input(array $mime_map = []): array;
    public static function create_temp_file(string $source, array $mime_map = []): array;
    public static function getExtension(string $filename, bool $with_dot = false): string;
    public static function hashed(string $filename): string;
    public static function data_url(string $filepath): ?string;

}