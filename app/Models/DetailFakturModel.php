<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailFakturModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'detail';

    public function barang()
    {
        return $this->BelongsTo(Barang::class);
    }

    public function faktur()
    {
        return $this->belongsTo(FakturModel::class, 'id');
    }
}
