<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Schema;

echo "Users table exists: " . (Schema::hasTable('users') ? 'YES' : 'NO') . "\n";
if (Schema::hasTable('users')) {
    $users = User::all();
    echo "Total users: " . $users->count() . "\n";
    foreach ($users as $u) {
        echo "User: id={$u->id}, name={$u->name}, email={$u->email}\n";
    }
}
