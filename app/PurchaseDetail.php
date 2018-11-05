<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $primaryKey = 'id_purchase_detail';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_purchase_detail', 'purchase_detail_id', 'product_id');
    }
}
