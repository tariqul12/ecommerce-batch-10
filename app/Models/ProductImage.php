<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    private static $productImage, $image, $extension, $imageName, $directory, $imageUrl;

    private static function getImageUrl($image)
    {
        self::$extension    = $image->getClientOriginalExtension(); // png
        self::$imageName    = rand(1000,50000).'.'.self::$extension; // 32123435.png
        self::$directory    = 'upload/category-images/';
        $image->move(self::$directory, self::$imageName);
        self::$imageUrl     = self::$directory.self::$imageName; // upload/category-images/32123435.png
        return self::$imageUrl;
    }

    public static function newProductImage($images,$productId)
    {
        foreach ($images as $image)
        {
            self::$imageUrl = self::getImageUrl($image);
            self::$productImage = new ProductImage();
            self::$productImage->product_id = $productId;
            self::$productImage->image = self::$imageUrl;
            self::$productImage->save();

        }
    }

    public static function updateProductImage($request, $id)
    {
        self::$productImage = ProductImage::find($id);
        if (self::$image = $request->file('image'))
        {
            self::deleteImageFormFolder(self::$productImage->image);
            self::$imageUrl = self::getImageUrl($request->file('image'));
        }
        else
        {
            self::$imageUrl = self::$productImage->image;
        }
        self::saveBasicInfo(self::$productImage, $request, self::$imageUrl);
    }

    public static function deleteProductImage($id)
    {
        self::$productImage = Category::find($id);
        self::deleteImageFormFolder(self::$productImage->image);
        self::$productImage->delete();
    }

    private static function saveBasicInfo($productImage, $request, $imageUrl)
    {
        $productImage->name           = $request->name;
        $productImage->description    = $request->description;
        $productImage->image          = $imageUrl;
        $productImage->status         = $request->status;
        $productImage->save();
    }

    private static function deleteImageFormFolder($imageUrl)
    {
        if (file_exists($imageUrl))
        {
            unlink($imageUrl);
        }
    }
}
