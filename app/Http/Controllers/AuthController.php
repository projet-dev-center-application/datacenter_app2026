<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // Afficher le formulaire de login
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    // Traiter le login
    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        
        // Tentative d'authentification
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return response()->json([
                'success' => true,
                'redirect' => '/dashboard'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Identifiants incorrects'
        ], 401);
    }
    
    // Traiter l'inscription
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:50',
            'password' => 'required|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'departement' => $request->department,
            'password' => Hash::make($request->password),
            'role' => 'user', // Par défaut
            'is_active' => true,
        ]);
        
        // Connecter automatiquement
        Auth::login($user);
        
        return response()->json([
            'success' => true,
            'message' => 'Compte créé avec succès',
            'redirect' => '/dashboard'
        ]);
    }
    
    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}