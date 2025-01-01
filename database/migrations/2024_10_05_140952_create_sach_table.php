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
        Schema::create('sach', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ma_sach');
            $table->string('ten_sach');
            $table->string('tac_gia');
            $table->string('nha_xuat_ban');
            $table->integer('nam_xuat_ban');
            $table->date('ngay_nhap');
            $table->integer('gia_tien');
            $table->integer('so_luong');
            $table->integer('da_muon')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sach');
    }
};
