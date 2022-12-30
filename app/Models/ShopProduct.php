<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class ShopProduct extends BaseModel
{
    protected $guarded = ['id'];

    protected $table = 'product';
    
    protected $logName = "ShopProduct";

    public function brand() {
        return $this->belongsTo( Brand::class, 'brand_id' );
    }

    // file image push

    // date format
}
