<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gezin extends Model
{
    protected $table = 'Gezin';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public static function getGezinnenMetVoedselpakketten($eetwens = null)
    {
        if ($eetwens) {
            return DB::select('CALL sp_GetGezinnenMetVoedselpakkettenMetEetwens(?)', [$eetwens]);
        } else {
            return DB::select('CALL sp_GetGezinnenMetVoedselpakketten()');
        }
    }
}
