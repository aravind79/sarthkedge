<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// remove VerifyCsrfToken middleware
$app->instance(\App\Http\Middleware\VerifyCsrfToken::class, new class {
    public function handle($request, $next)
    {
        return $next($request);
    }
});

$request = \Illuminate\Http\Request::create('/login', 'POST', [
    'email' => 'saisuppu1@gmail.com',
    'password' => 'Sch20252',
    'code' => '09392511176'
]);

try {
    $response = app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
    if (isset($response->exception) && $response->exception) {
        echo $response->exception->getMessage() . "\n" . $response->exception->getTraceAsString();
    } else {
        echo "Status: " . $response->getStatusCode() . "\n";
    }
} catch (\Exception $e) {
    echo $e->getMessage() . "\n" . $e->getTraceAsString();
}
