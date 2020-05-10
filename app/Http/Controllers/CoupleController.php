<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Couple;
use App\Note;
use App\User;
use Illuminate\Http\Request;

class CoupleController extends Controller
{
       
    public function Statistic(Request $request){
        $token = Request('token');
        $user = User::where('remember_token', $token)->first();
        $lover = User::where('lover_id', $user->lover_id)
        ->where('id', '!=', $user->id)
        ->first();

        $note_user = Note::where('id_user', $user->id)
        ->where('date', 'like', '%'.Request('date'))
        ->get();
        if($user->lover_id){
            $note_lover = Note::where('id_couple', $user->lover_id)
            ->where('id_user', '!=', $user->id)
            ->where('date', 'like', '%'.Request('date'))
            ->get();
        }else {
            $note_lover = null;
        }

        return response()->json(['user' => $user, 'lover' => $lover, 'noteUser' => $note_user, 'noteLover' => $note_lover]);  
    }

    public function loverDelete(Request $request){
        $user = User::where('remember_token', Request('token'))->first();
        $note = Note::where('id_couple', $user->lover_id)->delete();
        $couple = Couple::where('id', $user->lover_id)->first();
        $lover_user = null;
       
        if($couple->user_1 == $user->id){
            $lover_user = User::where('id', $couple->user_2)->first();
        }else {
            $lover_user = User::where('id', $couple->user_1)->first();
        }
        $lover_user->lover_id = null;
        $lover_user->secret_pass = $lover_user->name.''.Str::random(7);
        $lover_user->save();

        $user->lover_id = null;
        $user->secret_pass = $user->name.''.Str::random(7);
        $user->save();
        $couple->delete();
        return response()->json(['message' => "Vous n'êtes plus liée a personne, vos notes on été mis a jour !"]);
    }
}
