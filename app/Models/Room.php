<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function image()
    {
        return $this->hasMany(RoomImage::class, 'room_id', 'id');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'room_id');
    }

    public function delete()
    {
        foreach ($this->image as $img) {
            Storage::disk('public')->delete('rooms/image/' . $img->image);
        }
        $this->image()->delete();
        parent::delete();
    }

    public function checkSisa($checkin)
    {
        $cek = $this->reservasi()->where('is_approve', 1)->where('checkout', '>=', $checkin)->get();
        $jumlah = 0;
        foreach($cek as $c){
            $jumlah += 1;
        }
        return $this->jumlah - $jumlah;
    }
}
