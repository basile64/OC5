<?php

namespace application\src\models\file;

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

    public function isAllowedFileType(File $file, $allowedTypes)
    {
        return in_array($file->getExtension(), $allowedTypes);
    }

    public function isFileUnderSizeLimit(File $file, $maxSize)
    {
        return $file->getSize() <= $maxSize;
    }

    public function generateUniqueFilename($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        return $basename . '_' . uniqid() . '.' . $extension;
    }

    public function moveUploadedFile(File $file, $destinationDirectory, $newFilename = null)
    {
        if ($file->getTempName()) {
            $filename = $newFilename ? $newFilename : $this->generateUniqueFilename($file->getName());
            $destination = rtrim($destinationDirectory, '/') . '/' . $filename;
            return move_uploaded_file($file->getTempName(), $destination);
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
