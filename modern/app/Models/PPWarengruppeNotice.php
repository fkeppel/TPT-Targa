<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPWarengruppeNotice extends Model
{
    protected $table = 'PPWarengruppeNotice';

    protected $primaryKey = 'PPWarengruppeNotice_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPWarengruppeNotice_WGRP',
        'PPWarengruppeNotice_Notice',
    ];
}
