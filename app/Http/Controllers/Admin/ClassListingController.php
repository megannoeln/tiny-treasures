<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassListingRequest;
use App\Http\Requests\UpdateClassListingRequest;
use App\Models\ClassListing;
use Illuminate\Support\Facades\Storage;

class ClassListingController extends Controller
{
    public function index()
    {
        $classes = ClassListing::query()
            ->orderByDesc('starts_at')
            ->paginate(20);

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.form', ['classListing' => new ClassListing()]);
    }

    public function store(StoreClassListingRequest $request)
    {
        $data = $request->validated();
        $data['sold_out'] = $request->boolean('sold_out');

        if ($request->hasFile('flyer')) {
            $data['flyer_path'] = $request->file('flyer')->storePublicly('class-flyers', ['disk' => 'public']);
        }

        ClassListing::create($data);

        return redirect()->route('admin.classes.index')->with('status', 'Class created.');
    }

    public function edit(ClassListing $classListing)
    {
        return view('admin.classes.form', compact('classListing'));
    }

    public function update(UpdateClassListingRequest $request, ClassListing $classListing)
    {
        $data = $request->validated();
        $data['sold_out'] = $request->boolean('sold_out');

        if ($request->hasFile('flyer')) {
            $data['flyer_path'] = $request->file('flyer')->storePublicly('class-flyers', ['disk' => 'public']);

            if ($classListing->flyer_path) {
                Storage::disk('public')->delete($classListing->flyer_path);
            }
        } elseif ($request->boolean('remove_flyer')) {
            if ($classListing->flyer_path) {
                Storage::disk('public')->delete($classListing->flyer_path);
            }
            $data['flyer_path'] = null;
        } else {
            unset($data['flyer_path']);
        }

        $classListing->update($data);

        return redirect()->route('admin.classes.index')->with('status', 'Class updated.');
    }

    public function destroy(ClassListing $classListing)
    {
        $classListing->delete();

        return redirect()->route('admin.classes.index')->with('status', 'Class deleted.');
    }

}
