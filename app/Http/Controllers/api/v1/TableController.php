<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(){
        $tables = Table::all();
        $tables->map(function($t){
                return[
                    'id' => $t->id,
                    'name'=> $t->name,
                    'x'=> $t->x,
                    'y'=> $t->y,
                    'width' => $t->width,
                    'height' => $t->height,
                    'createdAt' => $t->createdAt,
                    'updatedAt' => $t->updatedAt,
                    'hasOpenOrder' => $t->hasOpenOrder,
                ];
        });
        return response()->json($tables, 200);
    }
}
