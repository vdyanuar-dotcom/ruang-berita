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
            // Mengubah dari categoty (typo) ke category (benar)
            $table->renameColumn('news_categoty_id', 'news_category_id');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('news_category_id', 'news_categoty_id');
        });
    }
};
