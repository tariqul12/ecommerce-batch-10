<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    private static $unit;

    public static function newUnit($request)
    {
        self::saveBasicInfo(new Unit(), $request,);
    }

    public static function updateUnit($request, $id)
    {
        self::saveBasicInfo(Unit::find($id), $request,);
    }

    public static function deleteUnit($id)
    {
        self::$unit = Unit::find($id);
        self::$unit->delete();
    }

    private static function saveBasicInfo($unit, $request)
    {
        $unit->name           = $request->name;
        $unit->code           = $request->code;
        $unit->description    = $request->description;
        $unit->status         = $request->status;
        $unit->save();
    }

}
