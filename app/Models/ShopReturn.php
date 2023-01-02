<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class ShopReturn extends BaseModel
{
    protected $guarded = ['id'];
    
    protected $logName = "ShopReturn";

    // file image push

    // date format
public function setDateAttribute( $value ) {
                        $this->attributes["date"] = date( 'Y-m-d', strtotime( $value ) );
                        }
                        public function getDateAttribute( $value ) {
                        return date( 'd M, yy', strtotime( $value ) );
                        }}
