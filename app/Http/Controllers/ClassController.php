<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Models\ClassListing;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassListing::query()
            ->orderBy('starts_at')
            ->paginate(20);

        return view('classes.index', compact('classes'));
    }

    public function show(ClassListing $classListing)
    {
        return view('classes.show', compact('classListing'));
    }

    public function signup(Request $request, ClassListing $classListing)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200'],
            'attendees' => ['required', 'integer', 'min:1', 'max:20'],
            'questions' =>['nullable', 'string', 'max:200'],
            'website' => ['nullable', 'string', 'max:200'], // honeypot
        ]);

        if (($validated['website'] ?? null) !== null && $validated['website'] !== '') {
            return back()->with('status', 'Thanks! We received your request.');
        }

        if ($classListing->sold_out) {
            return back()->withErrors(['email' => 'This class is sold out.']);
        }

        $inquiry = Inquiry::create([
            'type' => 'class',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => trim(implode("\n\n", array_filter([
                'Class: '.$classListing->title,
                'When: '.$classListing->starts_at?->format('M j, Y · g:ia'),
                $classListing->location ? 'Where: '.$classListing->location : null,
                'Attendees: '.$validated['attendees'],
                'Questions: '.$validated['questions'],
            ]))),
        ]);

        $to = config('brand.inquiry_to_email') ?: config('mail.from.address');
        if ($to) {
            Mail::to($to)->send(new InquiryReceived($inquiry));
        }

        return back()->with('status', 'Thanks! Tiny Treasures will follow up by email to confirm your spot and handle the deposit.');
    }
}
