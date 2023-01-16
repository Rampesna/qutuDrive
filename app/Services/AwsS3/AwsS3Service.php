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
            'region' => 'us-east-1',
            'version' => '2006-03-01',
            'endpoint' => 'http://ays.s3.ayssoft.com/',
            'credentials' => [
                'key' => 'ots',
                'secret' => '357159123'
            ],
            'use_path_style_endpoint' => true
        ]);
        $this->bucket = 'otsweb';
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
