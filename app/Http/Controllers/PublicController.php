<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
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

        return redirect()->route('payment.form', $registration->id);
    }

    public function showPaymentForm(Registration $registration)
    {
        return view('public.payment', compact('registration'));
    }

    public function processPayment(Request $request, Registration $registration)
    {
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

                return response()->json(['success' => true]);
            }

            return response()->json(['error' => 'Paiement échoué']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
