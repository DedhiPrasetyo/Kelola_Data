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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penjualan');
            $table->date('tanggal_penjualan');
            $table->integer('jumlah_penjualan');
            $table->foreignId('customer_id')->constrained('customer', 'id')->cascadeOnUpdate('customer')->cascadeOnDelete();
            $table->foreignId('faktur_id')->constrained('faktur', 'id')->cascadeOnUpdate('faktur')->cascadeOnDelete();
            $table->boolean('status_penjualan')->default(0);
            $table->text('keterangan_penjualan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
