<?
include_once "conn.php";
include_once "main.php";
$q1 = "select story_id from job_story";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_num_rows($r1);

if($a1 != '0')
{
mt_srand((double)microtime() * 1000000);
$number = mt_rand(1, $a1);

$q2 = "select story from job_story where story_id = \"$number\"";
$r2 = mysql_query($q2) or die(mysql_error());
$a2 = mysql_fetch_array($r2);
$st = $a2[0];
}
?>
<table width="446" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
        <tr valign="top"> 
          <td width="100%" valign="top"><img src="http://<?=$_SERVER[HTTP_HOST]?>/images/title_welcome.gif" width="260" height="15" alt="" border="0">
		  <br><br>
      <font size="2" face="Tahoma, Arial, sans-serif" color="#000000">Whether you’re an individual looking for a new job or a company searching for a new employee. Try us here at <em><?=$site_name?></em><br><br>	  
	  <div align="center"><img src="images/logo_Electron.gif" alt="pay VISA Electron" width="37" height="23"><img src="images/logo_MC.gif" alt="pay MasterCard" width="37" height="23">
	  <img src="images/logo_Solo.gif" alt="pay Solo" width="37" height="23"><img src="images/logo_Switch.gif" alt="pay Switch" width="72" height="23"><img src="images/logo_Visa.gif" alt="pay Visa" width="37" height="23"></div>
	  <br>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr valign="top"> 
                <td width="50%" style="padding-right:10px;"><img src="http://<?=$_SERVER[HTTP_HOST]?>/images/title_jobseekers1.gif" width="92" height="12" alt="" border="0" vspace="5"> 
                  <br>
                  <font class="job"><a href="http://<?=$_SERVER[HTTP_HOST]?>/jobseekers/JobSearch.php">Search 
                  jobs</a></font> <br>
                  Browse all the jobs for free <br>
                  <br>
                  <font class="job"><a href="http://<?=$_SERVER[HTTP_HOST]?>/jobseekers/jobseeker_registration.php">Join 
                  for free</a></font> <br>
                  Register to access all the information <br>
                  <br>
                  <font class="job"><a href="http://<?=$_SERVER[HTTP_HOST]?>/jobseekers/jobseeker_registration.php">Post 
                  your resume</a></font> <br>
                  Describe yourself - education, jobs, ect.</td>
                <td width="50%" style="padding-right:10px;"><img src="http://<?=$_SERVER[HTTP_HOST]?>/images/title_employers1.gif" width="84" height="12" alt="" border="0" vspace="5"> 
                  <br>
                  <font class="job"><a href="http://<?=$_SERVER[HTTP_HOST]?>/employers/EmployerSearch.php">Search 
                  for staff</a></font> <br>
                  Need more employees? <br>
                  <br>
                  <font class="job"><a href="http://<?=$_SERVER[HTTP_HOST]?>/employers/employer_registration.php">Register 
                  here</a></font> <br>
                  Register to access the staff you need. <br>
                  <br>
                  <font class="job"><a href="http://<?=$_SERVER[HTTP_HOST]?>/employers/PostJob.php">Post 
                  a job</a></font> <br>
                  First step to find your employees</td>
              </tr>
            </table>
            <br>
            <img src="http://<?=$_SERVER[HTTP_HOST]?>/images/title_successstory.gif" width="116" height="12" alt="" border="0" vspace="5"> 
            <br>
            <br>
            <img src="http://<?=$_SERVER[HTTP_HOST]?>/images/clear.gif" width="1" height="1" alt="" border="0">
			&nbsp;</td>
  </tr>
</table>
			<?
if($a1 != '0')
{
?>
  <script language="JavaScript1.2">

var it=0
function initialize(){
mytext=typing.innerText
var myheight=typing.offsetHeight
typing.innerText=''
document.all.typing.style.height=myheight
document.all.typing.style.visibility="visible"
typeit()
}
function typeit(){
typing.insertAdjacentText("beforeEnd",mytext.charAt(it))
if (it<mytext.length-1){
it++
setTimeout("typeit()",100)
}
else
return
}
if (document.all)
document.body.onload=initialize

</script>
              <small><span id="typing" style="visibility:hidden" align="left"> 
              <?=$st?>
              </span></small> <br>
              <?
}
?>
            <hr size="1" noshade>
			<div align="center"><?  include_once "banners.php";?></div>

<? include_once('foother.html'); ?>