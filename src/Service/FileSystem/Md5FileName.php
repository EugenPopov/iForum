<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\FileSystem;

class Md5FileName implements FileNameInterface
{
    public function getName(string $originName): string
    {
        return \md5(\uniqid($originName));
    }
}
