<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $table = 'expenses';
    protected $primaryKey = 'id_expenses';
    protected $guarded = [];
}
