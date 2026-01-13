<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Standardize data from 'free' to 'basic'
        // We use raw SQL to ensure the enum change works on MySQL
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN plan ENUM('basic', 'pro', 'free') DEFAULT 'basic'");
        DB::table('subscriptions')->where('plan', 'free')->update(['plan' => 'basic']);
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN plan ENUM('basic', 'pro') DEFAULT 'basic'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN plan ENUM('basic', 'pro', 'free') DEFAULT 'free'");
        DB::table('subscriptions')->where('plan', 'basic')->update(['plan' => 'free']);
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN plan ENUM('free', 'pro') DEFAULT 'free'");
    }
};
