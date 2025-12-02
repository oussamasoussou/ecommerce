<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BackEnd\OrderController;

class CheckoutController extends Controller
{
    private const TAUX_TVA = 0.20;

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
    }

    // Page checkout (récupère panier depuis session)
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front-end.checkout.index', compact('cart'));
    }

    // Création PaymentIntent et renvoie client_secret
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'billing.nom' => 'required|string|max:255',
            'billing.adresse' => 'required|string',
            'billing.telephone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Panier vide'], 400);
        }

        // Calcul total
        $amount = 0;
        foreach ($cart as $item) {
            $amount += $item['price'] * $item['qty'];
        }

        // Stripe veut les montants en cents
        $amountCents = (int) round($amount * 100);

        $intent = PaymentIntent::create([
            'amount' => $amountCents,
            'currency' => 'eur',
            'metadata' => [
                'user_id' => Auth::id() ?? 'guest',
            ],
        ]);

        // Sauvegarder info billing temporaire en session
        session()->put('checkout_billing', $request->billing);

        return response()->json([
            'clientSecret' => $intent->client_secret,
            'paymentIntentId' => $intent->id,
        ]);
    }

    // Webhook minimal ou callback après confirmation côté client
    // Ici on suppose que le front appelle /checkout/confirm après payment succeeded with paymentIntentId
    public function confirm(Request $request, OrderController $orderController)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $paymentIntentId = $request->payment_intent_id;
        // On peut fetch le paymentIntent et vérifier son statut
        $pi = PaymentIntent::retrieve($paymentIntentId);

        if ($pi->status !== 'succeeded') {
            return response()->json(['error' => 'Paiement non confirmé'], 400);
        }

        // Récupère le panier et billing depuis session
        $cart = session()->get('cart', []);
        $billing = session()->get('checkout_billing', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Panier vide'], 400);
        }

        // Créer commande (utilise OrderController::createFromCart)
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        $billing['stripe_payment_id'] = $paymentIntentId;

        // Crée commande et décrémente stocks
        $order = $orderController->createFromCart($userId, $cart, $billing);

        // Vider le panier
        session()->forget('cart');
        session()->forget('checkout_billing');

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
}
