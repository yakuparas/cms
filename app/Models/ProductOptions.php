<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    use HasFactory;
    public function optionsValues()
    {
        return $this->hasMany('App\Models\ProductOptionsValues', 'optionsID', 'id');
    }


}
