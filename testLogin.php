<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
if (!$user) {
    echo "User not found\n";
    exit;
}
echo "User found: " . $user->id . "\n";
Auth::login($user);

try {
    $request = \Illuminate\Http\Request::create('/dashboard', 'GET');
    $response = app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() >= 500) {
        if (method_exists($response, 'exception') && $response->exception) {
            echo "Exception: " . $response->exception->getMessage() . "\n";
            echo $response->exception->getTraceAsString();
        } else {
            echo $response->getContent();
        }
    }
} catch (\Exception $e) {
    echo "Caught Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
} catch (\Throwable $e) {
    echo "Caught Throwable: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
