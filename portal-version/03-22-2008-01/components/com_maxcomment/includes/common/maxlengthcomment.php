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

?>
	<script language="javascript" type="text/javascript">	
		
		function countlengthcomment(field, countFieldId, maxlimit) {
			if (document.getElementById){
				target = document.getElementById(countFieldId);
				if (field.value.length > maxlimit){ // if too long...trim it!
					field.value = field.value.substring(0, maxlimit);
					// otherwise, update 'characters left' counter
				} else {
					target.innerHTML = "<?php echo _MXC_NUM_CHARCARTERS; ?> " +  (maxlimit - field.value.length);
				}
			}
		}

		
		function showInputField(field, relative, maxlimit) {
			if (document.getElementById){
				target = document.getElementById(field);	
				target.style.display = "block";
				target.innerHTML = "<?php echo _MXC_NUM_CHARCARTERS; ?> " + (maxlimit - relative.value.length);		
			}		
		
		}

	</script>	
