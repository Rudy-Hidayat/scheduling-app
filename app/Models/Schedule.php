<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'npm',
        'asal_instansi',
        'nomor_whatsapp',
        'purpose',
        'date',
        'time',
        'end_time',
        'place',
        'status',
        'notes'
    ];

    public $timestamps = false;

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
