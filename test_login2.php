<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schools = \App\Models\School::where('code', 'Sch20252')->get();
foreach ($schools as $s) {
    echo "Code: " . $s->code . " -> DB: " . $s->database_name . "\n";
    Config::set('database.connections.school.database', $s->database_name);
    \DB::purge('school');
    \DB::connection('school')->reconnect();
    \DB::setDefaultConnection('school');
    $user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
    if ($user) {
        echo "  Found User: ID " . $user->id . "\n";
        echo "  Web Login matches user check? " . (\Hash::check('09392511176', $user->password) ? 'YES' : 'NO') . "\n";
    } else {
        echo "  User saisuppu1@gmail.com NOT FOUND in this DB.\n";
    }
}
