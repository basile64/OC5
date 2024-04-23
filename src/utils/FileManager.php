<?php

namespace application\src\utils;

class FileManager
{

    public function fileExists($fileKey)
    {
        return isset($_FILES[$fileKey]);
    }

    public function isFileUploaded($fileKey)
    {
        return isset($_FILES[$fileKey]["tmp_name"]) && $_FILES[$fileKey]["error"] === UPLOAD_ERR_OK;
    }

    public function getFileMimeType($fileInputName)
    {
        if ($this->isFileUploaded($fileInputName)) {
            return mime_content_type($_FILES[$fileInputName]['tmp_name']);
        }
        return false;
    }

    public function isAllowedFileType($fileInputName, $allowedTypes)
    {
        $fileType = $this->getFileMimeType($fileInputName);
        return in_array($fileType, $allowedTypes);
    }

    public function isFileUnderSizeLimit($fileInputName, $maxSize)
    {
        if ($this->isFileUploaded($fileInputName)) {
            return $_FILES[$fileInputName]['size'] <= $maxSize;
        }
        return false;
    }

    public function generateUniqueFilename($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        return $basename . '_' . uniqid() . '.' . $extension;
    }

    public function moveUploadedFile($fileInputName, $destinationDirectory, $newFilename = null)
    {
        if ($this->isFileUploaded($fileInputName)) {
            $filename = $newFilename ? $newFilename : $this->generateUniqueFilename($_FILES[$fileInputName]['name']);
            $destination = rtrim($destinationDirectory, '/') . '/' . $filename;
            return move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $destination);
        }
        return false;
    }

    public function deleteFile($filePath)
    {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}
