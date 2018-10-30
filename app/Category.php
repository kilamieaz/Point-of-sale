<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id_category';
    protected $fillable = ['name_category'];

    protected static function boot()
    {
        parent::boot();
        // can't delete category when have products
        static::deleting(function ($category) {
            if ($category->products()->count()) {
                return false;
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_product');
    }
}
