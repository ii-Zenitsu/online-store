<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $total = 0;
        $productsInCart = [];

        $productsInSession = $request->session()->get("products");
        if ($productsInSession) {
            $productsInCart = Product::findMany(array_keys($productsInSession));
            $total = Product::sumPricesByQuantities($productsInCart, $productsInSession);
        }

        $viewData = [];
        $viewData["title"] = "Cart - Online Store";
        $viewData["subtitle"] =  "Shopping Cart";
        $viewData["total"] = $total;
        $viewData["products"] = $productsInCart;
        return view('cart.index')->with("viewData", $viewData);
    }

    public function add(Request $request, $id)
<<<<<<< HEAD
    {
        $products = json_decode(Cookie::get('products', '[]'), true);
        $products[$id] = $request->input('quantity');
        Cookie::queue('products', json_encode($products), 60 * 24 * 7); 
        return redirect()->route('cart.index');
=======
{
    $quantityRequested = (int) $request->input('quantity', 1);
    $product = Product::findOrFail($id);

    if ($product->getQuantityStore() < $quantityRequested) {
        return redirect()->route('cart.index')->withErrors([
            'stock' => 'La quantité demandée n’est pas disponible en stock.',
        ]);
>>>>>>> c0f7df733b09f9fee0c460242f245df758027a90
    }

    $products = $request->session()->get("products", []);

    // Si le produit est déjà dans le panier, on ajoute à la quantité existante
    if (array_key_exists($id, $products)) {
        $totalQuantity = $products[$id] + $quantityRequested;

        if ($totalQuantity > $product->getQuantityStore()) {
            return redirect()->route('cart.index')->withErrors([
                'stock' => 'Stock insuffisant pour cette quantité cumulée.',
            ]);
        }

        $products[$id] = $totalQuantity;
    } else {
        $products[$id] = $quantityRequested;
    }

    $request->session()->put('products', $products);

    return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
}


    public function delete(Request $request)
    {
        $request->session()->forget('products');
        return back();
    }

   public function purchase(Request $request)
{
    $productsInSession = $request->session()->get("products");
    if ($productsInSession) {
        $userId = Auth::user()->getId();
        $order = new Order();
        $order->setUserId($userId);
        $order->setTotal(0);
        $order->save();

        $total = 0;
        $productsInCart = Product::findMany(array_keys($productsInSession));
        foreach ($productsInCart as $product) {
            $quantity = $productsInSession[$product->getId()];
            
            // 1. Création de l'item de commande
            $item = new Item();
            $item->setQuantity($quantity);
            $item->setPrice($product->getPrice());
            $item->setProductId($product->getId());
            $item->setOrderId($order->getId());
            $item->save();
            
            // 2. Mise à jour de la quantité en stock (partie manquante)
            $newQuantity = $product->getQuantityStore() - $quantity;
            if ($newQuantity < 0) {
                $newQuantity = 0; // Pour éviter stock négatif
            }
            $product->setQuantityStore($newQuantity);
            $product->save();

            $total += $product->getPrice() * $quantity;
        }

        $order->setTotal($total);
        $order->save();

        $newBalance = Auth::user()->getBalance() - $total;
        Auth::user()->setBalance($newBalance);
        Auth::user()->save();

        $request->session()->forget('products');

        $viewData = [];
        $viewData["title"] = "Purchase - Online Store";
        $viewData["subtitle"] =  "Purchase Status";
        $viewData["order"] =  $order;
        return view('cart.purchase')->with("viewData", $viewData);
    } else {
        return redirect()->route('cart.index');
    }
}

}
