<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(){
        $mi =  MenuItem::all();
        return response()->json($mi , 200);
    }
    public function store(Request $request){
        //check for missing fields
        if(!$request->name || !$request->type || !$request->menuCategoryId || !$request->price){
            return response('One of the mandatory fields is missing' , 400);
        }
        //check for validity of type and category id
        $mc = MenuCategory::find($request->menuCategoryId);
        if(!$mc){
            return response('Menucard category with the given ID does not exist' , 400);
        }
        if(!in_array($request->type, ['FOOD', 'DRINK', 'OTHER']) ) {
            return response('Value of the type field is invalid' , 400);

        }

        $mi = new MenuItem();
        $mi->name = $request->name;
        $mi->type = $request->type;
        $mi->menuCategoryId = $request->menuCategoryId;
        $mi->price = $request->price;
        $mi->save();

        return response()->json($mi , 201);
    }

    public function update($id, Request $request){
        //check for missing fields
        if(!$request->name || !$request->type || !$request->menuCategoryId || !$request->price){
            return response('One of the mandatory fields is missing' , 400);
        }
        //check for validity of type and category id
        $mc = MenuCategory::find($request->menuCategoryId);
        if(!$mc){
            return response('Menucard category with the given ID does not exist' , 400);
        }
        if(!in_array($request->type, ['FOOD', 'DRINK', 'OTHER']) ) {
            return response('Value of the type field is invalid' , 400);

        }
        $mi = MenuItem::find($id);
        if(!$mi){
            return response(' Menu item not found' , 404);
        }
        $mi->name = $request->name;
        $mi->type = $request->type;
        $mi->menuCategoryId = $request->menuCategoryId;
        $mi->price = $request->price;
        $mi->save();

        return response()->json($mi , 200);
    }
    public function destroy($id, Request $request){
        $mi = MenuItem::find($id);
        if(!$mi){
            return response(' Menu item not found' , 404);
        }
        $mi->delete();
        return response('Menu item deleted', 200);
    }

}
