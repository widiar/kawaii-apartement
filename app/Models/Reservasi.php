<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function promo()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
    }
}
