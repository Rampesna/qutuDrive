<?php

namespace App\Services\AwsS3;

use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;

class AwsS3Service
{
    /**
     * @var $client
     */
    private $client;

    /**
     * @var $bucket
     */
    private $bucket;

    public function __construct()
    {
        $this->client = new S3Client([
            'region' => '',
            'version' => '2006-03-01',
            'endpoint' => env('AWS_URL'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY')
            ],
            'use_path_style_endpoint' => true
        ]);
        $this->bucket = env('AWS_BUCKET');
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getBucket()
    {
        return $this->bucket;
    }
}
