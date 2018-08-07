<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\FileSystem;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    private $fileName;
    private $uploadDir;
    public function __construct(FileNameInterface $fileName, string $uploadDir)
    {
        $this->fileName = $fileName;
        $this->uploadDir = $uploadDir;
    }
    public function upload(UploadedFile $file): ?string
    {
        try {
            $newFileName = $this->fileName->getName($file->getClientOriginalName());
            $file->move($this->uploadDir, $newFileName);

            return $newFileName;
        } catch (FileException $e) {
            return null;
        }
    }
}
