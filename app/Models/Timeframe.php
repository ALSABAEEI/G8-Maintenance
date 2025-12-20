<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeFrame extends Model
{
    use HasFactory;

    protected $table = 'timeframes';

    protected $fillable = [
        'Start_Date',
        'End_Date',
        'Semester',
        'Event_Type',
    ];
}
