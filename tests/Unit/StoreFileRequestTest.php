<?php

namespace Tests\Unit;

use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreFileRequestTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function validDataProvider(): array
    {
        return [
            'normal base64' => [
                'title' => 'test file',
                'file' => 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gRG9uZWMgdGluY2lkdW50IGxlbyBuZXF1ZSwgdml0YWUgZmF1Y2lidXMgZXJhdCBldWlzbW9kIHF1aXMuIE9yY2kgdmFyaXVzIG5hdG9xdWUgcGVuYXRpYnVzIGV0IG1hZ25pcyBkaXMgcGFydHVyaWVudCBtb250ZXMsIG5hc2NldHVyIHJpZGljdWx1cyBtdXMuIFBoYXNlbGx1cyBldCBhbGlxdWV0IGRvbG9yLiBDcmFzIGlhY3VsaXMgaW1wZXJkaWV0IHNhZ2l0dGlzLiBVdCBldSBhbGlxdWFtIGxlby4gTnVuYyBsdWN0dXMgbWFzc2EgZXUgYmxhbmRpdCBjb25zZWN0ZXR1ci4gUXVpc3F1ZSBtYXhpbXVzIHBlbGxlbnRlc3F1ZSBsZWN0dXMsIG5vbiBtYWxlc3VhZGEgc2VtIGNvbnNlY3RldHVyIGV1Lg==',
            ],
            'with base64 prefix' => [
                'title' => 'test file foo',
                'file' => 'data:application/pdf;base64,TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gRG9uZWMgdGluY2lkdW50IGxlbyBuZXF1ZSwgdml0YWUgZmF1Y2lidXMgZXJhdCBldWlzbW9kIHF1aXMuIE9yY2kgdmFyaXVzIG5hdG9xdWUgcGVuYXRpYnVzIGV0IG1hZ25pcyBkaXMgcGFydHVyaWVudCBtb250ZXMsIG5hc2NldHVyIHJpZGljdWx1cyBtdXMuIFBoYXNlbGx1cyBldCBhbGlxdWV0IGRvbG9yLiBDcmFzIGlhY3VsaXMgaW1wZXJkaWV0IHNhZ2l0dGlzLiBVdCBldSBhbGlxdWFtIGxlby4gTnVuYyBsdWN0dXMgbWFzc2EgZXUgYmxhbmRpdCBjb25zZWN0ZXR1ci4gUXVpc3F1ZSBtYXhpbXVzIHBlbGxlbnRlc3F1ZSBsZWN0dXMsIG5vbiBtYWxlc3VhZGEgc2VtIGNvbnNlY3RldHVyIGV1Lg==',
            ]
        ];
    }

    /**
     * @dataProvider validDataProvider
     * @param string $title
     * @param string $file
     * @return void
     */
    public function testValid(string $title, string $file): void
    {
        $formRequest = new StoreFileRequest();
        $validator = Validator::make([
            'title' => $title,
            'file' => $file,
        ], $formRequest->rules());

        $this->assertFalse($validator->fails());
    }

    /**
     * @return array[]
     */
    public static function invalidDataProvider(): array
    {
        return [
            'title required' => [
                'data' => ['file' => 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gRG9uZWMgdGluY2lkdW50IGxlbyBuZXF1ZSwgdml0YWUgZmF1Y2lidXMgZXJhdCBldWlzbW9kIHF1aXMuIE9yY2kgdmFyaXVzIG5hdG9xdWUgcGVuYXRpYnVzIGV0IG1hZ25pcyBkaXMgcGFydHVyaWVudCBtb250ZXMsIG5hc2NldHVyIHJpZGljdWx1cyBtdXMuIFBoYXNlbGx1cyBldCBhbGlxdWV0IGRvbG9yLiBDcmFzIGlhY3VsaXMgaW1wZXJkaWV0IHNhZ2l0dGlzLiBVdCBldSBhbGlxdWFtIGxlby4gTnVuYyBsdWN0dXMgbWFzc2EgZXUgYmxhbmRpdCBjb25zZWN0ZXR1ci4gUXVpc3F1ZSBtYXhpbXVzIHBlbGxlbnRlc3F1ZSBsZWN0dXMsIG5vbiBtYWxlc3VhZGEgc2VtIGNvbnNlY3RldHVyIGV1Lg=='],
                'error' => 'title',
            ],
            'file required' => [
                'data' => ['title' => 'foo bar'],
                'error' => 'file',
            ],
            'title string' => [
                'data' => [
                    'title' => ['foo' => 'bar'],
                    'file' => 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gRG9uZWMgdGluY2lkdW50IGxlbyBuZXF1ZSwgdml0YWUgZmF1Y2lidXMgZXJhdCBldWlzbW9kIHF1aXMuIE9yY2kgdmFyaXVzIG5hdG9xdWUgcGVuYXRpYnVzIGV0IG1hZ25pcyBkaXMgcGFydHVyaWVudCBtb250ZXMsIG5hc2NldHVyIHJpZGljdWx1cyBtdXMuIFBoYXNlbGx1cyBldCBhbGlxdWV0IGRvbG9yLiBDcmFzIGlhY3VsaXMgaW1wZXJkaWV0IHNhZ2l0dGlzLiBVdCBldSBhbGlxdWFtIGxlby4gTnVuYyBsdWN0dXMgbWFzc2EgZXUgYmxhbmRpdCBjb25zZWN0ZXR1ci4gUXVpc3F1ZSBtYXhpbXVzIHBlbGxlbnRlc3F1ZSBsZWN0dXMsIG5vbiBtYWxlc3VhZGEgc2VtIGNvbnNlY3RldHVyIGV1Lg=='
                ],
                'error' => 'title',
            ],
            'file string' => [
                'data' => [
                    'title' => 'foo bar',
                    'file' => ['file' => 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gRG9uZWMgdGluY2lkdW50IGxlbyBuZXF1ZSwgdml0YWUgZmF1Y2lidXMgZXJhdCBldWlzbW9kIHF1aXMuIE9yY2kgdmFyaXVzIG5hdG9xdWUgcGVuYXRpYnVzIGV0IG1hZ25pcyBkaXMgcGFydHVyaWVudCBtb250ZXMsIG5hc2NldHVyIHJpZGljdWx1cyBtdXMuIFBoYXNlbGx1cyBldCBhbGlxdWV0IGRvbG9yLiBDcmFzIGlhY3VsaXMgaW1wZXJkaWV0IHNhZ2l0dGlzLiBVdCBldSBhbGlxdWFtIGxlby4gTnVuYyBsdWN0dXMgbWFzc2EgZXUgYmxhbmRpdCBjb25zZWN0ZXR1ci4gUXVpc3F1ZSBtYXhpbXVzIHBlbGxlbnRlc3F1ZSBsZWN0dXMsIG5vbiBtYWxlc3VhZGEgc2VtIGNvbnNlY3RldHVyIGV1Lg==']
                ],
                'error' => 'file',
            ],
            'file valid base64' => [
                'data' => [
                    'title' => 'foo bar',
                    'file' => 'TG9yZW0gaXBzdW0gZG%sb3Igc2l0IG/tZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gRG9uZWMgdGluY2lkdW50IGxlbyBuZXF1ZSwgdml0YWUgZmF1Y2lidXMgZXJhdCBldWlzbW9kIHF1aXMuIE9yY2kgdmFyaXVzIG5hdG9xdWUgcGVuYXRpYnVzIGV0IG1hZ25pcyBkaXMgcGFydHVyaWVudCBtb250ZXMsIG5hc2NldHVyIHJpZGljdWx1cyBtdXMuIFBoYXNlbGx1cyBldCBhbGlxdWV0IGRvbG9yLiBDcmFzIGlhY3VsaXMgaW1wZXJkaWV0IHNhZ2l0dGlzLiBVdCBldSBhbGlxdWFtIGxlby4gTnVuYyBsdWN0dXMgbWFzc2EgZXUgYmxhbmRpdCBjb25zZWN0ZXR1ci4gUXVpc3F1ZSBtYXhpbXVzIHBlbGxlbnRlc3F1ZSBsZWN0dXMsIG5vbiBtYWxlc3VhZGEgc2VtIGNvbnNlY3RldHVyIGV1Lg=='
                ],
                'error' => 'file',
            ],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     * @param array $data
     * @param string $error
     * @return void
     */
    public function testInvalid(array $data, string $error): void
    {
        $formRequest = new StoreFileRequest();
        $validator = Validator::make($data, $formRequest->rules());

        $this->assertTrue($validator->fails());
        $this->assertContains($error, $validator->errors()->keys());
    }
}
