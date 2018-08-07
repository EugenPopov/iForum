<?php

namespace App\Service\FileSystem;

class Md5FileName implements FileNameInterface
{
    public function getName(string $originName): string
    {
        return \md5(\uniqid($originName));
    }
}
