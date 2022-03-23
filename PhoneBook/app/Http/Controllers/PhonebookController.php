<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\PhoneBookModel;

class PhonebookController extends Controller
{
    public function onInsert(Request $request)
    {
         $token = $request->input('access_token');
         $key = env('TOKEN_KEY');
         $decoded = JWT::decode($token, new Key($key, 'HS256')); //json object return korbe
         $decoded_array=(array)$decoded;    //json object k associative array te convert korbe
         $username = $decoded_array['user'];

         $PhOne=$request->input('phone_number_one');
         $PhTwo=$request->input('phone_number_two');
         $name = $request->input('name');
         $email = $request->input('email');

         $result = PhoneBookModel::insert([
            'username'=>$username,
            'phone_number_one'=>$PhOne,
            'phone_number_two'=>$PhTwo,
            'name'=>$name,
            'email'=>$email


        ]);

        if($result==true){
            return "Data Inserted Successful";
        }else{
            return "Data Insert Fail! Please Try Again.";
        }

    }

    public function onSelect(Request $request)
    {
        $token = $request->input('access_token');
        $key = env('TOKEN_KEY');
        $decoded = JWT::decode($token, new Key($key, 'HS256')); //json object return korbe
        $decoded_array=(array)$decoded;    //json object k associative array te convert korbe
        $username = $decoded_array['user'];
        $result = PhoneBookModel::where('username',$username)->get();
        return $result;
    }

    public function onDelete(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('access_token');
        $key = env('TOKEN_KEY');
        $decoded = JWT::decode($token, new Key($key, 'HS256')); //json object return korbe
        $decoded_array=(array)$decoded;    //json object k associative array te convert korbe
        $username = $decoded_array['user'];
        $result = PhoneBookModel::where(['username'=>$username,'email'=>$email])->delete();

        if($result==true){
            return "Data Deleted Successful";
        }else{
            return "Data Deleted Fail! Please Try Again.";
        }
    }
}
