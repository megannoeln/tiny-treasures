<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'in:commission,general'],
            'name' => ['nullable', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'string', 'max:200'], // honeypot
        ]);

        if ($validator->fails()) {
            return redirect()
                ->to(route('home').'#contact')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        if (($validated['website'] ?? null) !== null && $validated['website'] !== '') {
            return redirect()->route('home')->with('status', 'Thanks! Your message was sent.');
        }

        $inquiry = Inquiry::create([
            'type' => $validated['type'],
            'name' => $validated['name'] ?: null,
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        $to = config('brand.inquiry_to_email') ?: config('mail.from.address');
        if ($to) {
            Mail::to($to)->send(new InquiryReceived($inquiry));
        }

        return redirect()->route('home')->with('status', 'Thanks! Your message was sent.');
    }
}
