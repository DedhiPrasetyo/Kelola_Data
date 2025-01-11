<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenjualanModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_penjualan',
        'tanggal_penjualan',
        'jumlah_penjualan',
        'customer_id',
        'faktur_id',
        'keterangan_penjualan',
        'status_penjualan',
    ];

    protected $guarded = [];
    protected $table = 'penjualan';

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }

    public function faktur()
    {
        return $this->belongsTo(FakturModel::class, 'id');
    }
}
