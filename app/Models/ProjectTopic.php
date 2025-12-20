<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTopic extends Model
{
    use HasFactory;

    protected $table = 'project_topics'; // The database table name

    protected $fillable = [
        'Student_ID',
        'Supervisor_ID',
        'Topic_Title',
        'Topic_Description',
        'Status',
    ];
}
