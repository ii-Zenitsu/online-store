<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
   use App\Models\Category;


class ProductController extends Controller
{

 public function index($category = null)
{
    $categories = Category::all();

    $query = Product::query()->with('category');

    // Filtrage par catégorie (slug ou nom dans URL)
    if ($category) {
        $categoryModel = Category::where('name', $category)->first();
        if ($categoryModel) {
            $query->where('category_id', $categoryModel->id);
        } else {
            $query->whereRaw('0 = 1'); // renvoyer collection vide
        }
    }

    // Filtrage par produits soldés (si paramètre GET ?discounted=1)
    if (request()->has('discounted')) {
        $query->whereHas('discounts', function ($q) {
            $q->whereDate('start_date', '<=', now())
              ->whereDate('end_date', '>=', now());
        });
    }

    $products = $query->get();

    $viewData = [];
    $viewData["title"] = "Liste des produits";
    $viewData["subtitle"] = $category ? "Produits de la catégorie $category" : "Tous les produits";
    $viewData["products"] = $products;
    $viewData["categories"] = $categories;
    return view('product.index')->with("viewData", $viewData);
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
