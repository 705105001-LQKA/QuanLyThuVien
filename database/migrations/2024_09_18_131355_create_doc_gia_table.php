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
        Schema::create('doc_gia', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid(column: 'id_phieu_muon');
            $table->string('ten_doc_gia');
            $table->date('nam_sinh');
            $table->string('cmnd');
            $table->string('dien_thoai');
            $table->string('dia_chi');
            $table->date('han_the');
            $table->timestamps();

            $table->foreign('id_phieu_muon')->references('id')->on('phieu_muon')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_gia');
    }
};
