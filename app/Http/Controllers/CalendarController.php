<?php

namespace App\Http\Controllers;

use App\Models\ClassListing;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->string('month')->toString();
        $monthStart = CarbonImmutable::now()->startOfMonth();
        if ($month && preg_match('/^\\d{4}-\\d{2}$/', $month) === 1) {
            try {
                $monthStart = CarbonImmutable::createFromFormat('Y-m', $month)->startOfMonth();
            } catch (\Throwable) {
                // Ignore invalid month input
            }
        }

        $monthEnd = $monthStart->endOfMonth();

        $events = Event::query()
            ->whereBetween('starts_at', [$monthStart, $monthEnd->endOfDay()])
            ->orderBy('starts_at')
            ->get();

        $classes = ClassListing::query()
            ->whereBetween('starts_at', [$monthStart, $monthEnd->endOfDay()])
            ->orderBy('starts_at')
            ->get();

        $itemsByDate = [];
        foreach ($events as $event) {
            $itemsByDate[$event->starts_at->toDateString()][] = [
                'type' => 'event',
                'title' => $event->name,
                'time' => $event->starts_at->format('g:ia'),
                'url' => $event->external_link ?: '#',
            ];
        }
        foreach ($classes as $class) {
            $itemsByDate[$class->starts_at->toDateString()][] = [
                'type' => 'class',
                'title' => $class->title,
                'time' => $class->starts_at->format('g:ia'),
                'url' => route('classes.show', $class),
            ];
        }

        $calendar = $this->buildMonthGrid($monthStart, $itemsByDate);

        $upcoming = collect()
            ->merge(Event::query()->where('starts_at', '>=', now()->subHours(6))->orderBy('starts_at')->take(20)->get()->map(function ($e) {
                return [
                    'type' => 'event',
                    'title' => $e->name,
                    'starts_at' => $e->starts_at,
                    'location' => $e->location,
                    'url' => $e->external_link ?: '#',
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

        return view('calendar', [
            'monthStart' => $monthStart,
            'calendar' => $calendar,
            'upcoming' => $upcoming,
        ]);
    }

    private function buildMonthGrid(CarbonImmutable $monthStart, array $itemsByDate): array
    {
        $first = $monthStart->startOfWeek(CarbonImmutable::SUNDAY);
        $last = $monthStart->endOfMonth()->endOfWeek(CarbonImmutable::SATURDAY);

        $days = [];
        for ($d = $first; $d->lte($last); $d = $d->addDay()) {
            $days[] = [
                'date' => $d,
                'in_month' => $d->month === $monthStart->month,
                'items' => $itemsByDate[$d->toDateString()] ?? [],
            ];
        }

        return array_chunk($days, 7);
    }
}
