<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader {

    private $targetDirectory;
    private $currentFileName;

    public function __construct($targetDirectory, $currentFileName=NULL) {
        $this->targetDirectory = $targetDirectory;
        $this->currentFileName=$currentFileName;
    }

    public function upload(UploadedFile $file) {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $target_dir = $this->getTargetDirectory();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
            if($this->currentFileName){
                $this->fileRemove();
            }
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    private function fileRemove() {
        $filesystem = new Filesystem();
        $target_dir = $this->getTargetDirectory();
        if ($filesystem->exists($target_dir . '/' . $this->currentFileName)) {
            $filesystem->remove($target_dir . '/' . $this->currentFileName);
        }
    }

    public function getTargetDirectory() {
        return 'files/' . $this->targetDirectory;
    }

}
