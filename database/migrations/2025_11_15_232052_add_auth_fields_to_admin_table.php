<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            // username + phone + verifikasi + lockout
            if (!Schema::hasColumn('admin', 'username')) {
                $table->string('username', 20)->unique()->nullable()->after('nama');
            }
            if (!Schema::hasColumn('admin', 'phone')) {
                $table->string('phone', 15)->nullable()->after('email');
            }
            if (!Schema::hasColumn('admin', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('phone');
            }
            if (!Schema::hasColumn('admin', 'failed_attempt')) {
                $table->unsignedTinyInteger('failed_attempt')->default(0)->after('is_verified');
            }
            if (!Schema::hasColumn('admin', 'lock_until')) {
                $table->timestamp('lock_until')->nullable()->after('failed_attempt');
            }
            if (!Schema::hasColumn('admin', 'created_at')) {
                $table->timestamps(); // will add created_at & updated_at if missing
            }
        });
    }

    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn(['username','phone','is_verified','failed_attempt','lock_until']);
            // don't drop timestamps if other code depends on them
        });
    }
};
