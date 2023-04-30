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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->default('Anonimo');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->now();
            $table->string('password');
            $table->integer('total_games')->nullable();
            $table->integer('total_wins')->nullable();
            $table->integer('winning_percentage')->nullable();
            $table->string('admin_role')->default('usuario');  
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
