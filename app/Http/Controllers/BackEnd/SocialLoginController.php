<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Vérifier si l'utilisateur existe déjà
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'firstname' => $this->extractFirstName($socialUser->getName()),
                    'lastname' => $this->extractLastName($socialUser->getName()),
                    'username' => $socialUser->getNickname() ?? $this->generateUsername($socialUser->getEmail()),
                    'email' => $socialUser->getEmail(),
                    'provider_id' => $socialUser->getId(),
                    'provider' => $provider,
                    'password' => Hash::make(uniqid()), // Mot de passe aléatoire
                    'email_verified_at' => now(), // Email vérifié automatiquement
                ]);
            } elseif (empty($user->provider_id)) {
                // Mettre à jour le provider si l'utilisateur existe déjà
                $user->update([
                    'provider_id' => $socialUser->getId(),
                    'provider' => $provider,
                ]);
            }

            // Connecter l'utilisateur
            Auth::login($user, true);

            return redirect()->intended('/');
            
        } catch (\Exception $e) {
            return redirect()->route('frontend.register')
                ->with('error', 'Échec de la connexion avec ' . ucfirst($provider));
        }
    }

    private function extractFirstName($fullName)
    {
        $names = explode(' ', $fullName);
        return $names[0] ?? 'Prénom';
    }

    private function extractLastName($fullName)
    {
        $names = explode(' ', $fullName);
        return $names[1] ?? 'Nom';
    }

    private function generateUsername($email)
    {
        return explode('@', $email)[0] . '_' . uniqid();
    }
}