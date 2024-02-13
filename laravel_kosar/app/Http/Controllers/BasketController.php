<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function index(){
        return response()->json(Basket::all());
    }

    public function show($user_id, $item_id){
        $basket = Basket::where('user_id', $user_id)
        ->where('item_id',"=", $item_id)
        ->get();
        return $basket[0];
    }

    public function store(Request $request){
        $item = new Basket();
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;
                
        $item->save();
    }

    public function update(Request $request, $user_id, $item_id){
        $item = $this->show($user_id, $item_id);
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;

        $item->save();
    }

    public function destroy($user_id, $item_id){
        $this->show($user_id, $item_id)->delete();
    }

    public function feladat1(){
        $user = Auth::user();
        $products = Product::join('baskets', 'baskets.item_id', '=', 'products.item_id')
                            ->with('products')
                            ->where('baskets.user_id','=',$user->id)
                            ->get();
        return $products;
    }

    public function feladat2($user_id, $name){
        return DB::select("SELECT * FROM products p
                           INNER JOIN baskets b ON b.item_id = p.item_id
                           INNER JOIN product_types pt ON pt.type_id = p.type_id
                           WHERE b.user_id = $user_id AND pt.name LIKE '%$name%'");
    }

    public function feladat3(){
        return DB::delete("DELETE FROM baskets where DATEDIFF(CURDATE(), created_at) >= 2");
    }

    /*trigger:
        CREATE TRIGGER increateQuantity AFTER DELETE ON baskets FOR EACH ROW UPDATE products SET quantity = quantity + 1 WHERE item_id = OLD.item_id;  */
}
