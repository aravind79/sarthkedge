<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Config::set('database.connections.school.database', 'school_db');
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

$users = \App\Models\User::get();
echo "Users in school_db: " . count($users) . "\n";
foreach ($users as $u) {
    echo $u->id . " - " . $u->email . " - " . implode(',', $u->getRoleNames()->toArray()) . "\n";
}
