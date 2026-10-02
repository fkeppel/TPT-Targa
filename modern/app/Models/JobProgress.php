<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobProgress extends Model
{
    protected $table = 'job_progress';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'job_key',
        'status',
        'current_step',
        'total_steps',
        'message',
        'percent',
    ];
}
