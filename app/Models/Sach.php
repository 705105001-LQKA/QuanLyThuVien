<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sach extends Model
{
    use HasFactory;

    protected $table = 'sach';

    protected $fillable = [
        'ma_sach',
        'ten_sach',
        'tac_gia',
        'nha_xuat_ban',
        'nam_xuat_ban',
        'ngay_nhap',
        'gia_tien',
        'so_luong',
        'da_muon',
    ];

    protected $keyType = 'string'; // Để lưu UUID dưới dạng chuỗi
    public $incrementing = false; // Tắt tự động tăng

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }
}
