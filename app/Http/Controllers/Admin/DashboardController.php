<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class DashboardController extends Controller
{
    public function index()
    {
        $events = Event::with('registrations')->get();
        return view('admin.dashboard', compact('events'));
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'event_date' => 'required|date',
        ]);

        $event = Event::create($request->all());

        // Générer le QR code
        $this->generateEventQR($event);

        return redirect()->back()->with('success', 'Événement créé avec succès!');
    }

    private function generateEventQR(Event $event){
        // Générer l'URL d'inscription
        $url = route('event.register', $event->id);
        $qrCodeName = 'qr-event-' . $event->id . '.svg';

        // Créer le dossier s'il n'existe pas
        $qrPath = storage_path('app/public/qrcodes');
        if (!file_exists($qrPath)) {
            mkdir($qrPath, 0755, true);
        }

        // Utiliser BaconQrCode avec SVG pour créer le QR code
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($url);

        file_put_contents($qrPath . '/' . $qrCodeName, $qrCode);

        $event->update(['qr_code' => $qrCodeName]);
    }

    public function downloadQR(Event $event)
    {
        $path = storage_path('app/public/qrcodes/' . $event->qr_code);

        if (file_exists($path)) {
            return response()->download($path);
        }

        return redirect()->back()->with('error', 'QR Code non trouvé.');
    }

    public function getWhatsAppLink(Event $event)
    {
        $url = route('event.register', $event->id);
        $message = "Inscription à l'événement: {$event->name}\nLien d'inscription: ".$url;
        $whatsappUrl = "https://wa.me/?text=" . urlencode($message);

        return response()->json(['url' => $whatsappUrl]);
    }

    public function eventRegistrations(Event $event)
    {
        $registrations = $event->registrations()->orderBy('created_at', 'desc')->get();
        return view('admin.registrations', compact('event', 'registrations'));
    }

    public function updatePaymentStatus(Registration $registration)
    {
        $registration->update(['payment_status' => 'paye']);

        // Générer QR de confirmation
        $this->generateConfirmationQR($registration);

        // Envoyer email de confirmation

        $this->sendConfirmationEmail($registration);

        return redirect()->back()->with('success', 'Statut de paiement mis à jour!');
    }

    private function generateConfirmationQR(Registration $registration)
    {
        // Préparer les données de confirmation au format JSON
        $data = json_encode([
            'registration_id' => $registration->id,
            'name' => $registration->full_name,
            'event' => $registration->event->name,
            'status' => 'paye'
        ]);

        // Générer le nom unique du fichier QR code
        $qrCodeName = 'confirmation-' . $registration->id . '.svg';

        // Créer le dossier confirmations s'il n'existe pas
        $qrPath = storage_path('app/public/confirmations');
        if (!file_exists($qrPath)) {
            mkdir($qrPath, 0755, true);
        }

        // Configurer le renderer BaconQrCode avec SVG (évite imagick)
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        // Créer le writer et générer le QR code
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($data);

        // Sauvegarder le fichier QR code
        file_put_contents($qrPath . '/' . $qrCodeName, $qrCode);

        // Mettre à jour la registration avec le nom du QR code
        $registration->update(['confirmation_qr' => $qrCodeName]);
    }

    private function sendConfirmationEmail(Registration $registration)
    {
        try {
            Mail::to($registration->email)->send(new PaymentConfirmation($registration));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email: ' . $e->getMessage());
        }
    }

}
