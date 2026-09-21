<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\ClassListing;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $featuredItems = Artwork::query()
            ->where('is_featured', true)
            ->where(function ($query) {
                $query
                    ->where('is_for_sale', false)
                    ->orWhere(function ($q) {
                        $q->where('is_for_sale', true)->where('is_sold', false);
                    });
            })
            ->orderByDesc('created_at')
            ->get();

        $upcomingEvents = Event::query()
            ->where('starts_at', '>=', now()->subHours(6))
            ->orderBy('starts_at')
            ->take(5)
            ->get();

        $upcomingClasses = ClassListing::query()
            ->where('starts_at', '>=', now())
            ->where('sold_out', false)
            ->orderBy('starts_at')
            ->take(5)
            ->get();

        $upcoming = collect()
            ->merge(Event::query()->where('starts_at', '>=', now()->subHours(6))->orderBy('starts_at')->take(20)->get()->map(function ($e) {
                return [
                    'type' => 'event',
                    'title' => $e->name,
                    'starts_at' => $e->starts_at,
                    'location' => $e->location,
                    'url' => $e->external_link,
                ];
            }))
            ->merge(ClassListing::query()->where('starts_at', '>=', now()->subHours(6))->orderBy('starts_at')->take(20)->get()->map(function ($c) {
                return [
                    'type' => 'class',
                    'title' => $c->title,
                    'starts_at' => $c->starts_at,
                    'location' => $c->location,
                    'url' => route('classes.show', $c),
                ];
            }))
            ->sortBy('starts_at')
            ->values();

        $contactType = $this->normalizeContactType($request->string('type')->toString());

        return view('home', compact(
            'featuredItems',
            'upcomingEvents',
            'upcomingClasses',
            'upcoming',
            'contactType',
        ));
    }

    private function normalizeContactType(?string $type): string
    {
        return in_array($type, ['commission', 'general'], true) ? $type : 'general';
    }
}
