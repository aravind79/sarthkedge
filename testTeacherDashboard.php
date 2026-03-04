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
Illuminate\Support\Facades\Config::set('database.connections.school.database', $school->database_name);
Illuminate\Support\Facades\DB::purge('school');
Illuminate\Support\Facades\DB::connection('school')->reconnect();
Illuminate\Support\Facades\DB::setDefaultConnection('school');

$user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
if (!$user) {
    echo "User not found\n";
    exit;
}
echo "User ID: " . $user->id . "\n";

$fullDayName = \Carbon\Carbon::now()->format('l');
echo "Today: " . $fullDayName . "\n";

$timetables = \App\Models\Timetable::whereHas('subject_teacher', function ($q) use ($user) {
    $q->where('teacher_id', $user->id);
})->where('day', $fullDayName)->orderBy('start_time', 'ASC')->with('subject:id,name,type', 'class_section.class', 'class_section.section', 'class_section.medium')->get();

echo "Timetables Count: " . $timetables->count() . "\n";
foreach ($timetables as $t) {
    echo "Timetable ID: " . $t->id . "\n";
    echo "Subject: " . ($t->subject ? $t->subject->name : 'NULL!') . "\n";
    echo "ClassSection: " . ($t->class_section ? "Exists" : 'NULL!') . "\n";
}
