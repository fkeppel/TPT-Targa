class MassImportJob extends Eloquent
{
protected $table = 'mass_import_jobs';
protected $primaryKey = 'id';
public $incrementing = false;
protected $fillable = array(
'id',
'user_id',
'import_token',
'filename',
'status',
'total_files',
'processed_files',
'current_file',
'messages',
'error_message'
);
}