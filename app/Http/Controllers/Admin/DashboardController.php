<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    private function generateEventQR(Event $event)
    {
        $url = route('event.register', $event->id);
        $qrCodeName = 'qr-event-' . $event->id . '.png';

        QrCode::format('png')->size(300)->generate($url, storage_path('app/public/qrcodes/' . $qrCodeName));

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
        $message = "Inscription à l'événement: {$event->name}\nLien d'inscription: {$url}";
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
        $data = json_encode([
            'registration_id' => $registration->id,
            'name' => $registration->full_name,
            'event' => $registration->event->name,
            'status' => 'paye'
        ]);

        $qrCodeName = 'confirmation-' . $registration->id . '.png';
        QrCode::format('png')->size(300)->generate($data, storage_path('app/public/confirmations/' . $qrCodeName));

        $registration->update(['confirmation_qr' => $qrCodeName]);
    }

    private function sendConfirmationEmail(Registration $registration)
    {
        // Implémentation de l'envoi d'email sera dans la section Mail
    }

}
