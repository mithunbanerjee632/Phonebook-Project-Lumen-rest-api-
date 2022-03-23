<?php
namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\RegistrationModel;

class LoginController extends Controller
{
   public function onTest()
   {
       return "Test Is Ok";
   }

    public function onLogin(Request $request)
    {
       $username = $request->input('username');
       $password = $request->input('password');

       $usercount= RegistrationModel::where(['username'=>$username,'password'=>$password])->count();
       if($usercount == 1){

        $key = env('TOKEN_KEY');

        $payload = array(
            "site" => "http://demo.com",
            "user" => $username,
            "iat" => time(),
            "exp" => time()+3600
        );

        $jwt = JWT::encode($payload, $key, 'HS256');
        return response()->json(['Token'=>$jwt,'Status'=>'Login Success']);



        }else{
            return "Username And Password Dosen't Match!";
        }

    }
}
