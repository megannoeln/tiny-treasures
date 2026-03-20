<?php

namespace App\Http\Controllers;

use App\Models\Artwork;

class PortfolioController extends Controller
{
    public function index()
    {
        $artworks = Artwork::query()
            ->where('is_for_sale', false)
            ->orderByDesc('created_at')
            ->paginate(24);

        return view('portfolio.index', compact('artworks'));
    }

    public function show(Artwork $artwork)
    {
        abort_if($artwork->is_for_sale, 404);

        return view('portfolio.show', compact('artwork'));
    }
}
