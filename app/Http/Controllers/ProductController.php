<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;
    public function index()
    {
        return view('admin.product.index');
    }
    public function create()
    {
        return view('admin.product.add', [
            'categories' => Category::all(),
            'units'      => Unit::all(),
            'brands'     => Brand::all(),
            'subCategories'=>SubCategory::all()
        ]);
    }
    public function store(Request $request)
    {
        $this->product = Product::newProduct($request);
        ProductImage::newProductImage($request->file('other_image'),$this->product->id);
        return back()->with('message','Product info save successfully');
    }
}
