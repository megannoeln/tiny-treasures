<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAttendee extends Model
{
    /** @use HasFactory<\Database\Factories\ClassAttendeeFactory> */
    use HasFactory;

    protected $fillable = [
        'class_listing_id',
        'name',
        'email',
    ];

    public function classListing()
    {
        return $this->belongsTo(ClassListing::class);
    }
}

