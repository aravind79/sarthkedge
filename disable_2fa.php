<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Disable 2FA in main DB
\DB::setDefaultConnection('mysql');
$count = \DB::table('users')->where('email', 'saisuppu1@gmail.com')->update([
    'two_factor_enabled' => 0,
    'two_factor_secret' => null,
    'two_factor_expires_at' => null,
]);
echo "Main DB: Disabled 2FA for $count user(s)\n";

// Disable 2FA in school_db
\Illuminate\Support\Facades\Config::set('database.connections.school.database', 'school_db');
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

$count2 = \DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->update([
    'two_factor_enabled' => 0,
    'two_factor_secret' => null,
    'two_factor_expires_at' => null,
]);
echo "School DB: Disabled 2FA for $count2 user(s)\n";
echo "Done! You can now log in without 2FA code.\n";
