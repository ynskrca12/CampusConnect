<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUser;
use App\Http\Requests\RegisterUSer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterUSer $request){
        
        try {
            
        $user = new User();

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password =Hash::make($request->password,[
            'rounds' =>12
        ]);

        $user->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Kullanıcı başarıyla kaydedildi.',
            'user' =>$user
        ]);

        } catch (Exception $e) {
            return response()->json($e);
        }



    }//end method

    public function login(LogUser $request)
    {
        if (auth()->attempt($request->only(['email', 'password']))) {
            $user = auth()->user();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Giriş yapıldı.',
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status_code' => 403,
                'status_message' => 'Bilgiler geçersiz.',
            ]);
        }
    }

    public function getAllUsers()
    {
        $users = User::all();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Tüm kullanıcılar alındı.',
            'users' => $users,
        ]);
    }
}
