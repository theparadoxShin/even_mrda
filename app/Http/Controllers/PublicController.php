<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationConfirmation;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PublicController extends Controller
{
    public function showRegistrationForm(Event $event)
    {
        return view('public.register', compact('event'));
    }

    public function register(Request $request, Event $event)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $registration = Registration::create([
            'event_id' => $event->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Envoyer email de confirmation d'inscription
        try {
            Mail::to($registration->email)->send(new RegistrationConfirmation($registration));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email inscription: ' . $e->getMessage());
        }


        // Si l'événement est gratuit, on confirme directement l'inscription
        if ($event->price == 0) {
            $registration->update([
                'payment_status' => 'paye',
                'payment_id' => 'GRATUIT-' . time()
            ]);

            try {
                // Envoyer l'email de confirmation de paiement (même si c'est gratuit)
                Mail::to($registration->email)->send(new PaymentConfirmation($registration));
            } catch (\Exception $e) {
                Log::error('Erreur envoi email confirmation gratuit: ' . $e->getMessage());
            }

            return redirect()->route('success')->with([
                'success' => 'Votre inscription gratuite a été confirmée avec succès !',
                'event_name' => $event->name
            ]);
        }

        return redirect()->route('payment.form', $registration->id);
    }

    public function showPaymentForm(Registration $registration)
    {
        return view('public.payment', compact('registration'));
    }

    public function processPayment(Request $request, Registration $registration)
    {
        // Si l'événement est gratuit, on confirme directement
        if ($registration->event->price == 0) {
            $registration->update([
                'payment_status' => 'paye',
                'payment_id' => 'GRATUIT-' . time()
            ]);

            try {
                Mail::to($registration->email)->send(new PaymentConfirmation($registration));
            } catch (\Exception $e) {
                Log::error('Erreur envoi email confirmation gratuit: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Inscription gratuite confirmée avec succès !'
            ]);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $registration->event->price * 100, // En centimes
                'currency' => 'cad',
                'payment_method' => $request->payment_method,
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $registration->update([
                    'payment_id' => $paymentIntent->id,
                    'payment_status' => 'paye'
                ]);

                // Rediriger vers la page de succès
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('success')
                ]);
            }

            return response()->json(['error' => 'Paiement échoué']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
