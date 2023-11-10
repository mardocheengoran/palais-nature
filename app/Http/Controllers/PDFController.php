<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Illuminate\Http\Request;


class PDFController extends Controller
{

    public function generatePDF($code)
    {
        $record = Invoice::whereCode($code)->first();
        view()->shared('invoice', $record);
        // dd($record->toArray());

        $pdf = PDF::loadView('filament.pages.invoice.pdf',compact('record'));
        $options= new Options();
        $options->set('isRemoteEnabled', true);

        // return view('filament.pages.invoice.pdf',compact('record'));


         return $pdf->download('commande' . $code . '.pdf');
    }


}
