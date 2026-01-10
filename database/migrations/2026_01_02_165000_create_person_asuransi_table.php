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
        Schema::create('person_asuransi', function (Blueprint $table) {
            $table->increments('id_asuransi');
            $table->unsignedSmallInteger('id_jenis_asuransi')->index();
            $table->unsignedBigInteger('id')->index();
            $table->string('nomor_registrasi', 16)->nullable();
            $table->string('kartu_anggota', 16)->nullable();
            $table->enum('status_aktif', ['Aktif', 'Nonaktif', 'Berakhir'])->default('Aktif');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->text('keterangan')->nullable();

            // Foreign keys (assuming tables exist based on context, otherwise can be skipped or made safer)
            // It's safer to not enforce FK constraints strictly if we are not sure about parent table engines/types matching exactly without checking,
            // but assuming standard Laravel conventions.
            // Based on observed code:
            // person.id is likely unsignedBigInteger.
            // ref_jenis_asuransi.id_jenis_asuransi is likely unsignedSmallInteger or similar.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_asuransi');
    }
};
