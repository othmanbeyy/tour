<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Booking extends Model
{
    protected $fillable = [
        'tour_id', 'safari_id', 'first_name', 'last_name', 
        'email', 'phone', 'country', 'special_requests', 
        'number_of_tourists', 'children_count', 'booking_date', 'status'
    ];

    protected $attributes = [
        'status' => 'pending',
        'children_count' => 0,
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function safari()
    {
        return $this->belongsTo(Safari::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $hasTour = ! empty($model->tour_id);
            $hasSafari = ! empty($model->safari_id);

            if (! $hasTour && ! $hasSafari) {
                throw ValidationException::withMessages([
                    'tour_id' => 'Please select either a Tour or a Safari.',
                ]);
            }

            if ($hasTour && $hasSafari) {
                throw ValidationException::withMessages([
                    'tour_id' => 'Please select only one: Tour or Safari, not both.',
                ]);
            }
        });
    }
}
