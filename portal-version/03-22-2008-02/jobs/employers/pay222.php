<?php

               	require_once("class_PayPalIPN.php");



class Advertiser

	{

                	function addMoney($user_id,$plan)

			{

                               
//						echo "I am calleddddddddddddddddddddddddddddddddddddddd";
                      

                                $q = "select * from job_plan where PlanName = '$plan'";

	      $r = mysql_query($q) or die(mysql_error());

	      $a = mysql_fetch_array($r);

			$expireon  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$a[numdays], date("Y")));
			$expireond=date("d M Y",$expireon);
	
	$q1 = "update job_employer_info set plan = '$plan', expiryplan='$expireon', JS_number = '$a[reviews]', JP_number = '$a[postings]',JS_accessed=0,JP_accessed=0 where ename = '$user_id'";
//	echo $q1;
	$r1 = mysql_query($q1) or die(mysql_error());

 

				                            

                             

			}/*---addMoney()-----*/

	}/*------------class Advertiser-------------*/





 $paypal_ipn = new PayPalIPN($_POST);

 $adv = new Advertiser();





  

 $Email=$paypal_email_address;
// echo $Email;

 $paypal_ipn->setPayPalReceiverEmail($Email);



  $paypal_ipn->postResponse2PayPal(); //Post back our response to PayPal

  $paypal_ipn->validateTransaction();





		$user_id = $paypal_ipn->paypal_post_arr['item_number'];

                $plan = $paypal_ipn->paypal_post_arr['item_name'];





if ($paypal_ipn->isTransactionOk()) 

	{ //ok. process payment

          $adv->addMoney($paypal_ipn->paypal_post_arr['item_number'],$paypal_ipn->paypal_post_arr['item_name']);
		  $invalidtxn="false";
	} else { 
	echo "<center><strong>Invalid Transaction .. Please try again</strong></center> ";
	$invalidtxn="true";
	}

$paypal_ipn->logTransactions($user_id); //log valid & invalid transactions

?>