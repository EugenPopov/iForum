<?php

namespace App\Service\FileSystem;

interface FileNameInterface
{
    public function getName(string $originName): string;
}