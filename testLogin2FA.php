<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Switch to school database
    Illuminate\Support\Facades\Config::set('database.connections.school.database', 'school_db');
    Illuminate\Support\Facades\DB::purge('school');
    Illuminate\Support\Facades\DB::connection('school')->reconnect();
    Illuminate\Support\Facades\DB::setDefaultConnection('school');

    $user = Illuminate\Support\Facades\DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->first();

    if (!$user) {
        throw new \Exception("User not found in school database");
    }

    echo "User found: " . $user->id . "\n";

    $loginController = app(\App\Http\Controllers\Auth\LoginController::class);

    $settings = app(\App\Services\CachingService::class)->getSystemSettings();

    $twoFACode = '123456';

    echo "Simulating 2FA email sending...\n";
    $status = $loginController->send2FAEmail($user, $user, $settings, $twoFACode);
    echo "Email sending status: " . $status . "\n";

} catch (\Throwable $e) {
    echo "Exception:\n" . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
