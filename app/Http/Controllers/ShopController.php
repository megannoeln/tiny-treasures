<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Models\Artwork;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index()
    {
        $items = Artwork::query()
            ->where('is_for_sale', true)
            ->orderBy('is_sold')
            ->orderByDesc('created_at')
            ->paginate(24);

        return view('shop.index', compact('items'));
    }

    public function show(Artwork $artwork)
    {
        abort_unless($artwork->is_for_sale, 404);

        return view('shop.show', ['item' => $artwork]);
    }

    public function requestPurchase(Request $request, Artwork $artwork)
    {
        abort_unless($artwork->is_for_sale && ! $artwork->is_sold, 404);

        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200'],
            'website' => ['nullable', 'string', 'max:200'], // honeypot
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('shop.show', $artwork)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        if (($validated['website'] ?? null) !== null && $validated['website'] !== '') {
            return redirect()->route('shop.show', $artwork)->with('status', 'Thanks! Your request was sent.');
        }

        $inquiry = Inquiry::create([
            'artwork_id' => $artwork->id,
            'type' => 'purchase',
            'name' => $validated['name'] ?: null,
            'email' => $validated['email'],
            'message' => trim(implode("\n\n", array_filter([
                'Purchase request for: '.$artwork->title,
                $artwork->price_cents !== null ? 'Price: $'.number_format($artwork->price_cents / 100, 2) : 'Price: on request',
                $artwork->description ? 'Item description: '.$artwork->description : null,
            ]))),
        ]);

        $to = config('brand.inquiry_to_email') ?: config('mail.from.address');
        if ($to) {
            $inquiry->load('artwork');
            Mail::to($to)->send(new InquiryReceived($inquiry));
        }

        return redirect()->route('shop.show', $artwork)->with('status', 'Thanks! We’ll email you back soon.');
    }
}
