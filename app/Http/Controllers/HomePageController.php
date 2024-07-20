<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function home()
    {
        $isProductFeatured = Product::where([
            'is_featured' => 'Yes',
            'status' => 1,
            'is_show_home' => 'Yes'
        ])->limit(6)->get();

        $latest = Product::orderBy('id', 'desc')->where([
            'status' => 1,
            'is_show_home' => 'Yes'
        ])->with('galleries')->limit(6)->get();

        $productPriceSale = Product::where([
            ['status', '=', 1],
            ['is_show_home',  'Yes'],
            ['price_sale', '>', 0]
        ])->get();


        return view('client.pages.home', compact('isProductFeatured', 'latest', 'productPriceSale'));
    }
}
