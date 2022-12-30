<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class ShopSale extends BaseModel
{   
    const ORDERNO_PREFIX = 'RNGB';
    protected $guarded = ['id'];
    
    protected $logName = "ShopSale";

    // file image push

    // date format
public function setDateAttribute( $value ) {
                        $this->attributes["date"] = date( 'Y-m-d', strtotime( $value ) );
                        }
                        public function getDateAttribute( $value ) {
                        return date( 'd M, yy', strtotime( $value ) );
                        }}
