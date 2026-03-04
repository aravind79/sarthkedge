<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get user from main db
\DB::setDefaultConnection('mysql');
$user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
if (!$user) {
    echo "User not found in main DB.\n";
    exit;
}
$userData = $user->toArray();
unset($userData['id']); // don't force ID
unset($userData['school_id']); // tenant db users might not need school_id or they do?

$school = \App\Models\School::where('code', 'Sch20252')->first();
if (!$school)
    die("School not found");

Config::set('database.connections.school.database', $school->database_name);
\DB::purge('school');
\DB::connection('school')->reconnect();
\DB::setDefaultConnection('school');

$tenantUser = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();

if (!$tenantUser) {
    $tenantUser = new \App\Models\User();
    foreach ($userData as $k => $v) {
        $tenantUser->$k = $v;
    }
    // Set typical tenant admin role (e.g., School Admin)
    // usually ID 2 or maybe role-specific. Let's look up the role in tenant.
    $tenantUser->save();
    echo "Inserted user into tenant DB.\n";
} else {
    echo "User already exists in tenant DB.\n";
    // Ensure password matches just in case
    $tenantUser->password = $user->password;
    $tenantUser->save();
}

// Check role
$role = \Spatie\Permission\Models\Role::where('name', 'School Admin')->first();
if ($role && !$tenantUser->hasRole('School Admin')) {
    $tenantUser->assignRole($role);
    echo "Assigned School Admin role to user.\n";
} else {
    echo "Role School Admin not found or already assigned. Role ID manually setting...\n";
    $tenantUser->role_id = 99; // some admin role?
}
