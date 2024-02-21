<?php

namespace App\Http\Controllers;

use App\Models\Basket;
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

    public function osszesTermek(){
        $user = Auth::user();
        $basket = Basket::with('kosar')->where('user_id','=',$user->id)->get();
        return $basket;
    }

    public function tipusonkent($id, $type_id)
    {
        return DB::table('baskets as b')
        ->selectRaw('b.user_id, b.item_id')
        ->join('product as p', 'p.item_id, b.item_id')
        ->join('product_type as t','t.type_id','p.type_id')
        ->where('b.user_id', $id and 'p.type_id', $type_id) 
        ->get();
    }

    public function kosarTorles()
    {  
        DB::table('baskets')
            ->where('created at', date(now())-2)
            ->destroy();
        }
}
