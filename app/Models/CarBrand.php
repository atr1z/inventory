<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the car models for this car brand.
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }

    /**
     * Get the auto parts for this car brand.
     */
    public function autoParts()
    {
        return $this->hasMany(AutoPart::class);
    }
}
