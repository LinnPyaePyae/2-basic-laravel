<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create(){
        return view('inventory.create');
    }

    public function index(){
        $items = new Item();
        $all = $items->all();
        // return $all;
        return view("inventory.index",[
            "items"=>Item::all()
        ]);
    }

    public function store(Request $request){
        dd($request);
        // return $request;
        // if($request->has("user")){
        //     dd("shi");
        // }else{
        //     dd("ma shi");
        // }
        // return $request;

        $item = new Item();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;

        $item->save();

        return redirect()->route("item.index");

        // return $item;

        // $item = Item::create([
        //     "name"=>$request->name,
        //     "price"=>$request->price,
        //     "stock"=>$request->stock
        // ]);
        //create success return 1

        // $item = Item::create($request->all());
        // return $item;

    }

    public function show($id){

        //select * from items where id=$id
        // $item = Item::findOrFail($id);
        // return $item;
        // if(is_null($item)){
        //     return abort(404);
        // }

        return view('inventory.show',["item"=>Item::findOrFail($id)]);

        // return view('inventory.show',compact("item"));

    }

    public function edit($id)
    {
        return view("inventory.edit",["item"=>Item::findOrFail($id)]);
    }


    public function update($id,Request $request)
    {

        // return $request;
        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->update();

        return redirect()->route("item.index");

    }

    public function destroy($id)
    {

        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->back();
    }

}
