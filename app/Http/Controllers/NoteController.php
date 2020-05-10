<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use App\User;

class NoteController extends Controller
{
    public function new(Request $request){
        $user = User::where('remember_token', Request('token'))->first();

        $note = new Note;
        $note->designation = Request('designation');
        $note->prix = Request('prix');
        $note->date = Request('date');
        $note->id_user = $user->id;

        if($user->lover_id){
            $note->id_couple = $user->lover_id;
        }
        $note->save();
        return response()->json(['asErrors'=>false, 'message'=> 'Votre notes a bien été ajouter :)']);
    }

    public function get(Request $request){
        $user = User::where('remember_token', Request('token'))->first();
        if($user->lover_id == null){
            $notes = Note::where('id_user', $user->id)
            ->where('date', 'like', '%'.Request('date'))
            ->get();
            $all_notes = Note::where('id_couple', $user->lover_id)->get();

            return response()->json(['notes'=> $notes, 'allNotes'=> $all_notes, 'user'=> $user]);
        }
        $user_lover = User::where('lover_id', $user->lover_id)
        ->where('id', '!=', $user->id)
        ->first();

        $notes = Note::where('id_couple', $user->lover_id)
        ->where('date', 'like', '%'.Request('date'))
        ->get();

        $all_notes = Note::where('id_couple', $user->lover_id)->get();

        return response()->json(['notes'=> $notes, 'allNotes'=> $all_notes, 'user'=> $user, 'userLover' => $user_lover]);
    }

    public function deleteNote(Request $request){
        $note = Note::where('id', Request('id'))->first();

        $note->delete();

        return response()->json(['note' => $note, 'message' => 'Votre note a bien été supprimer']);
    }
}
