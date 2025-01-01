<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLichSuMuonSachTable extends Migration
{
    public function up()
    {
        Schema::create('lich_su_muon_sach', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doc_gia_id');
            $table->string('ten_doc_gia');
            $table->date('nam_sinh');
            $table->string('cmnd');
            $table->string('dien_thoai');
            $table->string('dia_chi');
            $table->uuid('sach_id');
            $table->string('ten_sach');
            $table->string('ma_sach');
            $table->date('ngay_muon');
            $table->date('ngay_tra')->nullable();
            $table->integer('qua_han')->nullable();
            $table->integer('phi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lich_su_muon_sach');
    }
}
