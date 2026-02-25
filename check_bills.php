<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SubscriptionBill;
use Carbon\Carbon;

$schoolID = 2;
$today_date = Carbon::now()->format('Y-m-d');

$subscriptionBill = SubscriptionBill::with([
    'subscription' => function ($q) {
        $q->where('package_type', 1);
    }
])->where('school_id', $schoolID)->whereHas('transaction', function ($q) {
    $q->whereNot('payment_status', "succeed");
})->where('due_date', '<', $today_date)->first();

if ($subscriptionBill) {
    echo "Unpaid bill found! ID: {$subscriptionBill->id}, Due Date: {$subscriptionBill->due_date}\n";
} else {
    echo "No unpaid bills found.\n";
}

// Also check for bills without transactions if that's possible
$pendingBills = SubscriptionBill::where('school_id', $schoolID)
    ->where('due_date', '<', $today_date)
    ->whereDoesntHave('transaction')
    ->get();

foreach ($pendingBills as $bill) {
    echo "Pending bill without transaction: ID: {$bill->id}, Due: {$bill->due_date}\n";
}
