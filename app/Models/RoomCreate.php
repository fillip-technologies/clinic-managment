<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCreate extends Model
{
    protected $primaryKey = 'id';
    protected $table = "room_creates";
    protected $fillable = ['room_name','members','created_by','room_type'];

    protected $casts = ['array'=>'members'];
}
