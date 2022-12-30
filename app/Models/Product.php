<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Product extends BaseModel {
    protected $guarded = ['id'];

    protected $table = 'product';

    protected $logName = "Product";

    // file image push

    // date format
    public function setAddedDateAttribute( $value ) {
        $this->attributes["added_date"] = date( 'Y-m-d', strtotime( $value ) );
    }
    public function getAddedDateAttribute( $value ) {
        return date( 'd F, yy', strtotime( $value ) );
    }}