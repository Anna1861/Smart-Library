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
    Schema::table('books', function (Blueprint $table) {
        $table->string('section_number')->nullable()->after('genre_id');
        $table->foreign('section_number')
              ->references('section_number')
              ->on('locations')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropForeign(['section_number']);
        $table->dropColumn('section_number');
    });
}
};
