<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class XMLConverter extends Model
{
    protected $table = 'XMLConverter';

    protected $primaryKey = 'XMLConverter_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['XMLConverter_DBTable',
        'XMLConverter_DBColumn',
        'XMLConverter_XMLNode'];
}
