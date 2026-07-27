<?php 
class JobProgress extends Eloquent
{
    protected $table = 'job_progress';
    protected $fillable = array(
    'job_key',
    'status',
    'current_step',
    'total_steps',
    'message',
    'percent'
);
}