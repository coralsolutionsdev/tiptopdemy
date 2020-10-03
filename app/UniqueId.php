<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB, Exception;
use Illuminate\Support\Facades\Schema;


class UniqueId extends Model
{
    //
    protected $fillable = ['module_id', 'unique_id'];

    /**
     * generate a unique id based on model record number.
     * @param $configArr
     * @return string
     * @throws Exception
     */
    public static function generate($configArr)
    {
        if (!array_key_exists('table', $configArr) || $configArr['table'] == '') {
            throw new Exception('Must need a table name');
        }
        if (!array_key_exists('table', $configArr) || $configArr['table'] == '' || !Schema::hasTable($configArr['table'])) {
            throw new Exception('Table is not existing in database');
        }
        if (!array_key_exists('length', $configArr) || $configArr['length'] == '') {
            throw new Exception('Must specify the length of ID');
        }
        if (!array_key_exists('prefix', $configArr) || $configArr['prefix'] == '') {
            throw new Exception('Must specify a prefix of your ID');
        }
        $field = array_key_exists('field', $configArr) ? $configArr['field'] : 'id';
        $prefix = $configArr['prefix'];
        $prefixLength = strlen($configArr['prefix']);
        $length = $configArr['length'];
        $idLength = $length - $prefixLength;
        $whereString = '';

        if (array_key_exists('where', $configArr)) {
            $whereString .= " WHERE ";
            foreach ($configArr['where'] as $row) {
                $whereString .= $row[0] . "=" . $row[1] . " AND ";
            }
        }
        $lastRecord = DB::table($configArr['table'])->orderBy('id', 'DESC')->first();
        $count = 1;
        if (!empty($lastRecord)){
            $count = $lastRecord->id + 1;
        }
        return $prefix .  str_pad($count, $idLength, '0', STR_PAD_LEFT);

    }
}
