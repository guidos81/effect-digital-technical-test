<?php

namespace Tests\Unit;

use App\Services\TextractService;
use Aws\CommandInterface;
use Aws\Result;
use Aws\Textract\TextractClient;
use GuzzleHttp\Promise;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class TextractServiceTest extends TestCase
{
    /**
     * Mock the result from the AWS API using a fake handler to return an expected result
     * Check the format method returns a correctly formatted result
     */
    public function test(): void
    {
        $mockHandler = function (CommandInterface $cmd, RequestInterface $request) {
            $result = new Result([
                'Blocks' => [
                    [
                        'BlockType' => 'WORD',
                        'Text' => 'word',
                    ],
                    [
                        'BlockType' => 'LINE',
                        'Text' => 'line text',
                    ],
                    [
                        'BlockType' => 'PAGE',
                    ],
                    [
                        'BlockType' => 'LINE',
                        'Text' => 'next line',
                    ],
                ],
            ]);
            return Promise\promise_for($result);
        };

        $client = new TextractClient([
            'version' => 'latest',
            'region' => 'region',
            'credentials' => [
                'key' => 'aws-key',
                'secret' => 'aws-secret',
            ],
            'handler' => $mockHandler,
        ]);

        $service = new TextractService($client);
        $result = $service->extract('testfile');

        $this->assertEquals([
            'line text',
            'next line',
        ], $result);
    }
}
