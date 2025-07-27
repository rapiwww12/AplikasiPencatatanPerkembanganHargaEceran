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
        Schema::create('hargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->onDelete('cascade');
            $table->decimal('harga', 10, 2);
            $table->string('pasar');
            $table->date('tanggal');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->unique(['bahan_baku_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hargas');
    }
};
