<?php

namespace App\Services;

use Aws\Result;
use Aws\Textract\TextractClient;

class TextractService
{
    public function __construct(
        private TextractClient $client,
    ) {}

    public function extract(string $file): array
    {
        $extractedData = $this->client->detectDocumentText([
            'Document' => [
                'Bytes' => $file,
            ]
        ]);

        return $this->formatData($extractedData);
    }

    private function formatData(Result $result): array
    {
        return collect($result->get('Blocks'))->filter(function($value, $key) {
            return $value['BlockType'] === 'LINE';
        })->map(function($value, $key) {
            return $value['Text'];
        })->values()->all();
    }
}
