<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_brand_id',
        'model',
        'year',
        'image',
    ];

    /**
     * Get the auto parts for this car model.
     */
    public function autoParts()
    {
        return $this->hasMany(AutoPart::class);
    }

    /**
     * Get the car brand that this model belongs to.
     */
    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class);
    }
}
