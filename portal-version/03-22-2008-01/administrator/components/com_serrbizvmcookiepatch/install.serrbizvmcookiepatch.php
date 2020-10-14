<script language="javascript" type="text/javascript">
function popUp(URL) 
{
  var day = new Date();
  var id = day.getTime();
  var status;
  status = eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400,height=150');");
}
</script>

<?php
/*
* SerrBizSEFSocialBookmark is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
*/

function  com_install() 
{
     global $database,$mosConfig_live_site,$mosConfig_absolute_path;

   $sql = "INSERT INTO `#__components` VALUES (NULL, 'serrbizvmcookiepatch', '', 0, 0, '', 'serrbizvmcookiepatch', 'com_serrbizvmcookiepatch', 0, '', 0, '') ";
     $database->setQuery($sql);
     $res1 = $database->query();

     $sql = "SELECT params FROM #__components WHERE name = 'virtuemart_version'";
     $database->setQuery($sql);
     $result = $database->query();
	 
     if($result) 
	 {
      $database->loadObject($social);
      $objParams = new mosParameters($social->params);
	  
	    if(isset($objParams->_params->RELEASE) )
		{
		   if(trim($objParams->_params->RELEASE)=="1.0.12")
		   {
		      if(file_exists($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php"))
			  {
				if($fp=fopen($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_serrbizsef.test.txt","w") )
				{
				  @unlink($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_serrbizsef.test.txt");
				  
				  if(rename($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php",$mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_backup_ps_session.php"))
				  {
					if(copy($mosConfig_absolute_path."/administrator/components/com_serrbizvmcookiepatch/ps_session.php",$mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php"))
					{
					$source = $mosConfig_absolute_path."/administrator/components/com_serrbizvmcookiepatch/serrbiz_vm_cookie_patch.php";
					$dest = $mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/serrbiz_vm_cookie_patch.php";

					  if(copy($source,$dest))
					  {
					        unset($source,$dest);
							echo "<br><strong> Installation Success </strong><br>";
							?>
							<script language="javascript" type="text/javascript">
							alert("Your VirtueMart files have been UPDATED with the SerrBizSEF VM Cookie Patch. If for some reason it causes problems, please UNINSTALL and contact Serr.biz");
							</script>
							<?php
					  }
					  else
					  {
						  if(rename($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_backup_ps_session.php",$mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php"))
						  {
							echo "Error: Cannot copy the file";
						  }
						  else
						  {
							echo "Error: An unexpected error occured, please manually rename <br>";
							echo $mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_backup_ps_session.php <br> TO ";
							echo $mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php <br> ";
						  }
					  }
					}
					else
					{
					  if(rename($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_backup_ps_session.php",$mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php"))
					  {
					    echo "Error: Cannot copy the file";
					  }
					  else
					  {
					    echo "Error: An unexpected error occured, please manually rename <br>";
						echo $mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_backup_ps_session.php <br> TO ";
						echo $mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php <br> ";
					  }
					}
				  }
				  else
				  {
				    echo "<br>ERROR:cannot take backup of :- ".$mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php";
				  }

				}
				else
				{
				  echo "<br>ERROR: not sufficient permisson to write file on server<br>";
				}
				
			  }
			  else
			  {
				echo "<br>ERROR: file /administrator/components/com_virtuemart/classes/ps_session.php not found <br>";
			  }
		   }
		   else
		   {
			echo "<br>ERROR: this patch will run only for virtuemart - 1.0.12 <br>";
		   }
		}//if
		else
		{
		  echo "<br>ERROR: cannot determine the virtuemart version<br>";
		}
	  
     }//if

}//function com_install() 	 
?> 
