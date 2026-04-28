<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Убедимся, что в locations есть unique на section_number
        $hasUnique = collect(DB::select("SHOW INDEX FROM locations WHERE Key_name = 'locations_section_number_unique'"))->isNotEmpty();

        if (!$hasUnique) {
            Schema::table('locations', function (Blueprint $table) {
                $table->unique('section_number');
            });
        }

        // 2. Добавим колонку section_number в books, если её ещё нет
        if (!Schema::hasColumn('books', 'section_number')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('section_number')->nullable()->after('genre_id');
            });
        }

        // 3. Добавим foreign key, если его ещё нет
        $hasForeign = collect(DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'books'
              AND CONSTRAINT_NAME = 'books_section_number_foreign'
        "))->isNotEmpty();

        if (!$hasForeign) {
            Schema::table('books', function (Blueprint $table) {
                $table->foreign('section_number')
                      ->references('section_number')
                      ->on('locations')
                      ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['section_number']);
            $table->dropColumn('section_number');
        });
    }
};
