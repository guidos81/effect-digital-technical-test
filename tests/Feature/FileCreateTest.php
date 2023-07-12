<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test(): void
    {
        $file = base64_encode(file_get_contents(base_path('tests/Fixtures/test-file.pdf')));

        $response = $this->post('/api/files', [
            'title' => 'test',
            'file' => $file,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas(File::class, [
            'id' => 1,
            'title' => 'test',
            'contents' => json_encode(["effect","Technical Test - Backend","In this technical test, you will create a RESTful endpoint using PHP and a framework of your choice.","The objective is to develop an endpoint that accepts a PDF file and uses AWS's Textract API to","extract the text from a PDF.","The test assesses your ability to integrate with AWS services and demonstrate your proficiency in","PHP development.","Create a RESTful endpoint that accepts a Base64 Encoded PDF file, sends the input to AWS's","Textract API (https://aws.amazon.com/textract) and stores the extracted text into a database","table along with the time the request was made.","Use PHP with any framework of your choice","You can use any database system you're familiar with","Unit tests should be added where appropriate","Provide a sample PDF in the repository if you feel it would be beneficial","You may use any code repository of your choice (E.g Github, Gitlab, Bitbucket). We would like","to see regular commits to demonstrate your approach to the task.","A README file must be provided which includes information about the project and instructions","in how to use your endpoint.","Any queries or questions, please send through to christian@effectdigital.com.","Good luck!","01 Technical Test - Backend","effect"]),
        ]);
    }
}
