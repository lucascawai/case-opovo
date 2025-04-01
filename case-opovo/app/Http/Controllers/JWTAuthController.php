<?php

namespace App\Http\Controllers;

use App\Models\Journalist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
   // Journalist registration
   public function register(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:journalists',
           'password' => 'required|string|min:6',
       ]);

       if($validator->fails()){
           return response()->json($validator->errors()->toJson(), 400);
       }

       $journalist = Journalist::create([
           'first_name' => $request->get('first_name'),
           'last_name' => $request->get('last_name'),
           'email' => $request->get('email'),
           'password' => Hash::make($request->get('password')),
       ]);

       $token = JWTAuth::fromUser($journalist);

       return response()->json(compact('journalist','token'), 201);
   }

   // Journalist login
   public function login(Request $request)
   {
       $credentials = $request->only('email', 'password');

       try {
           if (! $token = JWTAuth::attempt($credentials)) {
               return response()->json(['error' => 'Invalid credentials'], 401);
           }

           // Get the authenticated user.
           $journalist = auth()->user();

           // (optional) Attach the role to the token.
           // $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

           return response()->json(compact('token'));
       } catch (JWTException $e) {
           return response()->json(['error' => 'Could not create token'], 500);
       }
   }

   // Get authenticated journalist
   public function getJournalist()
   {
       try {
           if (! $user = JWTAuth::parseToken()->authenticate()) {
               return response()->json(['error' => 'User not found'], 404);
           }
       } catch (JWTException $e) {
           return response()->json(['error' => 'Invalid token'], 400);
       }

       return response()->json(compact('user'));
   }

   // User logout
   public function logout()
   {
       JWTAuth::invalidate(JWTAuth::getToken());

       return response()->json(['message' => 'Successfully logged out']);
   }
}
