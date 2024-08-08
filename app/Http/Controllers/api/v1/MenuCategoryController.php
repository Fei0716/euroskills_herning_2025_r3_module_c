<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    public function index(){
        $mc = MenuCategory::orderBy('priority', 'asc')->get();
        return response()->json($mc, 200);
    }

    public function store(Request $request){
        //check for missing fields
        if(!$request->name || !$request->priority ){
            return response('One of the mandatory fields is missing' , 400);
        }
        $mc = new MenuCategory();
        $mc->name = $request->name;
        $mc->priority = $request->priority;
        $mc->save();

        return response()->json($mc , 201);
    }
    public function destroy(MenuCategory $menuCategory){
        $menuCategory->delete();
        return response('Menu category deleted.', 200);
    }
    public function update($id , Request $request){
        //check for missing fields
        if(!$request->name || !$request->priority ){
            return response('One of the mandatory fields is missing' , 400);
        }
        $mc = MenuCategory::find($id);
        if(!$mc){
            return response('Menu category not found' , 404);
        }
        $mc->name = $request->name;
        $mc->priority = $request->priority;
        $mc->save();

        return response()->json($mc , 200);
    }
}
