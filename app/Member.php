<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'id_member';
    protected $guarded = [];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'id_sales');
    }
}
