<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schools = \App\Models\School::get();
foreach ($schools as $s) {
    if (!$s->database_name)
        continue;
    try {
        Config::set('database.connections.school.database', $s->database_name);
        \DB::purge('school');
        \DB::connection('school')->reconnect();

        $u = \DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->first();
        if ($u) {
            echo "FOUND IN TENANT DB: " . $s->database_name . " (School Code: " . $s->code . ")\n";
        }
    } catch (\Exception $e) {
        // ignoring
    }
}
