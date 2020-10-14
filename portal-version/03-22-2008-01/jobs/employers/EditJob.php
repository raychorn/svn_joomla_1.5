<?
include_once "accesscontrol.php";

$q1 = "select * from job_post where job_id = \"$job_ed\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

?>
<br><br>
	<table align=center width="446">
	<tr><td colspan=2 align=center> To edit a job, use the form below:</td></tr><br><br>
	<form action=EditJob2.php method=post  style="background:none;">
	<tr><td>Position:</td>
	
	<td>
	<input type=text name=position value="<?=$a1[position]?>">
	</td>
	</tr>

	<tr>
	<td valign=top>
	Job Category:
	</td>

	<td valign=top>
	<SELECT NAME="JobCategory2[]" multiple size=5 style=width:300>
	<OPTION VALUE="Accounting/Auditing" >Accounting/Auditing</OPTION>
	<OPTION VALUE="Administrative and Support Services" >Administrative and Support Services</OPTION>
	<OPTION VALUE="Advertising/Public Relations" >Advertising/Public Relations</OPTION>
	<OPTION VALUE="Agriculture/Forestry/Fishing" >Agriculture/Forestry/Fishing</OPTION>
	<OPTION VALUE="Architectural Services" >Architectural Services</OPTION>
	<OPTION VALUE="Arts, Entertainment, and Media" >Arts, Entertainment, and Media</OPTION>
	<OPTION VALUE="Banking" >Banking</OPTION>
	<OPTION VALUE="Biotechnology and Pharmaceutical" >Biotechnology and Pharmaceutical</OPTION>
	<OPTION VALUE="Community, Social Services, and Nonprofit" >Community, Social Services, and Nonprofit</OPTION>
	<OPTION VALUE="Computers, Hardware" >Computers, Hardware</OPTION>
	<OPTION VALUE="Computers, Software" >Computers, Software</OPTION>
	<OPTION VALUE="Construction, Mining and Trades" >Construction, Mining and Trades</OPTION>
	<OPTION VALUE="Consulting Services" >Consulting Services</OPTION>
	<OPTION VALUE="Customer Service and Call Center" >Customer Service and Call Center</OPTION>
	<OPTION VALUE="Education, Training, and Library" >Education, Training, and Library</OPTION>
	<OPTION VALUE="Employment Placement Agencies" >Employment Placement Agencies</OPTION>
	<OPTION VALUE="Engineering" >Engineering</OPTION>
	<OPTION VALUE="Executive Management" >Executive Management</OPTION>
	<OPTION VALUE="Finance/Economics" >Finance/Economics</OPTION>
	<OPTION VALUE="Financial Services" >Financial Services</OPTION>
	<OPTION VALUE="Government and Policy" >Government and Policy</OPTION>
	<OPTION VALUE="Healthcare, Other" >Healthcare, Other</OPTION>
	<OPTION VALUE="Healthcare, Practitioner, and Technician" >Healthcare, Practitioner, and Technician</OPTION>
	<OPTION VALUE="Hospitality, Tourism" >Hospitality, Tourism</OPTION>
	<OPTION VALUE="Human Resources" >Human Resources</OPTION>
	<OPTION VALUE="Information Technology" >Information Technology</OPTION>
	<OPTION VALUE="Installation, Maintenance and Repair" >Installation, Maintenance and Repair</OPTION>
	<OPTION VALUE="Insurance" >Insurance</OPTION>
	<OPTION VALUE="Internet/E-Commerce" >Internet/E-Commerce</OPTION>
	<OPTION VALUE="Law Enforcement and Security" >Law Enforcement and Security</OPTION>
	<OPTION VALUE="Legal" >Legal</OPTION>
	<OPTION VALUE="Manufacturing and Production" >Manufacturing and Production</OPTION>
	<OPTION VALUE="Marketing" >Marketing</OPTION>
	<OPTION VALUE="Military" >Military</OPTION>
	<OPTION VALUE="Other" >Other</OPTION>
	<OPTION VALUE="Personal Care and Services" >Personal Care and Services</OPTION>
	<OPTION VALUE="Real Estate" >Real Estate</OPTION>
	<OPTION VALUE="Restaurant and Food Service" >Restaurant and Food Service</OPTION>
	<OPTION VALUE="Retail/Wholesale" >Retail/Wholesale</OPTION>
	<OPTION VALUE="Sales" >Sales</OPTION>
	<OPTION VALUE="Science" >Science</OPTION>
	<OPTION VALUE="Sports/Recreation" >Sports/Recreation</OPTION>
	<OPTION VALUE="Telecommunications" >Telecommunications</OPTION>
	<OPTION VALUE="Transportation and Warehousing" >Transportation and Warehousing</OPTION>
	</SELECT><br>
	</td>
	</tr>

	<tr><td>Description:</td>
	<td><textarea rows=6 cols=35 name=description2><?=$a1[description]?></textarea></td>
	</tr>

	<tr>
	<td>Target: </td>

	<td>
	<select name="j_target2" style=width:303>
	<option value=""> </option>
	<OPTION VALUE="1">Student (High School)</OPTION>
	<OPTION VALUE="2">Student (undergraduate/graduate)</OPTION>
	<OPTION VALUE="3">Entry Level (less than 2 years of experience)</OPTION>
	<OPTION VALUE="4">Mid Career (2+ years of experience)</OPTION>
	<OPTION VALUE="5">Management (Manager/Director of Staff)</OPTION>
	<OPTION VALUE="6">Executive (SVP, EVP, VP)</OPTION>
	<OPTION VALUE="7">Senior Executive (President, CEO)</OPTION>
	</select>
	</td>
	</tr>
	
	<tr><td>Salary: </td>
	<td>
	<input size=10 type=text name=salary2 value=<?=$a1[salary]?>> 
	<select name=s_period2>
	<option value=Yearly> Yearly </option>
	<option value=Monthly>Monthly </option>
	</select>
	</td></tr>

	<tr>
	<td align=right>
	</td><td>	<input type=hidden name=job_id22 value=<?=$job_ed?>>
	<input type=submit name=submit value="Save changes">
</td>
	
	</tr>
</table>
</form>



<? include_once('../foother.html'); ?>