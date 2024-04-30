<?php

namespace application\src\models\file;

class FileManager
{
    /**
     * Checks if a file with the given key exists in the $_FILES array.
     *
     * @param string $fileKey The key of the file in the $_FILES array.
     * @return bool True if the file exists, false otherwise.
     */
    public function fileExists($fileKey)
    {
        return isset($_FILES[$fileKey]);
    }
    
    /**
     * Checks if the file with the given key has been uploaded successfully.
     *
     * @param string $fileKey The key of the file in the $_FILES array.
     * @return bool True if the file has been uploaded successfully, false otherwise.
     */
    public function isFileUploaded($fileKey)
    {
        return isset($_FILES[$fileKey]["tmp_name"]) && $_FILES[$fileKey]["error"] === UPLOAD_ERR_OK;
    }

    /**
     * Checks if the file has an allowed file type.
     *
     * @param File $file The file object.
     * @param array $allowedTypes An array of allowed file extensions.
     * @return bool True if the file has an allowed file type, false otherwise.
     */
    public function isAllowedFileType(File $file, $allowedTypes)
    {
        return in_array($file->getExtension(), $allowedTypes);
    }

    /**
     * Checks if the file size is under the specified size limit.
     *
     * @param File $file The file object.
     * @param int $maxSize The maximum allowed file size in bytes.
     * @return bool True if the file size is under the size limit, false otherwise.
     */
    public function isFileUnderSizeLimit(File $file, $maxSize)
    {
        return $file->getSize() <= $maxSize;
    }

    /**
     * Generates a unique filename based on the original filename.
     *
     * @param string $filename The original filename.
     * @return string The generated unique filename.
     */
    public function generateUniqueFilename($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        return $basename . '_' . uniqid() . '.' . $extension;
    }

    /**
     * Moves the uploaded file to the destination directory with an optional new filename.
     *
     * @param File $file The file object.
     * @param string $destinationDirectory The destination directory.
     * @param string|null $newFilename Optional new filename.
     * @return bool True if the file was moved successfully, false otherwise.
     */
    public function moveUploadedFile(File $file, $destinationDirectory, $newFilename = null)
    {
        if ($file->getTempName()) {
            $filename = $newFilename ? $newFilename : $this->generateUniqueFilename($file->getName());
            $destination = rtrim($destinationDirectory, '/') . '/' . $filename;
            return move_uploaded_file($file->getTempName(), $destination);
        }
        return false;
    }

    /**
     * Deletes the file at the specified file path.
     *
     * @param string $filePath The file path.
     * @return bool True if the file was deleted successfully, false otherwise.
     */
    public function deleteFile($filePath)
    {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}
