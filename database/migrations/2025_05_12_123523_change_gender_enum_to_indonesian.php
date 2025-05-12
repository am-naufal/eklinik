<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL tidak mendukung perubahan langsung pada enum, jadi kita perlu menggunakan pendekatan alternatif

        // 1. Buat kolom sementara
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender_temp')->nullable()->after('gender');
        });

        // 2. Salin data dari kolom lama ke kolom sementara dengan konversi
        DB::statement("UPDATE users SET gender_temp = CASE
            WHEN gender = 'male' THEN 'laki-laki'
            WHEN gender = 'female' THEN 'perempuan'
            ELSE NULL END");

        // 3. Hapus kolom lama
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        // 4. Buat kolom baru dengan tipe enum yang diinginkan
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable()->after('age');
        });

        // 5. Salin data dari kolom sementara ke kolom baru
        DB::statement("UPDATE users SET gender = gender_temp");

        // 6. Hapus kolom sementara
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Lakukan proses sebaliknya

        // 1. Buat kolom sementara
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender_temp')->nullable()->after('gender');
        });

        // 2. Salin data dari kolom lama ke kolom sementara dengan konversi
        DB::statement("UPDATE users SET gender_temp = CASE
            WHEN gender = 'laki-laki' THEN 'male'
            WHEN gender = 'perempuan' THEN 'female'
            ELSE NULL END");

        // 3. Hapus kolom lama
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        // 4. Buat kolom baru dengan tipe enum yang lama
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->after('age');
        });

        // 5. Salin data dari kolom sementara ke kolom baru
        DB::statement("UPDATE users SET gender = gender_temp");

        // 6. Hapus kolom sementara
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender_temp');
        });
    }
};
