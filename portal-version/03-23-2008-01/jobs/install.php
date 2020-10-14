<?
ini_set("register_globals","On");
?>
<html><head><title>Install </title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body bgcolor="#ffffff" style="text-align: center" background="images/bg_b.jpg" topmargin="20">

<table width="664" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#D6E742">
  <tr>
    <td height="25" colspan="0" valign="top" style="padding:10px;">
<br>
		<br>
	<strong>Welcome to Installation. Please note the following things.</strong><br>
	<strong>Database Host</strong> - Please enter your database host name here. This hostname can be a URL or a IP.  <br>
	<strong>Database Name</strong> - Please enter your database name here. First make a MySql database from your hosting panel then use its name here. Please note that the databse should be empty. <br>
	<strong>Username</strong> - This Username is the database user name. Place your database user name here.  <br>	
	<strong>Password</strong> - This is mysql database password. <br>
	<strong>Site Name</strong> - Place your site name here not the site url. This site name will be used in this website, including il all outgoing emails.<br>
	<strong>Email Addres</strong> - Enter your email address here.<br>
	<strong>Site Address</strong> - Enter your site address here without http:// or www format, please note that give full url without any trailing slash and including folder name in which you are installing this script. For example, <strong>mydomain.com</strong> or <strong>mydomain.com/foldername</strong>
	<strong>PayPal ID</strong> - Enter your paypal id here., if you dont have any left it empty.<br>
	<strong>2Checkout Vendor ID</strong> - Enter your 2Checkout Vendor id here., if you dont have any left it empty.<br>
	<strong>Active Account</strong> - Select your preferred payment gateway to be used. <br>
	<center>
	<em>All these setting can be changed after installation from Admin panel.</em>
	</center>	</td>
	</table>
<div align="center">
	<TABLE WIDTH=550 BORDER=0 CELLPADDING=0 CELLSPACING=0 bgcolor="#E0B837">
          <TR> 
          <TD ROWSPAN=2 background="images/body_01.gif">&nbsp;</TD>
          <TD  valign="top" bgcolor="D6E742" colspan="2">
	&nbsp;</TD>
          <TD width="446" valign="top"  bgcolor="#D6E742">
		  
<?



	if ($_POST['submit']=="Submit")

	{

		$str ="<?\n\n//	'server'     'database_username'		'database_password' \n\$connection = mysql_connect(\"$_POST[database_host]\", \"$_POST[database_username]\", \"$_POST[database_password]\")\n or die (mysql_error());\n\n //	'database_name' \n \$db = mysql_select_db(\"$_POST[database_name]\", \$connection) or die (mysql_error());\n?>";

print $str;

		$fp=fopen("conn.php","w");

		fwrite($fp,$str);

		fclose($fp);

		$fp=fopen("employers/conn.php","w");

		fwrite($fp,$str);

		fclose($fp);

		$fp=fopen("jobseekers/conn.php","w");

		fwrite($fp,$str);

		fclose($fp);

		$fp=fopen("siteadmin/conn.php","w");

		fwrite($fp,$str);

		fclose($fp);

		

		//print "Database values have been altered";



		include ("conn.php");



		//creating tables

		$jal_qry=array("DROP TABLE IF EXISTS `job_admin_login`","CREATE TABLE job_admin_login (

		  aid varchar(50) NOT NULL default '',

		  apass varchar(50) NOT NULL default '',

		  name varchar(100) NOT NULL default '',

		  email varchar(100) NOT NULL default '',

		  PRIMARY KEY  (aid)

		) TYPE=MyISAM;");



		for($i=0;$i<count($jal_qry);$i++)

		{

			if (!mysql_query($jal_qry[$i]))

			{

				echo $jal_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}




		$jal_qry=array("DROP TABLE IF EXISTS `configuration`","CREATE TABLE `configuration` (
									`conf_id` int(11) NOT NULL auto_increment,
									`paypal_email` varchar(100) NOT NULL default '',
									`vendorid` varchar(12) NOT NULL default '',
									`site_name` varchar(150) NOT NULL default '',
									`email` varchar(150) NOT NULL default '',
									`address` varchar(150) NOT NULL default '',
									`active_account` char(6) NOT NULL default '',
									PRIMARY KEY (`conf_id`)
									) TYPE=MyISAM;");



		for($i=0;$i<count($jal_qry);$i++)

		{

			if (!mysql_query($jal_qry[$i]))

			{

				echo $jal_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}






		// "Table --job_admin_login-- created";



		$ja_qry=array("DROP TABLE IF EXISTS `job_aplicants`","CREATE TABLE job_aplicants (

		  job_id int(10) NOT NULL default '0',

		  aplicant varchar(20) NOT NULL default '') TYPE=MyISAM;");



		for($i=0;$i<count($ja_qry);$i++)

		{

			if (!mysql_query($ja_qry[$i]))

			{

				echo $ja_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		// "Table --job_applicants-- created";



		$jbm_qry=array("DROP TABLE IF EXISTS `job_banners_m`","CREATE TABLE job_banners_m (

		  bc char(1) NOT NULL default ''

		) TYPE=MyISAM;");



		for($i=0;$i<count($jbm_qry);$i++)

		{

			if (!mysql_query($jbm_qry[$i]))

			{

				echo $jbm_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_banners_m-- created";



		$jbt_qry=array("DROP TABLE IF EXISTS `job_banners_t`","CREATE TABLE job_banners_t (

		  b_id varchar(10) NOT NULL default '',

		  fn varchar(100) NOT NULL default '',

		  burl varchar(100) NOT NULL default '',

		  alt varchar(255) default NULL

		) TYPE=MyISAM;");



		for($i=0;$i<count($jbt_qry);$i++)

		{

			if (!mysql_query($jbt_qry[$i]))

			{

				echo $jbt_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_banners_t-- created";



		$jc_qry=array("DROP TABLE IF EXISTS `job_careerlevel`","CREATE TABLE job_careerlevel (

		  uname varchar(10) NOT NULL default '',

		  clnumber int(2) NOT NULL default '0',

		  clname varchar(60) NOT NULL default ''

		) TYPE=MyISAM;");



		for($i=0;$i<count($jc_qry);$i++)

		{

			if (!mysql_query($jc_qry[$i]))

			{

				echo $jc_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_careerlevel-- created";



		$je_qry=array("DROP TABLE IF EXISTS `job_education`","CREATE TABLE job_education (

		  uname varchar(10) NOT NULL default '',

		  En char(3) NOT NULL default '',

		  E_i varchar(200) NOT NULL default '',

		  E_Start varchar(20) NOT NULL default '',

		  E_End varchar(20) NOT NULL default '',

		  E_gr varchar(100) NOT NULL default '',

		  E_d text

		) TYPE=MyISAM;");



		for($i=0;$i<count($je_qry);$i++)

		{

			if (!mysql_query($je_qry[$i]))

			{

				echo $je_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_education-- created";



		$jei_qry=array("DROP TABLE IF EXISTS `job_employer_info`","CREATE TABLE `job_employer_info` (
  `ename` varchar(10) NOT NULL default '',
  `epass` varchar(10) NOT NULL default '',
  `CompanyName` varchar(100) NOT NULL default '',
  `CompanyCountry` varchar(200) NOT NULL default '',
  `CompanyState` varchar(50) NOT NULL default '',
  `CompanyZip` varchar(10) NOT NULL default '',
  `CompanyCity` varchar(100) NOT NULL default '',
  `CompanyAddress` varchar(255) NOT NULL default '',
  `CompanyPhone` varchar(30) NOT NULL default '',
  `CompanyPhone2` varchar(30) NOT NULL default '',
  `CompanyEmail` varchar(200) NOT NULL default '',
  `plan` varchar(100) NOT NULL default '',
  `JS_number` char(3) NOT NULL default '',
  `JP_number` char(3) NOT NULL default '',
  `JS_accessed` char(3) NOT NULL default '',
  `JP_accessed` char(3) NOT NULL default '',
  `CompanyType` varchar(50) NOT NULL default '',
  `turnover` int(20) NOT NULL default '0',
  `nempl` int(10) NOT NULL default '0',
  `free` char(1) NOT NULL default '0',
  `expiryplan` date NOT NULL default '0000-00-00',
  PRIMARY KEY (`ename`)) TYPE=MyISAM;");



		for($i=0;$i<count($jei_qry);$i++)

		{

			if (!mysql_query($jei_qry[$i]))

			{

				echo $jei_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_employer_info-- created";



		$jls_qry=array("DROP TABLE IF EXISTS `job_link_source`","CREATE TABLE job_link_source (link_id varchar(50) NOT NULL default '',link_code text) TYPE=MyISAM;");



		for($i=0;$i<count($jls_qry);$i++)

		{

			if (!mysql_query($jls_qry[$i]))

			{

				echo $jls_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_link_source-- created";



		$jp_qry=array("DROP TABLE IF EXISTS `job_plan`","CREATE TABLE `job_plan` (`PlanName` varchar(50) NOT NULL default '', `price` float default NULL,  `numdays` int(11) NOT NULL default '0' ,`reviews` int(11) NOT NULL default '0' , `postings` int(11) NOT NULL default '0') TYPE=MyISAM;");



		for($i=0;$i<count($jp_qry);$i++)

		{

			if (!mysql_query($jp_qry[$i]))

			{

				echo $jp_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_plan-- created";



		$jp_qry=array("DROP TABLE IF EXISTS `job_post`","CREATE TABLE job_post (

		  job_id int(10) default NULL,

		  ename varchar(10) NOT NULL default '',

		  Company varchar(100) NOT NULL default '',

		  CompanyCountry varchar(200) NOT NULL default '',

		  position varchar(100) NOT NULL default '',

		  JobCategory varchar(150) NOT NULL default '',

		  description text NOT NULL,

		  j_target int(3) NOT NULL default '0',

		  salary int(10) NOT NULL default '0',

		  s_period varchar(10) NOT NULL default '',

		  EXmonth char(2) NOT NULL default '',

		  EXday char(2) NOT NULL default '',

		  EXyear varchar(4) NOT NULL default '',

		  nv int(5) NOT NULL default '0',

		  CompanyState varchar(100) NOT NULL default ''

		) TYPE=MyISAM;");



		for($i=0;$i<count($jp_qry);$i++)

		{

			if (!mysql_query($jp_qry[$i]))

			{

				echo $jp_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_post-- created";



		$jsi_qry=array("DROP TABLE IF EXISTS `job_seeker_info`","CREATE TABLE `job_seeker_info` (
  `uname` varchar(10) NOT NULL default '',
  `upass` varchar(10) NOT NULL default '',
  `title` char(3) NOT NULL default '',
  `fname` varchar(100) NOT NULL default '',
  `lname` varchar(100) NOT NULL default '',
  `bmonth` varchar(15) NOT NULL default '',
  `bday` char(2) NOT NULL default '',
  `byear` varchar(4) NOT NULL default '',
  `maritalstatus` varchar(20) NOT NULL default '',
  `income` varchar(20) NOT NULL default '',
  `city` varchar(100) NOT NULL default '',
  `state` varchar(30) NOT NULL default '',
  `country` varchar(60) NOT NULL default '',
  `zip` varchar(10) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `phone` varchar(50) NOT NULL default '',
  `phone2` varchar(50) NOT NULL default '',
  `job_seeker_email` varchar(100) NOT NULL default '',
  `job_seeker_web` varchar(200) NOT NULL default '',
  `job_category` varchar(150) NOT NULL default '',
  `careerlevel` varchar(60) NOT NULL default '',
  `target_company` varchar(60) NOT NULL default '',
  `relocate` char(3) NOT NULL default '',
  `rTitle` varchar(100) NOT NULL default '',
  `rPar` text NOT NULL,
  `isupload` tinyint(4) NOT NULL default '0',
  `resume` varchar(255) NOT NULL default '',
  PRIMARY KEY (`uname`)) TYPE=MyISAM;");



		for($i=0;$i<count($jsi_qry);$i++)

		{

			if (!mysql_query($jsi_qry[$i]))

			{

				echo $jsi_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_seeker_info-- created";



		$js_qry=array("DROP TABLE IF EXISTS `job_skills`","CREATE TABLE job_skills (

		  uname varchar(10) NOT NULL default '',

		  SK_d text

		) TYPE=MyISAM;");



		for($i=0;$i<count($js_qry);$i++)

		{

			if (!mysql_query($js_qry[$i]))

			{

				echo $js_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_skills-- created";



		$js_qry=array("DROP TABLE IF EXISTS `job_story`","CREATE TABLE job_story (

		  story_id int(5) NOT NULL default '0',

		  story text

		) TYPE=MyISAM;");



		for($i=0;$i<count($js_qry);$i++)

		{

			if (!mysql_query($js_qry[$i]))

			{

				echo $js_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}



		$ins_qry1 = mysql_query("INSERT INTO job_story VALUES (1, 'Testing the system.')");





		//"Table --job_story-- created";



		$jsw_qry=array("DROP TABLE IF EXISTS `job_story_waiting`","CREATE TABLE job_story_waiting (

		  WS_id int(5) NOT NULL default '0',

		  story text

		) TYPE=MyISAM;");



		for($i=0;$i<count($jsw_qry);$i++)

		{

			if (!mysql_query($jsw_qry[$i]))

			{

				echo $jsw_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_story_waiting-- created";

		$ins_qry1 = mysql_query("INSERT INTO job_story_waiting VALUES (1, 'Testing the system.')");





		$jwe_qry=array("DROP TABLE IF EXISTS `job_work_experience`","CREATE TABLE job_work_experience (

		  uname varchar(10) NOT NULL default '',

		  WEn int(2) NOT NULL default '0',

		  WE_Start varchar(30) NOT NULL default '',

		  WE_End varchar(30) NOT NULL default '',

		  WE_p varchar(50) NOT NULL default '',

		  WE_d text NOT NULL

		) TYPE=MyISAM;");



		for($i=0;$i<count($jwe_qry);$i++)

		{

			if (!mysql_query($jwe_qry[$i]))

			{

				echo $jwe_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}



		$ins_data = array("INSERT INTO job_admin_login VALUES ('admin', 'admin', 'My Name', 'my email address')","INSERT INTO job_story VALUES (1, 'Testing the system.')","INSERT INTO `configuration` (`conf_id`, `paypal_email`, `site_name`, `email`, `address`,`vendorid`,`active_account`) VALUES (1, '". $_POST["paypal_id"] . "', '" . $_POST["site_name"] . "', '" . $_POST["email_address"] . "', '" . $_POST["site_address"] . "' , '" . $_POST["vendor_id"] . "', '" . $_POST["active_account"] . "' )"); 

		for($i=0;$i<count($ins_data);$i++)

		{
			if (!mysql_query($ins_data[$i]))

			{

				echo "Problem in inserting data...!!!";

				exit;

			}

		}

		//"Table --job_work_experience-- created";



               $jta_qry=array("DROP TABLE IF EXISTS `job_tempacc`","CREATE TABLE job_tempacc (

   id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   date_added date DEFAULT '0000-00-00' NOT NULL,
   ip varchar(20) NOT NULL,
   user_id varchar(20) NOT NULL,
   txn_id varchar(50) NOT NULL,
   payer_email varchar(150) NOT NULL,
   payment_date varchar(30) NOT NULL,
   payment_fee double(50,5) DEFAULT '0.00000' NOT NULL,
   payment_gross double(50,5) DEFAULT '0.00000' NOT NULL,
   payment_status varchar(20) NOT NULL,
   memo text NOT NULL,
   paypal_response varchar(20) NOT NULL,
   paypal_post_vars text NOT NULL,
   plan_name varchar(100) NOT NULL,
   receiver_email varchar(100) NOT NULL,
   error_no tinyint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (id)

) TYPE=MyISAM;");





		for($i=0;$i<count($jta_qry);$i++)

		{

			if (!mysql_query($jta_qry[$i]))

			{

				echo $jta_qry;

				echo "Could not create table...!!!";

				exit;

			}

		}

		//"Table --job_tempacc-- created";

		$ins_qry1 = mysql_query("INSERT INTO job_tempacc VALUES (test, 'Testing the system.','test')");

             







		//tables created

		?>

		<table width="446" bgcolor="#D6E742"><tr><td><CENTER><br>
<B>All Tables created successfully</B><BR><BR>



		</CENTER></td></tr></table>

	<?
//		unlink("install.php");
	}

	else

	{

	?>
<script language="JavaScript">
function validate()
{
	if (document.frm.database_name.value=='')
	{
		alert("Please enter database name");
		document.frm.database_name.focus();
		return false;
	}
	if (document.frm.database_username.value=='')
	{
		alert("Please enter database user name");
		document.frm.database_username.focus();
		return false;
	}
	if (document.frm.site_name.value=='')
	{
		alert("Please enter your site name");
		document.frm.site_name.focus();
		return false;
	}
	if (document.frm.email_address.value=='')
	{
		alert("Please enter email address");
		document.frm.email_address.focus();
		return false;
	}
	if (document.frm.site_address.value=='')
	{
		alert("Please enter site address");
		document.frm.site_address.focus();
		return false;
	}
	if (document.frm.paypal_id.value=='' || document.frm.vendor_id.value=='' )
	{
		alert("Please enter PayPal ID or Vendor ID");
		document.frm.paypal_id.focus();
		return false;
	}
return true;
}
	
	

		</script>
	<center>		<h3>Installation </h3>
  <table border="0" cellpadding="0" cellspacing="8" width="446" align="center"  bgcolor="#D6E742">
<form name = frm method = post action = "install.php" onSubmit="return validate();">
    <tr>

      <td width="50%" align="left"><strong>Database Host</strong></td>

      <td width="50%"><input type = text name = database_host value = "" ></td>    </tr>


    <tr>

      <td width="50%" align="left"><strong>Database Name</strong></td>

      <td width="50%"><input type = text name = database_name value = "" ></td>    </tr>

    <tr>

      <td width="50%" align="left"><strong>Username</strong></td>

      <td width="50%"><input type = text name = database_username value = "" ></td>

    </tr>

    <tr>

      <td width="50%" align="left"><strong>Password</strong></td>

      <td width="50%"><input type = text name = database_password value = "" ></td>

    </tr>
    <tr>

      <td width="50%" align="left"><strong>Site Name</strong></td>

      <td width="50%"><input name = site_name type = text id="site_name" value = "" ></td>

    </tr>
    <tr>

      <td width="50%" align="left"><strong>Email Address</strong></td>

      <td width="50%"><input name = email_address type = text id="email_address" value = "" ></td>

    </tr>
    <tr>

      <td width="50%" align="left"><strong>Site Address</strong></td>

      <td width="50%"><input name = site_address type = text id="site_address" value = "" ></td>

    </tr>
    <tr>

      <td width="50%" align="left"><strong>Paypal Id</strong></td>

      <td width="50%"><input name = paypal_id type = text id="paypal_id" value = "" ></td>

    </tr>
    <tr>

      <td width="50%" align="left"><strong>2Checkout Vendor Id</strong></td>

      <td width="50%"><input name = vendor_id type = text id="vendor_id" value = "" ></td>

    </tr>
    <tr>

      <td width="50%" align="left"><strong>Active Account</strong></td>

      <td width="50%"><select name="active_account">
	  <option value="pptc" selected>Use Both (PayPal & 2Checkout)</option><option  value="tc">2Checkout</option><option value="pp">PayPal</option></select></td>

    </tr>
	
    <tr>

      <td width="50%" align="left">&nbsp;</td>
      <td width="50%">        <input type = "submit" name = "submit" value = "Submit" >
        <input type = "reset" name = "reset" value = "Reset" ></td>

    </tr>
</form>
  </table>

  </center>

	<?

	}	

	?>
</TD>
          <TD ROWSPAN=2 background="images/body_05.jpg"> <IMG SRC="images/body_05.jpg" WIDTH=7 HEIGHT=329 ALT=""></TD>
        </TR>
		
        <TR> 
          <TD> <IMG SRC="images/body_06.gif" WIDTH=11 HEIGHT=4 ALT=""></TD>
          <TD> <IMG SRC="images/body_07.gif" WIDTH=193 HEIGHT=4 ALT=""></TD>
          <TD   bgcolor="#D6E742"></TD>
        </TR>
		
		        <TR bgcolor="#E0B837"> 
          <TD> <IMG SRC="images/body_09.gif" WIDTH=7 HEIGHT=42 ALT=""></TD>
          <TD COLSPAN=3 align="center">POWERED BY <strong>PREPROJECTS.COM</strong></TD>
          <TD> <IMG SRC="images/body_11.gif" WIDTH=7 HEIGHT=42 ALT=""></TD>
        </TR>

      </TABLE></div>
</td><br>

  </tr>
</table>
</body>
</html>