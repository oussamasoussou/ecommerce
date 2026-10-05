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
            'login' => 'required|string|max:255',
            'password' => 'required|min:6',
        ], [
            'login.required' => 'Veuillez saisir votre email ou votre numéro de téléphone.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $login = trim($request->input('login'));
        $remember = $request->boolean('remember');

        // ID de session du visiteur, avant que regenerate() ne le change
        $guestSessionId = $request->session()->getId();

        // Email si le champ contient "@", sinon numéro de téléphone
        if (str_contains($login, '@')) {
            $authenticated = Auth::attempt(['email' => $login, 'password' => $request->password], $remember);
        } else {
            $authenticated = false;
            $matches = User::findByPhone($login);

            // Un seul compte doit correspondre à ce numéro
            if ($matches->count() === 1 && Hash::check($request->password, $matches->first()->password)) {
                Auth::login($matches->first(), $remember);
                $authenticated = true;
            }
        }

        if ($authenticated) {
            $request->session()->regenerate();

            // Vérifier s'il y avait des articles dans le panier du visiteur
            $cartCount = Cart::where('session_id', $guestSessionId)->whereNull('user_id')->count();

            // Synchroniser le panier
            Cart::syncCart(Auth::id(), $guestSessionId);
            $request->session()->put('cart_synced', true);

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
            'login' => 'Les identifiants ne correspondent pas.',
        ])->withInput($request->except('password'));
    }

    // Dans la méthode register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => [
                'required', 'string', 'max:20',
                // Le téléphone sert d'identifiant de connexion : il doit être unique, quel que soit le format
                function ($attribute, $value, $fail) {
                    if (strlen(User::normalizePhone($value)) < 8) {
                        $fail('Le numéro de téléphone n\'est pas valide.');
                    } elseif (User::findByPhone($value)->isNotEmpty()) {
                        $fail('Ce numéro de téléphone est déjà utilisé par un autre compte.');
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
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
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Client
            'is_active' => true,
            'address' => $request->address,
            'city' => $request->city,
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

        return redirect()->intended('/')->with('success', $message);
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