<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$email = 'test-email-' . rand(1, 100000) . '@example.com';
echo "Testing newsletter subscription with email: $email\n";

$request = Illuminate\Http\Request::create('/newsletter/subscribe', 'POST', [
    'email' => $email
]);
$request->headers->set('Accept', 'application/json');
$request->headers->set('X-Requested-With', 'XMLHttpRequest');

$app->instance('request', $request);

$controller = new App\Http\Controllers\NewsletterController();

// First subscription (new)
$response1 = $controller->subscribe($request);
echo "First response: " . $response1->getContent() . "\n";

// Second subscription (duplicate)
$response2 = $controller->subscribe($request);
echo "Second response: " . $response2->getContent() . "\n";

$subscriber = App\Models\Subscriber::where('email', $email)->first();
if ($subscriber) {
    echo "SUCCESS: Subscriber found in DB!\n";
} else {
    echo "FAIL: Subscriber not found in DB!\n";
}
