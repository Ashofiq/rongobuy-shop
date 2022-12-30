<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Minhaz extends BaseModel
{
    protected $guarded = ['id'];
    
    protected $logName = "Minhaz";

    // file image push
public function getImageAttribute( $value ) {
							if ( !empty( $value ) ) {
								return url( "" ) . "/public/storage/" . $value;
							}
							return null;
						}}
