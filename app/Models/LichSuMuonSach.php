<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LichSuMuonSach extends Model
{
    use HasFactory;

    protected $table = 'lich_su_muon_sach';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'doc_gia_id',
        'ten_doc_gia',
        'nam_sinh',
        'cmnd',
        'dien_thoai',
        'dia_chi',
        'sach_id',
        'ten_sach',
        'ma_sach',
        'ngay_muon',
        'ngay_tra',
        'qua_han',
        'phi',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = $model->id ?? Str::uuid()->toString();
        });
    }
}
