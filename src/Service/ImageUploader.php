<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct(SluggerInterface $slugger, string $recordImageDir)
    {
        $this->slugger = $slugger;
        $this->targetDirectory = $recordImageDir;
    }

    public function upload($form)
    {
        $files = [];
        for ($i = 0; $i < 4; $i++) {
            if ($file = $form['attachments'][$i]['file']->getData()) {
                $files[] = $file;
            }
        }

        $fileNames = [];
        foreach ($files as $file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

            $fileNames[] = $fileName;

            try {
                $file->move($this->getTargetDirectory(), $fileName);
            } catch (FileException $e) {
                // unable to upload/move file
            }
        }

        return $fileNames;
    }

    public function setTargetDirectory($dir)
    {
        $this->targetDirectory = $dir;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
