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

$response = app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() >= 400 || $response->getStatusCode() == 500) {
    if (method_exists($response, 'exception') && $response->exception) {
        echo "Exception: " . mb_substr($response->exception->getMessage(), 0, 1000) . "\n";
        echo mb_substr($response->exception->getTraceAsString(), 0, 2000) . "\n";
    } else {
        echo mb_substr($response->getContent(), 0, 1000) . "\n";
    }
} else {
    echo "Response or Redirect: " . $response->headers->get('Location') . "\n";
}
