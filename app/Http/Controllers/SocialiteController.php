<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class SocialiteController extends Controller
{
    
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
         try {

             $user = Socialite::driver('google')->user();

             $findUser = User::where('client_id', $user->id)->first();

             if($findUser){

                $findUser->update([
                    'client_id' => $findUser->id
                ]);


                $notification = array(
                    'message' => 'Anda Berhasil Login',
                    'alert-type' => 'success'
                );

                Auth::login($findUser);
                return redirect('/dashboard')->with($notification);

             }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'client_id' => $user->id,
                    'password' => Hash::make('user12345'),
                ]);

                $notification = array(
                    'message' => 'Anda Berhasil Login',
                    'alert-type' => 'success'
                );

                Auth::login($newUser);
                return redirect('/dashboard')->with($notification);

             }
             
         } catch (Exception $e) {
             
         }
    }

}
