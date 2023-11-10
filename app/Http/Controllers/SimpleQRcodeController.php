<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SimpleQRcodeController extends Controller
{
    //

    public function generateQRcode () {

    	# 2. On génère un QR code de taille 200 x 200 px
    	$qrcode = Qrcode::size(200)->generate("https://akilischool.com/cours/laravel-generer-un-qr-code-avec-simple-qrcode");

    	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('simple-qrcode', compact('qrcode'));
    }
}
