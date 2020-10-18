<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $collection = 'categories';

    protected $fillable = ['name','slug','description'];

}
