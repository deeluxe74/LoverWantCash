<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Couple;
use App\Note;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signUp(Request $request){
        $name = ucfirst(Request('name'));
        $email = Request('email');
        $password = Request('pass');

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->secret_pass = $user->name.''.Str::random(7);
        $user->save();

        return $name;
    }

    public function login(Request $request){
        $email = Request('email');
        $password = Request('password');

        if (Auth::attempt(['email' => $email, 'password' => $password], true)){

            $token = Auth::user()->remember_token;
            return response()->json(['token'=> $token,'asErrors'=>false, 'message'=> 'Félicitation, vous êtes maintenant connecté !']);
            
        }
        return response()->json(['asErrors'=>true, 'message'=> 'Veuillez vérifier vos identifiants de connexion.']);
    }

    public function get(Request $request){
        $user = User::where('remember_token', Request('token'))->first();
        $note = Note::where('id_user', $user->id)->get();
        $user_lover = false;
        if($user->lover_id){
            $user_lover = User::where('lover_id', $user->lover_id)
            ->where('id', '!=', $user->id)->first();
            $user_lover = $user_lover->name;
        }
        return response()->json(['nameLover' => $user_lover, 'user' => $user, 'note' => $note]);
    }

    public function sendLove(Request $request){
        $user = User::where('secret_pass', Request('secret'))->first();
        $currUser = User::where('remember_token', Request('token'))->first();
        //Check if as not lovers
        if($user == null){
            return response()->json(['asErrors' => true, 'message' => "Cette personne n'existe pas veuillez recommencer."]);
        }
        if($user->lover_id){
            return response()->json(['asErrors' => true, 'message' => 'Cette personne et déja lié désoler =(']);
        }

        //Init couple
        $couple = new Couple;
        $couple->user_1 = $user->id;
        $couple->user_2 = $currUser->id;

        $couple->save();
        // Join the two members
        $user->lover_id = $couple->id;
        $currUser->lover_id = $couple->id;
        $user->save();
        $currUser->save();
                
        //lied the oldest note
        $notes = Note::where('id_user', $currUser->id)->get();
        foreach ($notes as $note) {
            $note->id_couple = $currUser->lover_id;
            $note->save();
        }
        $notes = Note::where('id_user', $user->id)->get();
        foreach ($notes as $note) {
            $note->id_couple = $user->lover_id;
            $note->save();
        }

        return response()->json(['nameLover' => $user->name, 'asErrors' => false, 'message' => 'Vous êtes maintenant liée. Félicitation !']);
    }
}
