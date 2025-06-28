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
        Schema::table('membership_renewals', function (Blueprint $table) {
            $table->string('renewed_by')->nullable();
            // $table->unsignedBigInteger('renewed_by')->nullable(); // If you want user_id instead
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_renewals', function (Blueprint $table) {
            //
        });
    }
};
