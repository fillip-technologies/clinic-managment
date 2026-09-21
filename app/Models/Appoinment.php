<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    protected $table = 'appoinments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'patient_name',
        'age',
        'father_name',
        'phone',
        'mail',
        'address',
        'patient_type',
        'appointment_type',
        'appointment_scheduled_date',
        'slot_number',
        'appointment_done',
        'message',
    ];

    protected $casts = [
        'appointment_scheduled_date' => 'date',
        'appointment_done' => 'boolean',
    ];

    protected $attributes = [
        'appointment_done' => false,
    ];

    /**
     * Calculate the next available slot for a given date in format "Batch/Slot" (1/1 to 1/15, then 2/1, etc.)
     */
    public static function calculateNextSlot($date, $excludeId = null): string
    {
        $taken = static::getTakenSlots($date, $excludeId);

        $takenIndices = [];
        foreach ($taken as $slot) {
            if (preg_match('/^(\d+)\/([1-9]|1[0-5])$/', trim((string)$slot), $m)) {
                $batch = intval($m[1]);
                $pos = intval($m[2]);
                $takenIndices[] = ($batch - 1) * 15 + $pos;
            }
        }

        $takenMap = array_flip($takenIndices);
        $seq = 1;
        while (isset($takenMap[$seq])) {
            $seq++;
        }

        $batch = intdiv($seq - 1, 15) + 1;
        $pos = (($seq - 1) % 15) + 1;

        return "{$batch}/{$pos}";
    }

    /**
     * Get all taken slot numbers on a specific date
     */
    public static function getTakenSlots($date, $excludeId = null): array
    {
        if (!$date) {
            return [];
        }

        $query = static::whereDate('appointment_scheduled_date', $date)
            ->whereNotNull('slot_number')
            ->where('slot_number', '!=', '');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->pluck('slot_number')->map(fn($s) => trim((string)$s))->values()->toArray();
    }
}
