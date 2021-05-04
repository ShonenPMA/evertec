<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'discount', 'total_views', 'total_order'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function getImageAttribute()
    {
        $array = array('necklace','earings','rings');
        $index = array_rand($array, 1);

        return "{$this->image_url},{$array[$index]},".uniqid();

    }

    public function getRealPriceAttribute()
    {
        return 'S/. '.number_format($this->price, 2);

    }

    public function getRealDiscountAttribute()
    {
        return 'S/. '. $this->raw_discount ;

    }

    public function getRawDiscountAttribute()
    {
        number_format((1-$this->discount)*$this->price, 2);
    }

    public function getTotalPriceAttribute()
    {
        return $this->discount > 0 ? $this->real_discount : $this->real_price; 
    }

    public function getRawPriceAttribute()
    {
        return $this->discount > 0 ? $this->raw_discount : $this->price; 
    }
}
