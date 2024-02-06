<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\select;

class Category extends Model
{
    use HasFactory;

    private static $category, $image, $extension, $imageName, $directory, $imageUrl;

    private static function getImageUrl($image)
    {
        self::$extension    = $image->getClientOriginalExtension(); // png
        self::$imageName    = time().'.'.self::$extension; // 32123435.png
        self::$directory    = 'upload/category-images/';
        $image->move(self::$directory, self::$imageName);
        self::$imageUrl     = self::$directory.self::$imageName; // upload/category-images/32123435.png
        return self::$imageUrl;
    }

    public static function newCategory($request)
    {
        self::saveBasicInfo(new Category(), $request, self::getImageUrl($request->file('image')));
    }

    public static function updateCategory($request, $id)
    {
        self::$category = Category::find($id);
        if (self::$image = $request->file('image'))
        {
            self::deleteImageFormFolder(self::$category->image);
            self::$imageUrl = self::getImageUrl($request->file('image'));
        }
        else
        {
            self::$imageUrl = self::$category->image;
        }
        self::saveBasicInfo(self::$category, $request, self::$imageUrl);
    }

    public static function deleteCategory($id)
    {
        self::$category = Category::find($id);
        self::deleteImageFormFolder(self::$category->image);
        self::$category->delete();
    }

    private static function saveBasicInfo($category, $request, $imageUrl)
    {
        $category->name           = $request->name;
        $category->description    = $request->description;
        $category->image          = $imageUrl;
        $category->status         = $request->status;
        $category->save();
    }

    private static function deleteImageFormFolder($imageUrl)
    {
        if (file_exists($imageUrl))
        {
            unlink($imageUrl);
        }
    }
}
