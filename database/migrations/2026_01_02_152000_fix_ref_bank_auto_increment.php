<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix for "Integrity constraint violation: 1062 Duplicate entry '0'"
        // caused by missing AUTO_INCREMENT on id_bank.
        // Assuming BIGINT UNSIGNED which is standard for Laravel primary keys.
        DB::statement('ALTER TABLE ref_bank MODIFY id_bank BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE ref_bank MODIFY id_bank BIGINT UNSIGNED NOT NULL');
    }
};
