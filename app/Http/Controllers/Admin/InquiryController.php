<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::query()
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }
}
