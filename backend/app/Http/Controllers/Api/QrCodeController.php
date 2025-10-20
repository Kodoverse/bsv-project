<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QR;

class QrCodeController extends Controller
{
    /**
     * Generate a QR code for a purchase
     */
    public function generate(Request $request, $purchaseId)
    {
        $purchase = Purchase::findOrFail($purchaseId);
        $imagePath = public_path('storage/product/biblioteca_logo.png');


        // Controllo che l'utente sia proprietario della purchase
        if ($purchase->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Controlla se già esiste un QR per questa purchase
        $existingQr = QrCode::where('purchase_id', $purchase->id)->first();
        if ($existingQr) {
            return response()->json([
                'message' => 'QR already generated',
                'qr_code' => $existingQr
            ]);
        }

        // Genera un codice unico per il QR
        $code = Str::uuid()->toString(); // oppure Str::random(20);

        // Salva il QR nel database
        $qr = QrCode::create([
            'purchase_id' => $purchase->id,
            'code' => $code,
            'is_used' => false,
        ]);

        // Genera l'immagine QR (base64)
        $qrSvg = QR::format('png')
            ->size(300)
            ->margin(2)
            ->merge($imagePath, 0.5, true)
            ->errorCorrection('H')
            ->generate($code);

        return response()->json([
            'message' => 'QR code generated',
            'qr_code' => $qr,
            'qr_image_base64' => 'data:image/png+xml;base64,' . base64_encode($qrSvg)
        ]);
    }
}
