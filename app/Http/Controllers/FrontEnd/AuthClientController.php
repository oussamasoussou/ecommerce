<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\SousCategorie;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthClientController extends Controller
{
    // Constructeur pour partager les catégories avec toutes les vues
    public function __construct()
    {
        // Partage de TOUTES les catégories et sous-catégories
        $allCategories = Category::with(['sousCategories'])->get();
        $allSousCategories = SousCategorie::with('category')->get();

        view()->share([
            'categoriesMenu' => $allCategories,
            'allSousCategories' => $allSousCategories
        ]);
    }

    public function showLoginForm()
    {
        return view('front-end.auth.login');
    }

    // Dans la méthode login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Synchroniser le panier
            Cart::syncCart(Auth::id());

            // Vérifier s'il y avait des articles dans le panier
            $cartCount = Cart::where('session_id', session()->getId())->count();

            // Message personnalisé
            $message = 'Connexion réussie !';
            if ($cartCount > 0) {
                $message = 'Connexion réussie ! Votre panier a été synchronisé.';
            }

            // Mettre à jour la dernière connexion
            Auth::user()->update(['last_login_at' => now()]);

            return redirect()->intended('/')->with('success', $message);
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->withInput();
    }

    // Dans la méthode register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Créer l'utilisateur avec role_id = 3
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Client
            'is_active' => true,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        // Connecter automatiquement l'utilisateur après l'inscription
        Auth::login($user);

        // Synchroniser le panier après inscription
        $sessionId = session()->getId();
        $cartCount = Cart::where('session_id', $sessionId)->count();
        Cart::syncCart($user->id);

        // Message personnalisé
        $message = 'Votre compte a été créé avec succès!';
        if ($cartCount > 0) {
            $message = 'Votre compte a été créé avec succès! Votre panier a été synchronisé.';
        }

        return redirect('/')->with('success', $message);
    }
    public function showRegisterForm()
    {
        return view('front-end.auth.register');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}