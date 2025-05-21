<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
   use App\Models\Category;


class ProductController extends Controller
{

    public function index($category = null)
    {
        $categories = Category::all(); // pour afficher dans la vue

        if ($category) {
            $categoryModel = Category::where('name', $category)->first();
            $products = $categoryModel ? $categoryModel->products()->get() : collect();
        } else {
            $products = Product::with('category')->get();
        }

        $viewData = [];
        $viewData["title"] = "Liste des produits";
        $viewData["subtitle"] = $category ? "Produits de la catégorie $category" : "Tous les produits";
        $viewData["products"] = $products;
        $viewData["categories"] = $categories;

        return view('products.index')->with("viewData", $viewData);
    }


    public function show($id)
    {
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product->getName()." - Online Store";
        $viewData["subtitle"] =  $product->getName()." - Product information";
        $viewData["product"] = $product;
        return view('product.show')->with("viewData", $viewData);
    }
}
