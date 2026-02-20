<?php
class PPOrder extends Eloquent
{
    protected $table = 'PPOrder';
    public  $timestamps = True;
    protected $primaryKey = 'PPOrder_Id';
    protected $guarded = array();
}
