<?php
/**
 * @property int $Translations_Id
 * @property string|null $Translations_DE
 * @property string|null $Translations_EN
 * @property string $Translations_Table
 * @property int $Translations_TableId
 * @property string $Translations_Column
 */
class Translations extends Eloquent {
    protected $primaryKey = 'Translations_Id';
    protected $table      = 'Translations';
    public $timestamps    = false;
    protected $guarded = [];
}
