<?php

namespace App\Services\AwsS3;

use App\Interfaces\AwsS3\IStorageService;
use App\Core\ServiceResponse;

class StorageService extends AwsS3Service implements IStorageService
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
    ): ServiceResponse
    {
        $name = $uuid ? $uuid . '.' . $file->getClientOriginalExtension() : $file->getFilename();
        $response = $this->getClient()->putObject([
            'Bucket' => $this->getBucket(),
            'Key' => $filePath . $name,
            'Body' => fopen($file->getPath() . '/' . $file->getFilename(), 'r'),
            'ACL' => 'public-read'
        ]);

        return new ServiceResponse(
            true,
            'File uploaded',
            200,
            $filePath . $name
        );
    }

    /**
     * @param mixed $filePath
     * @param string $filePath
     */
    public function storeFromAsset(
        mixed  $filePath,
        string $fullPath
    ): ServiceResponse
    {
        $response = $this->getClient()->putObject([
            'Bucket' => $this->getBucket(),
            'Key' => $fullPath,
            'Body' => fopen($filePath, 'r'),
            'ACL' => 'public-read'
        ]);

        return new ServiceResponse(
            true,
            'File uploaded',
            200,
            $fullPath
        );
    }

    /**
     * @param string $key
     */
    public function getByKey(
        string $key
    ): ServiceResponse
    {
        $response = $this->getClient()->getObject([
            'Bucket' => $this->getBucket(),
            'Key' => $key
        ]);

        return new ServiceResponse(
            true,
            'File',
            200,
            $response
        );
    }

    /**
     * @param string $key
     */
    public function downloadSingleFile(
        string $key
    ): ServiceResponse
    {
//        $response = $this->getClient()->getObjectUrl($this->getBucket(), $key);
//        return new ServiceResponse(
//            true,
//            'File',
//            200,
//            $response . "\n"
//        );

        $secret_plans_cmd = $this->getClient()->getCommand('GetObject', ['Bucket' => $this->getBucket(), 'Key' => $key]);
        $request = $this->getClient()->createPresignedRequest($secret_plans_cmd, '+1 hour');

        return new ServiceResponse(
            true,
            'File',
            200,
            $request->getUri() . "\n"
        );
    }
}
