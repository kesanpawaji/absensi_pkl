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
        Schema::table('absensis', function (Blueprint $table) {
            if (!Schema::hasColumn('absensis', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('status');
            }
            if (!Schema::hasColumn('absensis', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('absensis', 'akurasi')) {
                $table->decimal('akurasi', 8, 2)->nullable()->after('longitude'); // tambahkan ini
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'akurasi']);
        });
    }
};
