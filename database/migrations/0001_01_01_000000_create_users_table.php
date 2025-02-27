<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat struktur tabel users dan tabel terkait
     */
    public function up(): void
    {
        // Membuat tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();                     // Primary key auto-increment
            $table->string('nama');           // Kolom untuk nama lengkap
            $table->string('username');       // Kolom untuk username
            $table->string('email')->unique(); // Email harus unik
            $table->string('password');       // Kolom untuk password (terenkripsi)
            $table->timestamp('email_verified_at')->nullable(); // Untuk verifikasi email
            $table->rememberToken();          // Untuk fitur "remember me"
            $table->timestamps();             // created_at dan updated_at
        });

        // Tabel untuk reset password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel untuk menyimpan session
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Menghapus tabel-tabel jika rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
