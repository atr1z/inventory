<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoPart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'brand',
        'quantity',
        'purchase_price',
        'sale_price',
        'car_brand_id',
        'car_model_id',
        'purchase_invoice',
        'provider',
        'image',
        'in_stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    /**
     * Get the car model that this auto part belongs to.
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the car brand that this auto part belongs to.
     */
    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    /**
     * Set the purchase price and automatically calculate the sale price with a 10% markup.
     *
     * @param float $value
     * @return void
     */
    public function setPurchasePriceAttribute($value)
    {
        $this->attributes['purchase_price'] = $value;
        $this->attributes['sale_price'] = $value * 1.10; // 10% markup
    }

    /**
     * Set the quantity and automatically update the in_stock status.
     *
     * @param int $value
     * @return void
     */
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
        $this->attributes['in_stock'] = ($value > 0);
    }
}
