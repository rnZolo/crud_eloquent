<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Item;

class ItemController extends Controller
{

    function index(){
        $title = 'Delete Item!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('page.product.index');
    }

    function store(Request $request){
      if($request->ajax()){
        $validated =  $request->validate([
            "item_number" => 'required|integer',
            "item_name" => 'required|string',
            "item_price" => 'required',
            "item_category" => 'required|string',
            "item_stock" => 'required|integer',
        ]);
        Item::create($request->all());
      }
        // toast('Item Added', 'success');
        // return response()->json(['status' => 200]);       
    }

    function ajx(Request $request){
        if($request->ajax()){
            $item = Item::all();
            // dd($item);
            return datatables()->of($item)->toJson();
        }
    }

    function edit($id){
        $item = new Item();
        try{
            $data = $item->findOrFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json(['status' => 404]);
        }
       
        return response()->json($data);
    }
       
    

    function destroy($id){
        // dd($id);
        $item = new Item();
        try{
            $item->findOrFail($id);
        }catch(ModelNotFoundException $e){
            return toast('Item not Found', 'error');
        }
        toast('Item Delete', 'success');
        $item->Find($id)->delete();
        return back();
    }
}
