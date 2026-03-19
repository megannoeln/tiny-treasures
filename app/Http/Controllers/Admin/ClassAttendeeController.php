<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassListing;

class ClassAttendeeController extends Controller
{
    public function index(ClassListing $classListing)
    {
        $attendees = $classListing->attendees()->orderByDesc('created_at')->paginate(50);

        return view('admin.classes.attendees', compact('classListing', 'attendees'));
    }
}

