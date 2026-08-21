<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCreate extends Model
{
    protected $primaryKey = 'id';
    protected $table = "room_creates";
    protected $fillable = ['room_name', 'members', 'created_by', 'room_type', 'file'];

    protected $casts = ['array' => 'members'];

    /**
     * Get exploded files array using PHP explode()
     */
    public function getFilesListAttribute(): array
    {
        if (empty($this->file)) {
            return [];
        }
        return array_values(array_filter(explode(',', $this->file)));
    }
}
