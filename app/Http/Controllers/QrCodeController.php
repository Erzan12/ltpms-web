<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Livestock;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    public function generate($id)
    {
        $livestock = Livestock::findOrFail($id);

        $fileName = $livestock->tag . '.png';
        $filePath = 'public/qr-codes/' . $fileName;

        // Generate QR code as string
        $qrCode = QrCode::format('svg')
            ->size(200)
            ->generate($livestock->tag);

        // Save to storage
        Storage::put($filePath, $qrCode);

        if (!Storage::exists($filePath)) {
            $qrCode = QrCode::format('png')->size(200)->generate($livestock->tag);
            Storage::put($filePath, $qrCode);
        }

        return response()->json([
            'success' => true,
            'qrCode' => 'data:image/svg+xml;base64,' . base64_encode($qrCode)
        ]);
    }
}
