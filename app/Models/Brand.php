<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    private static $brand, $image, $extension, $imageName, $directory, $imageUrl;

    private static function getImageUrl($image)
    {
        self::$extension    = $image->getClientOriginalExtension(); // png
        self::$imageName    = time().'.'.self::$extension; // 32123435.png
        self::$directory    = 'upload/Brand-images/';
        $image->move(self::$directory, self::$imageName);
        self::$imageUrl     = self::$directory.self::$imageName; // upload/Brand-images/32123435.png
        return self::$imageUrl;
    }

    public static function newBrand($request)
    {
        self::saveBasicInfo(new Brand(), $request, self::getImageUrl($request->file('image')));
    }

    public static function updateBrand($request, $id)
    {
        self::$brand = Brand::find($id);
        if (self::$image = $request->file('image'))
        {
            self::deleteImageFormFolder(self::$brand->image);
            self::$imageUrl = self::getImageUrl($request->file('image'));
        }
        else
        {
            self::$imageUrl = self::$brand->image;
        }
        self::saveBasicInfo(self::$brand, $request, self::$imageUrl);
    }

    public static function deleteBrand($id)
    {
        self::$brand = Brand::find($id);
        self::deleteImageFormFolder(self::$brand->image);
        self::$brand->delete();
    }

    private static function saveBasicInfo($brand, $request, $imageUrl)
    {
        $brand->name           = $request->name;
        $brand->description    = $request->description;
        $brand->image          = $imageUrl;
        $brand->status         = $request->status;
        $brand->save();
    }

    private static function deleteImageFormFolder($imageUrl)
    {
        if (file_exists($imageUrl))
        {
            unlink($imageUrl);
        }
    }
}
