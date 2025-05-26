<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmationMail;
use App\Models\ContactMessage;
use App\Mail\ContactMessageMail;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact/Index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if(!$request['email'] && !$request['phone']){
            $request->validate([
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
            ], [
                'phone' => 'The email or phone number is required',
                'email' => 'The email or phone number is required'
            ]);
        }

        // Store in DB
        ContactMessage::create($validated);

        // Send confirmation to user if they entered email
        if (!empty($validated['email'])) {
            Mail::to($validated['email'])->send(new ContactConfirmationMail($validated));
            // Send Email
            Mail::to($validated['email'])->queue(new ContactConfirmationMail($validated));
        }


        // return redirect()->back();
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Store in DB
        ContactMessage::create($validated);
        
        // Send confirmation to user if they entered email
        Mail::to($validated['email'])->send(new ContactConfirmationMail($validated));
        
        // Send Email
        Mail::to($validated['email'])->queue(new ContactConfirmationMail($validated));
        
        return response()->json($validated);
    }
}
