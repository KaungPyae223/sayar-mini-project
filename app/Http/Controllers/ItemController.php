<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        $items = Item::paginate(5);
        return view("item.index",compact("items","categories"));
    }

    public function search(Request $request){
        $query = $request->input('query');

        $items = Item::where('title','LIKE',"%{$query}%")->get();

        return view('item.index',compact('items'));
    }
    public function searchDetail(Request $request){

        $min = $request->input('min');
        $max = $request->input('max');
        $category = $request->input('category');
        $categories = Category::all();

        $items = Item::query()->where('price', '>=', $min)
             ->where('price', '<=', $max)
             ->where('category_id', '=', $category)
             ->paginate(5);

        return view("item.index",compact("items","categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view("item.create",compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        //

        if($request->hasFile('image')){

            $file = $request->file('image');

            $newName = "item_image".uniqid().".".$file->extension();

            $file->storeAs('public/itemImage', $newName);

        }

        $item = new Item();
        $item->title = $request->title;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->image = $newName;
        $item->save();

        return redirect()->route("item.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
        $categories = Category::all();
        return view('item.edit',compact("item","categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        //
        if($request->image){

            $file = $request->image;

            $imagePath = $item->image;

            $relativePath =  "public/itemImage/$imagePath";

            if (Storage::exists($relativePath)) {
                Storage::delete($relativePath);
            }

            $newName = "item_image".uniqid().".".$file->extension();

            $file->storeAs('public/itemImage', $newName );

            $item->image = $newName;
        }


        $item->title = $request->title;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->description = $request->description;
        $item->category_id = $request->category_id;

        $item->update();

        return redirect()->route("item.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
        $imagePath = $item->image;

        $relativePath =  "public/itemImage/$imagePath";

        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
        }
        $item->delete();
        return redirect()->route("item.index");
    }
}
