<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Legacy model whose backing table is not present in the supplied schema.
 */
class MassImportJob extends Model
{
    protected $table = 'mass_import_jobs';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'import_token',
        'filename',
        'status',
        'total_files',
        'processed_files',
        'current_file',
        'messages',
        'error_message',
    ];
}
