# Effect Digital Technical Test

## Application Function

The app accepts a post request with a base64 encoded PDF file. The file will then be forwarded
to the Textract API, the response will be formatted and saved.

## Environment Variables

The following environment variables are required to be entered in the app `.env` file:

* `AWS_ACCESS_KEY_ID`
* `AWS_SECRET_ACCESS_KEY`

They will require an AWS account, with permissions active to use the AWS Textract service.

`AWS_DEFAULT_REGION` may also be set, but has a default value of `eu-west-2`.

# Request Format

The post request should contain the following fields in a JSON format:

* `title` - **Required** A title for the file being sent to be used as an identifier.
* `file` - **Required** A base64 encoded PDF file, may include the header prefix.

## Usage

The application can be run via Sail

```bash
sail up -d
sail artisan migrate
```

Once the app is up and running you can send a request to the API using the below while in the project directory:
```bash
(echo -n '{"title": "test file", "file": "'; base64 tests/Fixtures/test-file.pdf; echo '"}') | curl -H "Content-Type: application/json" -d @-  http://localhost/api/files
```

This will send the base64 encoded version of the technical exercise PDF to the API, which will be forwarded to the AWS Textract service.
The result will be filtered and the text lines stored in a JSON field in the database.

You can view the created resource in the response, or with the following command:

```bash
curl -H "Content-Type: application/json" http://localhost/api/files/1
```

# Improvements

## Tests

Given more time I would expand on the current tests with further test cases, in particular the integration tests.
I would include error responses from the Textract service as fixtures, and provide them through the mocked
handler.

## Exception Handling

Exception handling could be expanded around the Textract request, currently it just swallows the exception.
I would probably format a message derived from the exception class and message, then throw my own custom
exception, which can be handled by the application to return a formatted error message to the user.

## Saved Data Format

I could change the way the data is formatted to be saved, given further requirements from the customer. I
thought saving the line content would give a more readable response.

## API Endpoints

I included the show GET API endpoint to further access the data once it has been stored. 
I decided to exclude the update endpoint as it seemed redundant. 
