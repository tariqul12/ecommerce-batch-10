<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopgridController extends Controller
{
    public function index()
    {
        return view('front-end.home.home');
    }

    public function category()
    {
        return view('front-end.category.index');
    }

    public function product()
    {
        return view('front-end.product.index');
    }
}
