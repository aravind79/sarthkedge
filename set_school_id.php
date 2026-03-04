<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get school
\DB::setDefaultConnection('mysql');
$school = \App\Models\School::where('code', 'Sch20252')->where('name', 'Sarthak Edge')->first();
if (!$school) {
    $school = \App\Models\School::where('code', 'SCH20252')->first();
}
echo "School: " . ($school ? $school->id . " - " . $school->name : "Not Found") . "\n";

if ($school) {
    // Now update user in school_db to have school_id set
    \Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
    \DB::purge('school');
    \DB::connection('school')->reconnect();
    \DB::setDefaultConnection('school');

    $count = \DB::connection('school')->table('users')->where('email', 'saisuppu1@gmail.com')->update([
        'school_id' => $school->id,
    ]);
    echo "Updated school_id for user: $count rows\n";
}
