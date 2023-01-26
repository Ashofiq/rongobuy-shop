<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Product;
use App\Models\Varient;
use App\Models\Base\BaseModel;

class ShopInventory extends BaseModel
{
    protected $guarded = ['id'];
    
    protected $logName = "ShopInventory";


    public function product() {
        return $this->belongsTo( Product::class, 'product_id' );
    }

    public function varient() {
        return $this->belongsTo( Varient::class, 'varient_id' );
    }

    // file image push

    // date format
}
