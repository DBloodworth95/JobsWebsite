<?php
//Handles file requests.
namespace CSY2028;

class FileUploader {

    public function __construct($files) {
        $this->files = $files;
    }

    public function handleUpload($name, $destination) {
            return move_uploaded_file($this->files[$name]['tmp_name'], $destination);
    }
}