# Mail API

A simple HTTP-based API to queue and send emails using JSON and Bearer token authentication.


## Base URL
```base url
https://veloxmail.xyz/api/v1.0/

```

## Authentication

All requests must include a Bearer token in the `Authorization` header.

### Headers
```headers
Authorization: Bearer YOUR_API_TOKEN
Content-Type: application/json
```

## Queue Email

Queue an email for delivery.

### Endpoint
```endpoint
POST /queueEmail
```


## Request Body

Send a JSON payload with the email details.

### Example

```json
{
    "sender_name": "Aware",
    "recipients":"reeaz@ramoly.info",
    "subject":"A Test Email",
    "content":"This is an html test message."
}
```
Parameters:

**sender_name**: optional

**content**: is the content of the email you are sending

Responses
Success
HTTP 200
```response success
{
  "status": true,
  "email_id": "1234"
}
```

Usage Examples:

PHP (cURL)
``` php example
$payload = [
    "to" => "john@example.com",
    "subject" => "Hello",
    "body" => "<p>This is a test email</p>"
];

$ch = curl_init("https://mailer.example.com/queueEmail");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer YOUR_API_TOKEN"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload),
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
```

cURL (CLI)
``` cURL
curl -X POST https://mailer.example.com/queueEmail \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "to": "john@example.com",
    "subject": "Hello",
    "body": "<p>This is a test email</p>"
  }'
```

