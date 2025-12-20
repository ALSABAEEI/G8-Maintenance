<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'Supervisor_ID',
        'QuotaNumber',
        'TimeFrame_ID', // Added foreign key to relate with timeframes table
    ];

    /**
     * Define a relationship with the Timeframe model.
     */
    public function timeframe()
    {
        return $this->belongsTo(Timeframe::class, 'TimeFrame_ID', 'TimeFrame_ID');
    }

    /**
     * Define a relationship with the User model for the supervisor.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'Supervisor_ID', 'id');
    }
}
