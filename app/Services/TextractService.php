<?php

namespace App\Services;

use Aws\Result;
use Aws\Textract\TextractClient;

class TextractService
{
    public function __construct(
        private TextractClient $client,
    ) {}

    /**
     * @param string $file
     * @return array
     */
    public function extract(string $file): array
    {
        try {
            $extractedData = $this->client->detectDocumentText([
                    'Document' => [
                    'Bytes' => $this->formatInput($file),
                ]
            ]);
        } catch (\Exception $e) {
            // Handle Textract exceptions
        }

        return $this->formatData($extractedData);
    }

    /**
     * @param string $file
     * @return string
     */
    private function formatInput(string $file): string
    {
        $array = explode(',', $file);
        return count($array) > 1 ? base64_decode($array[1]) : base64_decode($array[0]);
    }

    /**
     * @param Result $result
     * @return array
     */
    private function formatData(Result $result): array
    {
        return collect($result->get('Blocks'))->filter(function($value, $key) {
            return $value['BlockType'] === 'LINE';
        })->map(function($value, $key) {
            return $value['Text'];
        })->values()->all();
    }
}
