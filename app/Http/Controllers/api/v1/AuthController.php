<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request){
        if(!$request->username || !$request->password){
            return response('Unauthorized' , 401);
        }

        //find the user
        $user = User::where('username', $request->username)->first();
        if($user && $user->password == $request->password && $user->role === 'ADMIN'){
           $token = md5($user->username);
           $user->token = $token;
           $user->save();
           return response()->json(['token' => $token], 200);
        }
        return response('Unauthorized' , 401);
    }
    public function pinLogin(Request $request){
        if(!$request->pin){
            return response('Unauthorized' , 401);
        }
        //find the user
        $user = User::where('pin', $request->pin)->first();
        if($user && $user->pin == $request->pin && $user->role === 'WAITER'){
            $token = md5($user->username);
            $user->token = $token;
            $user->save();

            return response()->json(['token' => $token], 200);
        }
        return response('Unauthorized' , 401);
    }
    public function logout(Request $request){
        $user = User::where('token', $request->bearerToken())->first();
        $user->token = null;
        $user->save();

        return response('Logged out' , 200);
    }
    //for resetting the database
    public function resetDB(){
        //drop all the tables first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
/*        DB::statement('DROP TABLE User');
        DB::statement('DROP TABLE MenuCategory');
        DB::statement('DROP TABLE MenuItem');
        DB::statement('DROP TABLE Order');
        DB::statement('DROP TABLE OrderItem');
        DB::statement('DROP TABLE Table');*/
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

//        grab the dump from public storage
        $sql = Storage::get('public/dineease.sql');
        DB::unprepared($sql);

        return response('Database reset successful.' , 200);
    }
}
