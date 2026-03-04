<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\DB::setDefaultConnection('mysql');
$user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
if (!$user) {
    echo "User not found in main DB.\n";
    exit;
}
$userData = $user->toArray();
unset($userData['id']);
unset($userData['school_id']);
unset($userData['full_name']);
unset($userData['school_names']);
unset($userData['role']);
unset($userData['permissions']);
unset($userData['media']);
unset($userData['settings']);

$school = \App\Models\School::where('code', 'Sch20252')->first();
if (!$school)
    die("School not found");

Config::set('database.connections.school.database', $school->database_name);
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

$tenantUser = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();

if (!$tenantUser) {
    echo "Inserting user into tenant DB...\n";
    $tenantUserId = \DB::connection('school')->table('users')->insertGetId([
        'first_name' => $userData['first_name'],
        'last_name' => $userData['last_name'],
        'mobile' => $userData['mobile'],
        'email' => $userData['email'],
        'password' => $user->password,
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Assign role School Admin
    $role = \DB::connection('school')->table('roles')->where('name', 'School Admin')->first();
    if ($role) {
        \DB::connection('school')->table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => 'App\Models\User',
            'model_id' => $tenantUserId
        ]);
        echo "Assigned School Admin inside tenant DB.\n";
    }
} else {
    echo "User already exists in tenant DB.\n";
    \DB::connection('school')->table('users')->where('id', $tenantUser->id)->update([
        'password' => $user->password,
        'mobile' => $userData['mobile']
    ]);
}
echo "DONE! User can log in now.";
