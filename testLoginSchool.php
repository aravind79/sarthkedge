<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$school = \App\Models\School::on('mysql')->where('code', '09392511176')->first();
if (!$school) {
    echo "School not found\n";
    exit;
}
echo "School DB: " . $school->database_name . "\n";
Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
Illuminate\Support\Facades\DB::purge('school');
Illuminate\Support\Facades\DB::connection('school')->reconnect();

try {
    $user = Illuminate\Support\Facades\DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
    echo "User found. ID: " . $user->id . "\n";
    echo "2FA disabled? " . (isset($user->two_factor_enabled) ? $user->two_factor_enabled : 'NO COLUMN') . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
