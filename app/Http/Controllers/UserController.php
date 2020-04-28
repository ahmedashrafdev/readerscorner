<?php

namespace App\Http\Controllers;

use App\User;
use App\Address;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class UserController extends Controller
{

    public function login(Request $request)
    {
        if(User::where('email' , $request->email)->count() == 0){
            return  response()->json(['success' => 'false' , 'message' => 'this email is not found']);
        }
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);
        $passwordGrantClient = Client::find(env('PASSPORT_CLIENT_ID', 2));
        
        // dd($passwordGrantClient);
        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ];

        $tokenRequest =  Request::create('oauth/token' , 'post', $data );
        
        
        return app()->handle($tokenRequest);


    }
    
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:255',
            'phone' => 'required|max:255',
            'name' => 'required|max:255',
            'city_id' => 'required',
            'title' => 'required|max:255',
            'building' => 'required|max:255',
            'postal' => 'required|max:255',
            'apartment' => 'required|max:255',
            'phone' => 'required|max:255',
            'street' => 'required|max:255',
            'floor' => 'required|max:255',
        ]);
        $userRequest =  [
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>bcrypt($request->password),
            'phone' =>$request->phone,
        ];
        $user =  User::create($userRequest);
        $addressRequest =  [
            'user_id' =>$user->id,
            'city_id' =>$request->city_id,
            'title' =>$request->title,
            'building' =>$request->building,
            'street' => $request->street,
            'floor' => $request->floor,
            'postal' =>$request->postal,
            'apartment' =>$request->apartment,
            'phone' =>$request->phone,
        ];
        $this->attachAddress($addressRequest);
        // if(User::where('email' , $request->email)->count == 0){
        //     return  response()->json(['success' => 'false' , 'message' => 'this email is not found']);
        // }
        // $user = User::create();

        if(!$user) return  response()->json(['success' => 'false' , 'message' => 'registration_faild']);
        return response()->json(['success' => 'true' , 'message' => 'registration_success']);
    }
    
    public function updateUser(Request $request) {
        $user = $request->user();
        $validate = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|max:255',
            'name' => 'required|max:255',
        ]);
        isset($request->password) ? $validate->password = bcrypt($request->password) : "";
        $user->update($validate);
        return response()->json(['success' => 'true' , 'message' => 'user data updated successfully']);
    }
    public function addAddress(Request $request)
    {   
        // return $request->user();
        $validatedData = $request->validate([
            'city_id' => 'required',
            'title' => 'required|max:255',
            'building' => 'required|max:255',
            'postal' => 'required|max:255',
            'street' => 'required|max:255',
            'floor' => 'required|max:255',
            'apartment' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);

        $validatedData['user_id'] = $request->user()->id;
        $this->attachAddress($validatedData);
        return json_encode(["success" => true , "message" => 'address attached successfully to the user']);

    }

    public function getUser(Request $request) {
        return $request->user();
    }

    protected function attachAddress($request){
        Address::create($request);
    }
    public function getAddresses(Request $request){
        return json_encode($request->user()->addresses);
    }

    public function updateAddresse(Request $request , $id){
        $validatedData = $request->validate([
            'user_id' => 'required',
            'city_id' => 'required',
            'title' => 'required|max:255',
            'building' => 'required|max:255',
            'postal' => 'required|max:255',
            'apartment' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);
        Address::find($id)->update($validatedData);
        return json_encode(["success" => true , "message" => 'address updated successfully']);

    }

    public function deleteAddress($id){
        Address::destroy($id);
        return json_encode(["success" => true , "message" => 'address deleted successfully']);

    }
}
