<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        // $this->middleware('cat');
        // $this->middleware('cat')->only(['store','delete','index']);
        // $this->middleware('cat')->except('index');
    }

    public function index()
    {
        return response()->json("hello",200);
        // return response()->json([
        //     "a"=>"x",
        //     "b"=>"y",
        //     "c"=>"z"
        // ],404);

        //ဒီမှာက paginate() method ကို query builder ရဲ့နောက်မှာ apply တာက collection တခုပြန်ပေးတာ အဲ့တာကြောင့် get() မသုံးလဲရတယ်

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

        // return response()->json($items);
        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // $request->validate([
        //     "name"=>"required",
        //     "price"=>"required",
        //     "stock"=>"required"
        // ]);

        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "price"=>"required",
            "stock"=>"required"
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),422);
        }
        $item = Item::create([
            "name"=>$request->name,
            "price"=>$request->price,
            "stock"=> $request->stock
        ]);
        // return response()->json($item);
        return new ItemResource($item);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $items = Item::find($id);
        if(is_null($items)){
            return response()->json(["message"=>"not found"],404);
        }
        // return response()->json($items);
        return new ItemResource($items);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "price"=>"required",
            "stock"=>"required"
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),422);
        }

        $item = Item::find($id);
        if(is_null($item)){
            return response()->json(["message"=>"not found"],404);
        }

        $item->update([
            "name"=>$request->name,
            "price"=>$request->price,
            "stock"=>$request->stock
        ]);

        // return response()->json($item);
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $items = Item::find($id);
        if(is_null($items)){
            return response()->json(["message"=>"not found"],404);
        }
        $items->delete();
        return response()->json([],204);
    }

}
