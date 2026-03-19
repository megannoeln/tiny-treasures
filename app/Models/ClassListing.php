<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassListing extends Model
{
    /** @use HasFactory<\Database\Factories\ClassListingFactory> */
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'title',
        'starts_at',
        'location',
        'capacity',
        'sold_out',
        'description',
        'flyer_path',
        'price',
        'deposit',
        'charity_link',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'capacity' => 'integer',
        'sold_out' => 'boolean',
        'price' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    public $timestamps = false;

    public function attendees()
    {
        return $this->hasMany(ClassAttendee::class);
    }

    public function remainingSeats(): ?int
    {
        if ($this->sold_out) {
            return 0;
        }

        if ($this->capacity === null) {
            return null;
        }

        return max(0, $this->capacity - $this->attendees()->count());
    }

}
