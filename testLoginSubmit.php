<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = \Illuminate\Http\Request::create('/login', 'POST', [
    'email' => 'saisuppu1@gmail.com',
    'password' => 'Sch20252',
    'code' => '09392511176'
]);

$response = app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() >= 400) {
    if (method_exists($response, 'exception') && $response->exception) {
        echo "Exception: " . $response->exception->getMessage() . "\n";
        echo $response->exception->getTraceAsString();
    } else {
        echo $response->getContent();
    }
} else if ($response->getStatusCode() == 302) {
    echo "Redirect: " . $response->headers->get('Location') . "\n";
}
