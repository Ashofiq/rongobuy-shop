<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Student extends BaseModel
{
    protected $guarded = ['id'];
    
    protected $logName = "Student";

    // file image push
public function getFileAttribute( $value ) {
							if ( !empty( $value ) ) {
								return url( "" ) . "/public/storage/" . $value;
							}
							return null;
						}public function getImageAttribute( $value ) {
							if ( !empty( $value ) ) {
								return url( "" ) . "/public/storage/" . $value;
							}
							return null;
						}}
