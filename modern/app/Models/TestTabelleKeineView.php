<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestTabelleKeineView extends Model
{
    protected $table = 'test_tabelle_keine_view';

    protected $primaryKey = ' test_tabelle_keine_view_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
