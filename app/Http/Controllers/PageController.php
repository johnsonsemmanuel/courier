<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function personal()
    {
        return view('pages.personal');
    }

    public function business()
    {
        return view('pages.business');
    }

    public function loans()
    {
        return view('pages.loans');
    }

    public function investments()
    {
        return view('pages.investments');
    }

    public function support()
    {
        return view('pages.support');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // In production, send email to support team
        // For now, just return success

        return back()->with('success', 'Thank you for contacting us! We will respond within 24 hours.');
    }
}
