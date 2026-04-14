<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Voedselpakket extends Model
{
    protected $table = 'Voedselpakket';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public static function getByGezinId($gezinId)
    {
        return DB::select('CALL sp_GetVoedselpakkettenByGezinId(?)', [$gezinId]);
    }

    public static function getById($pakketId)
    {
        $result = DB::select('CALL sp_GetVoedselpakketById(?)', [$pakketId]);
        return $result ? $result[0] : null;
    }

    public static function updateStatus($pakketId, $status)
    {
        return DB::statement('CALL sp_UpdateVoedselpakketStatus(?, ?)', [$pakketId, $status]);
    }
}
