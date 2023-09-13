<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $guarded = ['id'];
    protected $fillable = ['item_number',
            'item_name', 'item_price', 'item_category', 'item_stock'];

}
