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
        Schema::create('admisions', function (Blueprint $table) {
            $table->id();
            $table->string('archivo');
            $table->boolean('procesado');
            $table->unsignedBigInteger('idCreador');
            $table->foreign('idCreador')->references('id')->on('usuarios')->onCascade('delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admisions');
    }
};
