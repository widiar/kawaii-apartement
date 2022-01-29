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

    public function delete()
    {
        foreach ($this->image as $img) {
            Storage::disk('public')->delete('rooms/image/' . $img->image);
        }
        $this->image()->delete();
        parent::delete();
    }
}
