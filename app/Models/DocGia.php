<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocGia extends Model
{
    use HasFactory;
    protected $table = 'doc_gia';
    protected $fillable = [
        'ten_doc_gia',
        'nam_sinh',
        'cmnd',
        'dien_thoai',
        'dia_chi',
        'han_the',
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

    public function phieuMuon()
    {
        return $this->hasOne(Phieu::class, 'doc_gia_id', 'id');
    }
}

