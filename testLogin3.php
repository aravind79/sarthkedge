<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\Config::set('database.connections.school.database', 'school_db');
    Illuminate\Support\Facades\DB::purge('school');
    Illuminate\Support\Facades\DB::connection('school')->reconnect();
    Illuminate\Support\Facades\DB::setDefaultConnection('school');

    $user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
    echo "User " . ($user ? "found" : "not found") . "\n";

    $loginController = app(\App\Http\Controllers\Auth\LoginController::class);
    $settings = app(\App\Services\CachingService::class)->getSystemSettings();
    $twoFACode = '123456';

    echo "Simulating 2FA email sending...\n";
    $status = $loginController->send2FAEmail($user, $user, $settings, $twoFACode);
    echo "Email sending status: " . $status . "\n";
} catch (\Throwable $e) {
    echo "Caught: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
