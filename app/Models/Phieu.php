<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Phieu extends Model
{
    use HasFactory;

    protected $table = 'phieu_muon';
    
    protected $fillable = [
        'id',
        'doc_gia_id',
        'sach_id',
        'ngay_muon',
        'ngay_tra',
        'qua_han',
        'phi',
    ];
    
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    // Thiết lập quan hệ với DocGia và Sach
    public function docGia()
    {
        return $this->belongsTo(DocGia::class, 'doc_gia_id', 'id');
    }

    public function sach()
    {
        return $this->belongsTo(Sach::class, 'sach_id');
    }
}
