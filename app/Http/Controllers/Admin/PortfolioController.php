<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Support\UniqueSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $artworks = Artwork::query()
            ->where('is_for_sale', false)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.portfolio.index', compact('artworks'));
    }

    public function create()
    {
        return view('admin.portfolio.form', ['artwork' => new Artwork()]);
    }

    public function store(StoreArtworkRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = UniqueSlug::make(Artwork::class, $data['title']);

        unset($data['price'], $data['is_for_sale'], $data['is_sold'], $data['year'], $data['sort_order']);
        $data['is_for_sale'] = false;
        $data['is_sold'] = false;
        $data['price_cents'] = null;
        $data['year'] = null;
        $data['sort_order'] = 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->storePublicly('artworks', ['disk' => 'public']);
        }

        Artwork::create($data);

        return redirect()->route('admin.portfolio.index')->with('status', 'Portfolio item created.');
    }

    public function edit(Artwork $portfolio)
    {
        abort_if($portfolio->is_for_sale, 404);

        return view('admin.portfolio.form', ['artwork' => $portfolio]);
    }

    public function update(UpdateArtworkRequest $request, Artwork $portfolio)
    {
        abort_if($portfolio->is_for_sale, 404);

        $data = $request->validated();
        unset($data['slug']);

        unset($data['price'], $data['is_for_sale'], $data['is_sold'], $data['year'], $data['sort_order']);
        $data['is_for_sale'] = false;
        $data['is_sold'] = false;
        $data['price_cents'] = null;
        $data['year'] = null;
        $data['sort_order'] = 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->storePublicly('artworks', ['disk' => 'public']);

            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
        } elseif ($request->boolean('remove_image')) {
            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
            $data['image_path'] = null;
        } else {
            unset($data['image_path']);
        }

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')->with('status', 'Portfolio item updated.');
    }

    public function destroy(Request $request, Artwork $portfolio)
    {
        abort_if($portfolio->is_for_sale, 404);

        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')->with('status', 'Portfolio item deleted.');
    }
}
