<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model
{

    public static function insertData($data){

            DB::table('corona_data')->insert($data);
    }

    public static function emptyTable() {
        DB::table('corona_data')->truncate();
    }
    //
}
