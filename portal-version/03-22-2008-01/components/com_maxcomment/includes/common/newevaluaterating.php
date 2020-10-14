<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function confirm_evaluate( $rating, $level, $current_level ) {

	if ( $rating ) {
	
		if ( $level==$current_level ) {
		
			$rate = $rating;
				
		} else {
		
			switch ( $current_level ) {
			
				case '20':
					if ( $level=='5' ){					
						$rate = $rating*4;
					} else $rate = $rating*2;			
					break;
				
				case '10':
					if ( $level=='5' ){					
						$rate = $rating*2;
					} else $rate = $rating/2;
					break;
				
				case '5':					
				default:
					if ( $level=='20' ){					
						$rate = $rating/4;
					} else $rate = $rating/2;						
			}	
				
		}
	
	} else $rate=0;
	
	return $rate;

}

?>