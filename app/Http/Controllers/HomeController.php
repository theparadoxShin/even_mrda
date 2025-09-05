<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SliderImage;
use App\Models\MusicTrack;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les images du carrousel
        $sliderImages = SliderImage::active()->ordered()->get();

        // Récupérer la musique de fond (For Unto Us de Haendel)
        $backgroundMusic = MusicTrack::background()->active()->first();

        // Récupérer les prochains événements
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        // Récupérer quelques statistiques pour enrichir la page d'accueil
        $stats = [
            'total_events' => max(Event::count(), 12),
            'total_participants' => Registration::where('payment_status', 'paye')->count(),
            'years_experience' => date('Y') - 2017,
            'member' => 40
        ];

        return view('welcome', compact('sliderImages', 'backgroundMusic', 'upcomingEvents', 'stats'));
    }

    public function success()
    {
        return view('success');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'g-recaptcha-response' => 'required',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'subject.required' => 'Le sujet est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
            'g-recaptcha-response.required' => 'Veuillez cocher la case reCAPTCHA pour prouver que vous n\'êtes pas un robot.',
        ]);

        // Vérifier le reCAPTCHA côté serveur
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => 'La vérification reCAPTCHA a échoué. Veuillez réessayer.']);
        }

        try {
            // Envoyer l'email de contact
            Mail::to('contact@cmrda-montreal.com')->send(new ContactMessage($request->all()));

            return redirect()->route('contact.index')
                ->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');

        } catch (\Exception $e) {
            \Log::error('Erreur envoi email contact: ' . $e->getMessage());
            return redirect()->route('contact.index')
                ->with('error', 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.');
        }
    }
}
