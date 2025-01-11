<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FakturModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faktur';

    protected $fillable = [
        'kode_faktur',
        'tanggal_faktur',
        'customer_id',
        'kode_customer',
        'ket_faktur',
        'total',
        'nominal_charge',
        'charge',
        'total_final',
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailFakturModel::class, 'faktur_id');
    }

    public function penjualan()
    {
        return $this->hasMany(PenjualanModel::class, 'faktur_id');
    }
}
