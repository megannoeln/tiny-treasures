<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Support\UniqueSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopItemController extends Controller
{
    public function index()
    {
        $items = Artwork::query()
            ->where('is_for_sale', true)
            ->orderBy('is_sold')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.shop.index', compact('items'));
    }

    public function create()
    {
        return view('admin.shop.form', ['item' => new Artwork()]);
    }

    public function store(StoreArtworkRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = UniqueSlug::make(Artwork::class, $data['title']);

        unset($data['is_for_sale'], $data['is_sold'], $data['year'], $data['sort_order']);
        $data['is_for_sale'] = true;
        $data['is_sold'] = $request->boolean('is_sold');
        $data['price_cents'] = $this->priceToCents($data['price'] ?? null);
        unset($data['price']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->storePublicly('artworks', ['disk' => 'public']);
        }

        Artwork::create($data);

        return redirect()->route('admin.shop.index')->with('status', 'Shop item created.');
    }

    public function edit(Artwork $shop)
    {
        abort_unless($shop->is_for_sale, 404);

        return view('admin.shop.form', ['item' => $shop]);
    }

    public function update(UpdateArtworkRequest $request, Artwork $shop)
    {
        abort_unless($shop->is_for_sale, 404);

        $data = $request->validated();
        unset($data['slug']);

        unset($data['is_for_sale'], $data['is_sold'], $data['year'], $data['sort_order']);
        $data['is_for_sale'] = true;
        $data['is_sold'] = $request->boolean('is_sold');
        $data['price_cents'] = $this->priceToCents($data['price'] ?? null);
        unset($data['price']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->storePublicly('artworks', ['disk' => 'public']);

            if ($shop->image_path) {
                Storage::disk('public')->delete($shop->image_path);
            }
        } elseif ($request->boolean('remove_image')) {
            if ($shop->image_path) {
                Storage::disk('public')->delete($shop->image_path);
            }
            $data['image_path'] = null;
        } else {
            unset($data['image_path']);
        }

        $shop->update($data);

        return redirect()->route('admin.shop.index')->with('status', 'Shop item updated.');
    }

    public function destroy(Request $request, Artwork $shop)
    {
        abort_unless($shop->is_for_sale, 404);

        $shop->delete();

        return redirect()->route('admin.shop.index')->with('status', 'Shop item deleted.');
    }

    private function priceToCents(mixed $price): ?int
    {
        if ($price === null || $price === '') {
            return null;
        }

        return (int) round(((float) $price) * 100);
    }
}
