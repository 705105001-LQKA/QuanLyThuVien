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
        Schema::create('phieu_muon', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doc_gia_id'); // Liên kết đến độc giả
            $table->uuid('sach_id'); // Liên kết đến sách
            $table->date('ngay_muon');
            $table->date('ngay_tra')->nullable(); // Có thể để trống nếu chưa trả
            $table->integer('qua_han')->nullable(); // Có thể để trống nếu chưa quá hạn
            $table->integer('phi')->nullable(); // Có thể để trống nếu chưa quá hạn
            $table->timestamps();

            // Thiết lập khóa ngoại
            $table->foreign('doc_gia_id')->references('id')->on('doc_gia')->onDelete('cascade');
            $table->foreign('sach_id')->references('id')->on('sach')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_muon');
    }
};
