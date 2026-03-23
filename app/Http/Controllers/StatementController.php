<?php

namespace App\Http\Controllers;

use App\Services\PdfService;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        return view('statements.index');
    }

    public function download(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        return $this->pdfService->generateStatement(
            auth()->user(),
            $request->start_date,
            $request->end_date
        );
    }

    public function downloadReceipt($transactionId)
    {
        $transaction = auth()->user()->accounts->first()->transactions()->findOrFail($transactionId);
        
        return $this->pdfService->generateReceipt($transaction);
    }
}
