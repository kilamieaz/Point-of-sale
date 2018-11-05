<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_product';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function purchaseDetail()
    {
        return $this->belongsToMany(PurchaseDetail::class, 'product_purchase_detail', 'product_id', 'purchase_detail_id');
    }
}
