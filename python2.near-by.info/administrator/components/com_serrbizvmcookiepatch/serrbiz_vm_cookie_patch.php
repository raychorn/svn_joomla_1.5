<?php
 if(isset($_REQUEST['step']))
 {
    $step = (int)$_REQUEST['step'];
	if($step==1)
	{
	  setcookie("VMCHECK","OK",time()+3600,"/");
      print "2";
	}
	elseif($step==2)
	{
	  if($_COOKIE['VMCHECK'] == "OK" )
	  {
        setcookie('VMCHECK', '', false,"/");  
		unset($_COOKIE['VMCHECK']);
	    print "3";

		if(session_id() == "")
		{
			session_start();
		}

      }
	  else
	  {
		setcookie('VMCHECK', '', false,"/");
		print "1";
	  }
	}
 }//if
?>