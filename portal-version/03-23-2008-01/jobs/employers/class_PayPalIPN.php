<?

include("../conn.php");

class PayPalIPN

	{
        var $paypal_post_arr = array();
		var $paypal_post_vars_in_str; //the paypal post array vars as string
		var $paypal_response = ""; //paypals response for our posted vars
		var $paypal_receiver_emails = array(); //array of expected paypal receiver emails
		var $error; //error no of transaction
		var $db;
		function PayPalIPN($paypal_post_arr)	//constructor
			{
                                $this->paypal_post_vars_in_str = "";
				foreach($paypal_post_arr as $key=>$value)
					{
						$value = urlencode(stripslashes($value));
						$this->paypal_post_vars_in_str .= "&$key=$value";
					}
				//we can directly assign $this->paypal_post_arr = $paypal_post_arr;. But, it is safe to check undefined index...
				$this->paypal_post_arr = $this->_processPayPalPostVars($paypal_post_arr);
			}/*---PayPalIPN()-----*/
                     function setPayPalReceiverEmail($email)
			{
				//put it in array so that any number of emails can be set as receiver emails
				$this->paypal_receiver_emails[ ] = $email;
			}
                    function postResponse2PayPal()
			{
				// post back to PayPal system to validate
				$this->paypal_post_vars_in_str = "cmd=_notify-validate" . $this->paypal_post_vars_in_str;
				$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= 'Content-Length: ' . strlen($this->paypal_post_vars_in_str) . "\r\n\r\n";
				//suppress socket connection error by "@"...
				$fp = @fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
				if (!$fp)  // ERROR
						$this->paypal_response = "$errstr ($errno)";
					else
						{
							//just post it...
							fputs ($fp, $header . $this->paypal_post_vars_in_str);
							while(!feof($fp))
								{
									$resp = fgets($fp, 1024);
									    if (strcmp($resp, "VERIFIED") == 0)
												$this->paypal_response = "VERIFIED";
											else if (strcmp($resp, "INVALID") == 0)
												$this->paypal_response = "INVALID";
								}
						}
			}/*---postResponse2PayPal()-----*/
		function _processPayPalPostVars($post_vars)
			{
				$tmp_arr = array();
				//the following step is to avoid undefined index error...
				$tmp_arr['txn_id'] = isset($post_vars['txn_id']) ? $post_vars['txn_id'] : "";
				$tmp_arr['payer_email'] = isset($post_vars['payer_email']) ? $post_vars['payer_email'] : "";
				$tmp_arr['payment_date'] = isset($post_vars['payment_date']) ? $post_vars['payment_date'] : "";
				$tmp_arr['payment_gross'] = isset($post_vars['payment_gross']) ? $post_vars['payment_gross'] : "";
				$tmp_arr['payment_fee'] = isset($post_vars['payment_fee']) ? $post_vars['payment_fee'] : "";
				$tmp_arr['payment_status'] = isset($post_vars['payment_status']) ? $post_vars['payment_status'] : "";
				$tmp_arr['memo'] = isset($post_vars['memo']) ? $post_vars['memo'] : "";
				$tmp_arr['receiver_email'] = isset($post_vars['receiver_email']) ? $post_vars['receiver_email'] : "";
                                $tmp_arr['item_name'] = isset($post_vars['item_name']) ? $post_vars['item_name'] : "";
                                $tmp_arr['item_number'] = isset($post_vars['item_number']) ? $post_vars['item_number'] : "";
                                for($i=1; isset($post_vars["option_name{$i}"]) && isset($post_vars["option_selection{$i}"]); ++$i)
						$tmp_arr[$post_vars["option_name{$i}"]] = $post_vars["option_selection{$i}"];
				//following line is to avoid undefined index error...
				$tmp_arr['ADV_ID'] = isset($tmp_arr['ADV_ID']) ? $tmp_arr['ADV_ID'] : 0;
				return($tmp_arr);
			}/*---_processPayPalPostVars()-----*/
                     function _isVerified()
			{
				return(strcmp($this->paypal_response, "VERIFIED")==0);

			}/*---_isVerified()-------*/
		function _isVaidPaymentStatus()
			{
				//payment status can be : "Completed", "Pending", "Failed", "Denied"
				return(strcmp($this->paypal_post_arr['payment_status'], "Completed")==0);

			}/*---_isVaidPaymentStatus()---*/
		function _isTransactionProcessed()
			{
				$txn_id = $this->paypal_post_arr['txn_id'];
				$sql = "SELECT COUNT(*) FROM job_tempacc WHERE txn_id='$txn_id'";
				$result = mysql_query($sql);
				if (!$result) //error...
					   die("Query error at isTransactionProcessed()". mysql_error($this->db));
				$num_of_txn_id = mysql_result($result, 0);
				return($num_of_txn_id!=0); //txn_id processed if num!=0
			}/*---_isTransactionProcessed()-----*/
		function _isValidReceiverEmail()
			{
				//is receiver_email is the expected receiver_emails (one who runs website)??
				return( in_array($this->paypal_post_arr['receiver_email'], $this->paypal_receiver_emails));
			}/*---_isValidReceiverEmail()-------*/
                function validateTransaction()
			{
				//set the error no...
				// check the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is an email address in your PayPal account
				// process payment
				//This is to trap exact error type
				//Logic: bit field logic: 0-no error, ...
				//if all bits are set, then error in all conditions
				$this->error = 0; //initialize to no error
				$this->error  |=  $this->_isVerified() ? 0 : (1<<0);
				$this->error  |=  $this->_isVaidPaymentStatus() ? 0 : (1<<1);
				$this->error  |=  (!$this->_isTransactionProcessed()) ? 0 : (1<<2);
				$this->error  |=  $this->_isValidReceiverEmail() ? 0 : (1<<3);
			}/*---validateTransaction()------*/
		function isTransactionOk()
			{
                              return( !$this->error );
                         }

		function logTransactions($user_id)
			{
                                  $sql = "INSERT INTO job_tempacc SET " .
						"date_added=NOW(), " .
						"ip='".$_SERVER['REMOTE_ADDR']."', " .
                                                "user_id='".$this->paypal_post_arr['item_number']."', " .
                                                "plan_name='".$this->paypal_post_arr['item_name']."', " .
						"txn_id='".$this->paypal_post_arr['txn_id']."', " .
						"payer_email='".$this->paypal_post_arr['payer_email']."', " .
						"payment_date='".$this->paypal_post_arr['payment_date']."', " .
						"payment_gross='".$this->paypal_post_arr['payment_gross']."', " .
						"payment_fee='".$this->paypal_post_arr['payment_fee']."', " .
						"payment_status='".$this->paypal_post_arr['payment_status']."', " .
						"receiver_email='".$this->paypal_post_arr['receiver_email']."', " .
						"paypal_response='".$this->paypal_response."', " .
						"error_no='".$this->error."', " .
						"memo='".$this->paypal_post_arr['memo']."', " .
						"paypal_post_vars='".$this->paypal_post_vars_in_str."'";
				$result = mysql_query($sql);
				if (!$result) 
						die("Query Error at logTransactions()" . mysql_error($this->db));
			}/*---logTransactions()-----*/

	}/*---class PayPalIPN--------*/

?>

			

		