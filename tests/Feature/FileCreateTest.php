<?php

namespace Tests\Feature;

use App\Models\File;
use Aws\CommandInterface;
use Aws\Result;
use Aws\Textract\TextractClient;
use GuzzleHttp\Promise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

class FileCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array[]
     */
    public static function prefixDataProvider(): array
    {
        return [
            'no prefix' => [''],
            'with prefix' => ['data:application/pdf;base64,']
        ];
    }

    /**
     * @dataProvider prefixDataProvider
     * @param string $prefix
     * @return void
     */
    public function test(string $prefix): void
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

        $client = app(TextractClient::class);
        $client->getHandlerList()->setHandler($mockHandler);

        $this->app->instance(TextractClient::class, $client);

        $file = $prefix . base64_encode(file_get_contents(base_path('tests/Fixtures/test-file.pdf')));

        $response = $this->post('/api/files', [
            'title' => 'test',
            'file' => $file,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas(File::class, [
            'id' => 1,
            'title' => 'test',
            'contents' => json_encode(['line text', 'next line']),
        ]);
    }
}
