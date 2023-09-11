<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $times = Item::all();
        //returns array or collection of Item object so that can use collection methods
        // dd($times);
        // return(var_dump($times));

        // dd($times->first());
        // return $times->last();
        // dd($times->dd());
        // return $times->dd();
        // dd($times->pluck("name","price"));
        // dd($times->sum("price"));
        // dd($times->avg("price"));
        // dd($times->max("price"));
        // dd($times->min("price"));

        // $newItems = $times->map(fn($time)=>[
        //     "name"=>$time->name,
        //     "price"=>$time->price
        // ]);


        // $newItems = $times->map(function($item){
        //     $item->price += 50;
        //     $item->stock -= 10;
        //     return $item;
        // });
        // dd($newItems);
        // dd($times->isEmpty());
        // dd($times->random());
        // dd($times->contains("name","orange"));
        // dd($times->count());
        // dd($times->filter(fn($item)=>$item->price > 900));
        // dd (collect($times->first())->keys());
        // return collect($times->first())->values();

        // $items = Item::where("id",">",40)->dd();
        // $items = Item::where("id",">",40)->where("price",">",700)->get();
        // dd($items);

        // $items=Item::where("price",">",900)->orWhere("stock","<",10)->get();

        // $items = Item::whereBetween("price",[700,900])->get();

        // $items = DB::table("items")->where("id",">",5)->get();

        // $items = Item::when(true,function($query){
        //     $query->where("id",5);
        // })->get();

        // $items = Item::limit(5)->get();

        // $items = Item::limit(5)->offset(10)->orderBy("id","asc")->get();

        // $items = Item::latest("id")->get();

        //get returns collection when get()[0], it returns App\Models\Item object
        // $items = Item::where("id",10)->get()[0];

        // returns App\Models\Item
        // $items = Item::where("id",10)->first();

        // $items = Item::where("id",">",20)->firstOrFail();

        // $items = Item::find(10);

        // $items = DB::table("items")->where("id",">",5)->dump()->get();

        // dd($items);
        // return $items;
        // dd(request()->name);

        // dd(request()->has("keyword"));

        $items = Item::when(request()->has("keyword"),function($query){
            $keyword = request()->keyword;
            $query->where("name","like","%".$keyword."%");
            $query->orWhere("price","like","%".$keyword."%");
            $query->orWhere("stock","like","%".$keyword."%");
        })
        ->when(request()->has('ordering'),function($query){
            $sortType = request()->ordering ?? 'asc';
            $query->orderBy('name',$sortType);
        })
        ->paginate(5)
        ->withQueryString();

        // $items = Item::paginate(7);

        return view("inventory.index",compact("items"));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("inventory.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {

        // return $request;

        $item = new Item();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;

        $item->save();

        return redirect()->route("item.index")->with("status","New Item Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view("inventory.show",["item"=>$item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view("inventory.edit",compact("item"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->update();

        return redirect()->route("item.index")->with("status","New Item Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->back()->with("status","New Item Deleted");
    }



}
