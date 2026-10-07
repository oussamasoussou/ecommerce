<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SousCategorie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function __construct()
    {
        // Catégories pour le header (même pattern que les autres contrôleurs front)
        view()->share([
            'categoriesMenu' => Category::with(['sousCategories'])->get(),
            'allSousCategories' => SousCategorie::with('category')->get(),
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('front-end.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => [
                'required', 'string', 'max:20',
                // Le téléphone sert d'identifiant de connexion : unique, quel que soit le format
                function ($attribute, $value, $fail) use ($user) {
                    if (strlen(User::normalizePhone($value)) !== 8) {
                        $fail('Le numéro de téléphone doit contenir 8 chiffres (ex. 20 123 456).');
                    } elseif (User::findByPhone($value)->where('id', '!=', $user->id)->isNotEmpty()) {
                        $fail('Ce numéro de téléphone est déjà utilisé par un autre compte.');
                    }
                },
            ],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
        ]);

        $user->update($data);

        return redirect()->back()->with('success', 'Profil mis à jour.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Mot de passe changé.');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.produit')->orderBy('created_at', 'desc')->paginate(5);
        return view('front-end.account.orders', compact('orders'));
    }
}
