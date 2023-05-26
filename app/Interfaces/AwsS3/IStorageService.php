<?php

namespace App\Interfaces\AwsS3;

use App\Core\ServiceResponse;

interface IStorageService
{
    /**
     * @param mixed $file
     * @param string $filePath
     * @param string|null $uuid
     */
    public function store(
        mixed  $file,
        string $filePath,
        string $uuid = null
    ): ServiceResponse;

    /**
     * @param string $key
     */
    public function getByKey(
        string $key
    ): ServiceResponse;

    /**
     * @param string $key
     */
    public function downloadSingleFile(
        string $key
    ): ServiceResponse;
}
