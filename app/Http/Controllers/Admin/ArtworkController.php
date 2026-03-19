<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Support\UniqueSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = Artwork::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.artworks.index', compact('artworks'));
    }

    public function create()
    {
        return view('admin.artworks.form', ['artwork' => new Artwork()]);
    }

    public function store(StoreArtworkRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: UniqueSlug::make(Artwork::class, $data['title']);

        $data['is_for_sale'] = $request->boolean('is_for_sale');
        $data['is_sold'] = $request->boolean('is_sold');
        $data['price_cents'] = $this->priceToCents($data['price'] ?? null);
        unset($data['price']);

        if (! $data['is_for_sale']) {
            $data['is_sold'] = false;
            $data['price_cents'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->storePublicly('artworks', ['disk' => 'public']);
        }

        Artwork::create($data);

        return redirect()->route('admin.artworks.index')->with('status', 'Artwork created.');
    }

    public function edit(Artwork $artwork)
    {
        return view('admin.artworks.form', compact('artwork'));
    }

    public function update(UpdateArtworkRequest $request, Artwork $artwork)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: UniqueSlug::make(Artwork::class, $data['title'], $artwork->id);

        $data['is_for_sale'] = $request->boolean('is_for_sale');
        $data['is_sold'] = $request->boolean('is_sold');
        $data['price_cents'] = $this->priceToCents($data['price'] ?? null);
        unset($data['price']);

        if (! $data['is_for_sale']) {
            $data['is_sold'] = false;
            $data['price_cents'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->storePublicly('artworks', ['disk' => 'public']);

            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
        } elseif ($request->boolean('remove_image')) {
            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            $data['image_path'] = null;
        } else {
            unset($data['image_path']);
        }

        $artwork->update($data);

        return redirect()->route('admin.artworks.index')->with('status', 'Artwork updated.');
    }

    private function priceToCents(mixed $price): ?int
    {
        if ($price === null || $price === '') {
            return null;
        }

        return (int) round(((float) $price) * 100);
    }

    public function destroy(Request $request, Artwork $artwork)
    {
        $artwork->delete();

        return redirect()->route('admin.artworks.index')->with('status', 'Artwork deleted.');
    }
}
