<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update main DB
\Illuminate\Support\Facades\DB::setDefaultConnection('mysql');
$count = \Illuminate\Support\Facades\DB::table('users')->where('email', 'saisuppu1@gmail.com')->update([
    'email_verified_at' => now()
]);
echo "Updated $count rows in main DB\n";

// Update school_db
\Illuminate\Support\Facades\Config::set('database.connections.school.database', 'school_db');
\Illuminate\Support\Facades\DB::purge('school');
\Illuminate\Support\Facades\DB::connection('school')->reconnect();
\Illuminate\Support\Facades\DB::setDefaultConnection('school');

$count2 = \Illuminate\Support\Facades\DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->update([
    'email_verified_at' => now()
]);

echo "Updated $count2 rows in school DB\n";
