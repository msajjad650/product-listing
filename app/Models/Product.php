<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Associated variants
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function variants()
    {
        return $this->hasMany('App\Models\ProductVariant');
    }

    /**
     * Associated product type
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productType()
    {
        return $this->BelongsTo('App\Models\ProductType');
    }

    /**
     * Associated product type
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productBrand()
    {
        return $this->BelongsTo('App\Models\ProductBrand');
    }

    public function scopeTitle($query, $title)
    {
        if (!is_null($title)) {
            return $query->where('title', 'like', '%'.$title.'%');
        }

        return $query;
    }

    public function scopeProductBrand($query, $product_brand_id)
    {
        if (!is_null($product_brand_id)) {
            return $query->where('product_brand_id', $product_brand_id);
        }

        return $query;
    }

    public function scopeProductType($query, $product_type_id)
    {
        if (!is_null($product_type_id)) {
            return $query->where('product_type_id', $product_type_id);
        }

        return $query;
    }
}
