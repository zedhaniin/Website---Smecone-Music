<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 25)->nullable()->after('email');
            $table->string('class_name', 50)->nullable()->after('phone');
            $table->string('instrument_division', 100)->nullable()->after('class_name');
            $table->string('management_division', 100)->nullable()->after('instrument_division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'class_name', 'instrument_division', 'management_division']);
        });
    }
};
