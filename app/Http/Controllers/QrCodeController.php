<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Livestock;

class QrCodeController extends Controller
{
    public function generate($id)
    {
        $livestock = Livestock::findOrFail($id);
        $qrCodePath = 'public/qr-codes/' . $livestock->tag . '.png';
    
        // Generate the QR code
        QrCode::format('png')->size(200)->generate($livestock->tag, storage_path('app/' . $qrCodePath));
    
        // Return a JSON response with the path to the QR code
        return response()->json([
            'success' => true,
            'qrCodeUrl' => asset('storage/qr-codes/' . $livestock->tag . '.png'),
        ]);
    }
}
