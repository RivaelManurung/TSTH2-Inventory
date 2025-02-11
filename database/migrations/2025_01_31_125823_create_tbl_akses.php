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
        Schema::create('tbl_akses', function (Blueprint $table) {
            $table->increments('akses_id');
            $table->string('menu_id')->nullable();
            $table->string('submenu_id')->nullable();
            $table->string('othermenu_id')->nullable();
            $table->unsignedBigInteger('role_id');  // Ganti menjadi unsignedBigInteger
            $table->string('akses_type');
            $table->timestamps();
        
            // Menambahkan foreign key constraint untuk role_id yang mengarah ke tabel roles
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_akses');
    }
};
