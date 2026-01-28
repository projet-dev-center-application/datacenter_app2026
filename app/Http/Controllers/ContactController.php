<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ContactController extends Controller
{
    // Afficher la page de contact
    public function show()
    {
        return view('contact');
    }

    
    public function submit(Request $request)
    {
        // Validation des données
        $request->validate([
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
        ]);
        $userId = Auth::check() ? Auth::id() : 1; 
        $description = $request->message;
        
        if (!Auth::check()) {
            $description .= "\n\n--- Message envoyé par un invité (" . $request->email . ") ---";
        }

        
        DB::table('issues')->insert([
            'title'       => $request->subject,
            'description' => $description,
            'type'        => 'question', // Type 'question' pour le formulaire de contact
            'status'      => 'open',
            'priority'    => 'low',
            'created_by'  => $userId,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'Votre message a bien été envoyé. Notre équipe technique vous répondra sous peu.');
    }
}