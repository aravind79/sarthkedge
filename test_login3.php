<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\DB::setDefaultConnection('mysql');
$user = \App\Models\User::where('email', 'saisuppu1@gmail.com')->first();
if ($user) {
    echo "Found User (MAIN DB): ID " . $user->id . "\n";
    echo "Web Login matches user check? " . (\Hash::check('09392511176', $user->password) ? 'YES' : 'NO') . "\n";
    echo "Roles: " . implode(',', $user->getRoleNames()->toArray()) . "\n";
} else {
    echo "User saisuppu1@gmail.com NOT FOUND in MAIN DB.\n";
}
