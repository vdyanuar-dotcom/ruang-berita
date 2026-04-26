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
        Schema::table('news', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada, untuk menghindari error dobel
            if (!Schema::hasColumn('news', 'view_count')) {
                $table->integer('view_count')->default(0)->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'view_count')) {
                $table->dropColumn('view_count');
            }
        });
    }
};
