<?
include_once "accesscontrol.php";

if(isset($submit))
{
	if(empty($_POST[NewName]))
	{
		echo "<center><font color=red><b> Company name filed is blank. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewCountry]))
	{
		echo "<center><font color=red><b> Choose your country, please. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewState]))
	{
		echo "<center><font color=red><b> Choose your state, please. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewZip]))
	{
		echo "<center><font color=red><b> Zip code filed is blank. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewCity]))
	{
		echo "<center><font color=red><b> City filed is blank. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewAddress]))
	{
		echo "<center><font color=red><b> Address filed is blank. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewPhone]))
	{
		echo "<center><font color=red><b> Phone filed is blank. </b></font></center>";
		exit();
	}
	if(empty($_POST[NewEmail]))
	{
		echo "<center><font color=red><b> Email filed is blank. </b></font></center>";
		exit();
	}

	$q2 = "update job_employer_info set 
		CompanyName = \"$_POST[NewName]\",
		CompanyCountry = \"$_POST[NewCountry]\",
		CompanyState = \"$_POST[NewState]\",
		CompanyZip = \"$_POST[NewZip]\",
		CompanyCity = \"$_POST[NewCity]\",
		CompanyAddress = \"$_POST[NewAddress]\",
		CompanyPhone = \"$_POST[NewPhone]\",
		CompanyPhone2 = \"$_POST[NewPhone2]\",
		CompanyEmail = \"$_POST[NewEmail]\"

		where ename = \"$_SESSION[ename]\" ";
	$r2 = mysql_query($q2) or die(mysql_error());

	echo "<center> Your acount information was updated successfull. </center>";

}

$q1 = "select * from job_employer_info where ename = \"$_SESSION[ename]\"";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

?>

<form method=post  style="background:none;">
<table align=center>
<tr>
	<td> Company name: </td>
	<td><input type=text name=NewName value="<?=$a1[CompanyName]?>"></td>
</tr>

<tr>
	<td> Country: </td>
	<td>
		<select name=NewCountry>
<OPTION VALUE="">Select</OPTION>	
<OPTION VALUE="Afghanistan">Afghanistan</OPTION>
<OPTION VALUE="Albania">Albania</OPTION>
<OPTION VALUE="Algeria">Algeria</OPTION>
<OPTION VALUE="American Samoa">American Samoa</OPTION>
<OPTION VALUE="Andorra">Andorra</OPTION>
<OPTION VALUE="Angola">Angola</OPTION>
<OPTION VALUE="Anguilla">Anguilla</OPTION>
<OPTION VALUE="Antartica">Antartica</OPTION>
<OPTION VALUE="Antigua and Barbuda">Antigua and Barbuda</OPTION>
<OPTION VALUE="Argentina">Argentina</OPTION>
<OPTION VALUE="Armenia">Armenia</OPTION>
<OPTION VALUE="Aruba">Aruba</OPTION>
<OPTION VALUE="Australia">Australia</OPTION>
<OPTION VALUE="Austria">Austria</OPTION>
<OPTION VALUE="Azerbaidjan">Azerbaidjan</OPTION>
<OPTION VALUE="Bahamas">Bahamas</OPTION>
<OPTION VALUE="Bahrain">Bahrain</OPTION>
<OPTION VALUE="Bangladesh">Bangladesh</OPTION>
<OPTION VALUE="Barbados">Barbados</OPTION>
<OPTION VALUE="Belarus">Belarus</OPTION>
<OPTION VALUE="Belgium">Belgium</OPTION>
<OPTION VALUE="Belize">Belize</OPTION>
<OPTION VALUE="Benin">Benin</OPTION>
<OPTION VALUE="Bermuda">Bermuda</OPTION>
<OPTION VALUE="Bhutan">Bhutan</OPTION>
<OPTION VALUE="Bolivia">Bolivia</OPTION>
<OPTION VALUE="Bosnia-Herzegovina">Bosnia-Herzegovina</OPTION>
<OPTION VALUE="Botswana">Botswana</OPTION>
<OPTION VALUE="Bouvet Island">Bouvet Island</OPTION>
<OPTION VALUE="Brazil">Brazil</OPTION>
<OPTION VALUE="British Indian Ocean Territory">British Indian Ocean Territory</OPTION>
<OPTION VALUE="Brunei Darussalam">Brunei Darussalam</OPTION>
<OPTION VALUE="Bulgaria">Bulgaria</OPTION>
<OPTION VALUE="Burkina Faso">Burkina Faso</OPTION>
<OPTION VALUE="Burundi">Burundi</OPTION>
<OPTION VALUE="Cambodia">Cambodia</OPTION>
<OPTION VALUE="Cameroon">Cameroon</OPTION>
<OPTION VALUE="Canada">Canada</OPTION>
<OPTION VALUE="Cape Verde">Cape Verde</OPTION>
<OPTION VALUE="Cayman Islands">Cayman Islands</OPTION>
<OPTION VALUE="Central African Republic">Central African Republic</OPTION>
<OPTION VALUE="Chad">Chad</OPTION>
<OPTION VALUE="Chile">Chile</OPTION>
<OPTION VALUE="China">China</OPTION>
<OPTION VALUE="Christmas Island">Christmas Island</OPTION>
<OPTION VALUE="Cocos (Keeling) Islands">Cocos (Keeling) Islands</OPTION>
<OPTION VALUE="Colombia">Colombia</OPTION>
<OPTION VALUE="Comoros">Comoros</OPTION>
<OPTION VALUE="Congo">Congo</OPTION>
<OPTION VALUE="Cook Islands">Cook Islands</OPTION>
<OPTION VALUE="Costa Rica">Costa Rica</OPTION>
<OPTION VALUE="Croatia">Croatia</OPTION>
<OPTION VALUE="Cuba">Cuba</OPTION>
<OPTION VALUE="Cyprus">Cyprus</OPTION>
<OPTION VALUE="Czech Republic">Czech Republic</OPTION>
<OPTION VALUE="Denmark">Denmark</OPTION>
<OPTION VALUE="Djibouti">Djibouti</OPTION>
<OPTION VALUE="Dominica">Dominica</OPTION>
<OPTION VALUE="Dominican Republic">Dominican Republic</OPTION>
<OPTION VALUE="East Timor">East Timor</OPTION>
<OPTION VALUE="Ecuador">Ecuador</OPTION>
<OPTION VALUE="Egypt">Egypt</OPTION>
<OPTION VALUE="El Salvador">El Salvador</OPTION>
<OPTION VALUE="Equatorial Guinea">Equatorial Guinea</OPTION>
<OPTION VALUE="Eritrea">Eritrea</OPTION>
<OPTION VALUE="Estonia">Estonia</OPTION>
<OPTION VALUE="Ethiopia">Ethiopia</OPTION>
<OPTION VALUE="Falkland Islands">Falkland Islands</OPTION>
<OPTION VALUE="Faroe Islands">Faroe Islands</OPTION>
<OPTION VALUE="Fiji">Fiji</OPTION>
<OPTION VALUE="Finland">Finland</OPTION>
<OPTION VALUE="Former USSR">Former USSR</OPTION>
<OPTION VALUE="France">France</OPTION>
<OPTION VALUE="France (European Territory)">France (European Territory)</OPTION>
<OPTION VALUE="French Guyana">French Guyana</OPTION>
<OPTION VALUE="French Southern Territories">French Southern Territories</OPTION>
<OPTION VALUE="Gabon">Gabon</OPTION>
<OPTION VALUE="Gambia">Gambia</OPTION>
<OPTION VALUE="Georgia">Georgia</OPTION>
<OPTION VALUE="Germany">Germany</OPTION>
<OPTION VALUE="Ghana">Ghana</OPTION>
<OPTION VALUE="Gibraltar">Gibraltar</OPTION>
<OPTION VALUE="Greece">Greece</OPTION>
<OPTION VALUE="Greenland">Greenland</OPTION>
<OPTION VALUE="Grenada">Grenada</OPTION>
<OPTION VALUE="Guadeloupe (French)">Guadeloupe (French)</OPTION>
<OPTION VALUE="Guam">Guam</OPTION>
<OPTION VALUE="Guatemala">Guatemala</OPTION>
<OPTION VALUE="Guinea">Guinea</OPTION>
<OPTION VALUE="Guinea Bissau">Guinea Bissau</OPTION>
<OPTION VALUE="Guyana">Guyana</OPTION>
<OPTION VALUE="Haiti">Haiti</OPTION>
<OPTION VALUE="Heard and McDonald Islands">Heard and McDonald Islands</OPTION>
<OPTION VALUE="Honduras">Honduras</OPTION>
<OPTION VALUE="Hong Kong">Hong Kong</OPTION>
<OPTION VALUE="Hungary">Hungary</OPTION>
<OPTION VALUE="Iceland">Iceland</OPTION>
<OPTION VALUE="India">India</OPTION>
<OPTION VALUE="Indonesia">Indonesia</OPTION>
<OPTION VALUE="Iran">Iran</OPTION>
<OPTION VALUE="Iraq">Iraq</OPTION>
<OPTION VALUE="Ireland">Ireland</OPTION>
<OPTION VALUE="Israel">Israel</OPTION>
<OPTION VALUE="Italy">Italy</OPTION>
<OPTION VALUE="Ivory Coast">Ivory Coast</OPTION>
<OPTION VALUE="Jamaica">Jamaica</OPTION>
<OPTION VALUE="Japan">Japan</OPTION>
<OPTION VALUE="Jordan">Jordan</OPTION>
<OPTION VALUE="Kazakhstan">Kazakhstan</OPTION>
<OPTION VALUE="Kenya">Kenya</OPTION>
<OPTION VALUE="Kiribati">Kiribati</OPTION>
<OPTION VALUE="Kuwait">Kuwait</OPTION>
<OPTION VALUE="Kyrgyzstan">Kyrgyzstan</OPTION>
<OPTION VALUE="Laos">Laos</OPTION>
<OPTION VALUE="Latvia">Latvia</OPTION>
<OPTION VALUE="Lebanon">Lebanon</OPTION>
<OPTION VALUE="Lesotho">Lesotho</OPTION>
<OPTION VALUE="Liberia">Liberia</OPTION>
<OPTION VALUE="Libya">Libya</OPTION>
<OPTION VALUE="Liechtenstein">Liechtenstein</OPTION>
<OPTION VALUE="Lithuania">Lithuania</OPTION>
<OPTION VALUE="Luxembourg">Luxembourg</OPTION>
<OPTION VALUE="Macau">Macau</OPTION>
<OPTION VALUE="Macedonia">Macedonia</OPTION>
<OPTION VALUE="Madagascar">Madagascar</OPTION>
<OPTION VALUE="Malawi">Malawi</OPTION>
<OPTION VALUE="Malaysia">Malaysia</OPTION>
<OPTION VALUE="Maldives">Maldives</OPTION>
<OPTION VALUE="Mali">Mali</OPTION>
<OPTION VALUE="Malta">Malta</OPTION>
<OPTION VALUE="Marshall Islands">Marshall Islands</OPTION>
<OPTION VALUE="Martinique (French)">Martinique (French)</OPTION>
<OPTION VALUE="Mauritania">Mauritania</OPTION>
<OPTION VALUE="Mauritius">Mauritius</OPTION>
<OPTION VALUE="Mayotte">Mayotte</OPTION>
<OPTION VALUE="Mexico">Mexico</OPTION>
<OPTION VALUE="Micronesia">Micronesia</OPTION>
<OPTION VALUE="Moldavia">Moldavia</OPTION>
<OPTION VALUE="Monaco">Monaco</OPTION>
<OPTION VALUE="Mongolia">Mongolia</OPTION>
<OPTION VALUE="Montserrat">Montserrat</OPTION>
<OPTION VALUE="Morocco">Morocco</OPTION>
<OPTION VALUE="Mozambique">Mozambique</OPTION>
<OPTION VALUE="Myanmar, Union of (Burma)">Myanmar, Union of (Burma)</OPTION>
<OPTION VALUE="Namibia">Namibia</OPTION>
<OPTION VALUE="Nauru">Nauru</OPTION>
<OPTION VALUE="Nepal">Nepal</OPTION>
<OPTION VALUE="Netherlands">Netherlands</OPTION>
<OPTION VALUE="Netherlands Antilles">Netherlands Antilles</OPTION>
<OPTION VALUE="Neutral Zone">Neutral Zone</OPTION>
<OPTION VALUE="New Caledonia (French)">New Caledonia (French)</OPTION>
<OPTION VALUE="New Zealand">New Zealand</OPTION>
<OPTION VALUE="Nicaragua">Nicaragua</OPTION>
<OPTION VALUE="Niger">Niger</OPTION>
<OPTION VALUE="Nigeria">Nigeria</OPTION>
<OPTION VALUE="Niue">Niue</OPTION>
<OPTION VALUE="Norfolk Island">Norfolk Island</OPTION>
<OPTION VALUE="North Korea">North Korea</OPTION>
<OPTION VALUE="Northern Mariana Islands">Northern Mariana Islands</OPTION>
<OPTION VALUE="Norway">Norway</OPTION>
<OPTION VALUE="Oman">Oman</OPTION>
<OPTION VALUE="Pakistan">Pakistan</OPTION>
<OPTION VALUE="Palau">Palau</OPTION>
<OPTION VALUE="Panama">Panama</OPTION>
<OPTION VALUE="Papua New Guinea">Papua New Guinea</OPTION>
<OPTION VALUE="Paraguay">Paraguay</OPTION>
<OPTION VALUE="Peru">Peru</OPTION>
<OPTION VALUE="Philippines">Philippines</OPTION>
<OPTION VALUE="Pitcairn Island">Pitcairn Island</OPTION>
<OPTION VALUE="Poland">Poland</OPTION>
<OPTION VALUE="Polynesia (French)">Polynesia (French)</OPTION>
<OPTION VALUE="Portugal">Portugal</OPTION>
<OPTION VALUE="Qatar">Qatar</OPTION>
<OPTION VALUE="Reunion (French)">Reunion (French)</OPTION>
<OPTION VALUE="Romania">Romania</OPTION>
<OPTION VALUE="Russian Federation">Russian Federation</OPTION>
<OPTION VALUE="Rwanda">Rwanda</OPTION>
<OPTION VALUE="S. Georgia &amp; S. Sandwich Islands">S. Georgia &amp; S. Sandwich Islands</OPTION>
<OPTION VALUE="Saint Helena">Saint Helena</OPTION>
<OPTION VALUE="Saint Kitts &amp; Nevis Anguilla">Saint Kitts &amp; Nevis Anguilla</OPTION>
<OPTION VALUE="Saint Lucia">Saint Lucia</OPTION>
<OPTION VALUE="Saint Pierre and Miquelon">Saint Pierre and Miquelon</OPTION>
<OPTION VALUE="Saint Tome and Principe">Saint Tome and Principe</OPTION>
<OPTION VALUE="Saint Vincent &amp; Grenadines">Saint Vincent &amp; Grenadines</OPTION>
<OPTION VALUE="Samoa">Samoa</OPTION>
<OPTION VALUE="San Marino">San Marino</OPTION>
<OPTION VALUE="Saudi Arabia">Saudi Arabia</OPTION>
<OPTION VALUE="Senegal">Senegal</OPTION>
<OPTION VALUE="Seychelles">Seychelles</OPTION>
<OPTION VALUE="Sierra Leone">Sierra Leone</OPTION>
<OPTION VALUE="Singapore">Singapore</OPTION>
<OPTION VALUE="Slovakia">Slovakia</OPTION>
<OPTION VALUE="Slovenia">Slovenia</OPTION>
<OPTION VALUE="Solomon Islands">Solomon Islands</OPTION>
<OPTION VALUE="Somalia">Somalia</OPTION>
<OPTION VALUE="South Africa">South Africa</OPTION>
<OPTION VALUE="South Korea">South Korea</OPTION>
<OPTION VALUE="Spain">Spain</OPTION>
<OPTION VALUE="Sri Lanka">Sri Lanka</OPTION>
<OPTION VALUE="Sudan">Sudan</OPTION>
<OPTION VALUE="Suriname">Suriname</OPTION>
<OPTION VALUE="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</OPTION>
<OPTION VALUE="Swaziland">Swaziland</OPTION>
<OPTION VALUE="Sweden">Sweden</OPTION>
<OPTION VALUE="Switzerland">Switzerland</OPTION>
<OPTION VALUE="Syria">Syria</OPTION>
<OPTION VALUE="Tadjikistan">Tadjikistan</OPTION>
<OPTION VALUE="Taiwan">Taiwan</OPTION>
<OPTION VALUE="Tanzania">Tanzania</OPTION>
<OPTION VALUE="Thailand">Thailand</OPTION>
<OPTION VALUE="Togo">Togo</OPTION>
<OPTION VALUE="Tokelau">Tokelau</OPTION>
<OPTION VALUE="Tonga">Tonga</OPTION>
<OPTION VALUE="Trinidad and Tobago">Trinidad and Tobago</OPTION>
<OPTION VALUE="Tunisia">Tunisia</OPTION>
<OPTION VALUE="Turkey">Turkey</OPTION>
<OPTION VALUE="Turkmenistan">Turkmenistan</OPTION>
<OPTION VALUE="Turks and Caicos Islands">Turks and Caicos Islands</OPTION>
<OPTION VALUE="Tuvalu">Tuvalu</OPTION>
<OPTION VALUE="Uganda">Uganda</OPTION>
<OPTION VALUE="UK">UK</OPTION>
<OPTION VALUE="Ukraine">Ukraine</OPTION>
<OPTION VALUE="United Arab Emirates">United Arab Emirates</OPTION>
<OPTION VALUE="Uruguay">Uruguay</OPTION>
<OPTION VALUE="US">US</OPTION>
<OPTION VALUE="USA Minor Outlying Islands">USA Minor Outlying Islands</OPTION>
<OPTION VALUE="Uzbekistan">Uzbekistan</OPTION>
<OPTION VALUE="Vanuatu">Vanuatu</OPTION>
<OPTION VALUE="Vatican City">Vatican City</OPTION>
<OPTION VALUE="Venezuela">Venezuela</OPTION>
<OPTION VALUE="Vietnam">Vietnam</OPTION>
<OPTION VALUE="Virgin Islands (British)">Virgin Islands (British)</OPTION>
<OPTION VALUE="Virgin Islands (USA)">Virgin Islands (USA)</OPTION>
<OPTION VALUE="Wallis and Futuna Islands">Wallis and Futuna Islands</OPTION>
<OPTION VALUE="Western Sahara">Western Sahara</OPTION>
<OPTION VALUE="Yemen">Yemen</OPTION>
<OPTION VALUE="Yugoslavia">Yugoslavia</OPTION>
<OPTION VALUE="Zaire">Zaire</OPTION>
<OPTION VALUE="Zambia">Zambia</OPTION>
<OPTION VALUE="Zimbabwe">Zimbabwe</OPTION>
	</select>
	</td>
</tr>

<tr>
	<td>State: </td>
	<td>
		<select name=NewState>
<option value="">Select </option>
<OPTION VALUE="Not in US">Not in US</OPTION>
<OPTION VALUE="Alabama">Alabama</OPTION>
<OPTION VALUE="Alaska">Alaska</OPTION>
<OPTION VALUE="Arizona">Arizona</OPTION>
<OPTION VALUE="Arkansas">Arkansas</OPTION>
<OPTION VALUE="California">California</OPTION>
<OPTION VALUE="Colorado">Colorado</OPTION>
<OPTION VALUE="Connecticut">Connecticut</OPTION>
<OPTION VALUE="Delaware">Delaware</OPTION>
<OPTION VALUE="District of Columbia">District of Columbia</OPTION>
<OPTION VALUE="Florida">Florida</OPTION>
<OPTION VALUE="Georgia">Georgia</OPTION>
<OPTION VALUE="Hawaii">Hawaii</OPTION>
<OPTION VALUE="Idaho">Idaho</OPTION>
<OPTION VALUE="Illinois">Illinois</OPTION>
<OPTION VALUE="Indiana">Indiana</OPTION>
<OPTION VALUE="Iowa">Iowa</OPTION>
<OPTION VALUE="Kansas">Kansas</OPTION>
<OPTION VALUE="Kentucky">Kentucky</OPTION>
<OPTION VALUE="Louisiana">Louisiana</OPTION>
<OPTION VALUE="Maine">Maine</OPTION>
<OPTION VALUE="Maryland">Maryland</OPTION>
<OPTION VALUE="Massachusetts">Massachusetts</OPTION>
<OPTION VALUE="Michigan">Michigan</OPTION>
<OPTION VALUE="Minnesota">Minnesota</OPTION>
<OPTION VALUE="Mississippi">Mississippi</OPTION>
<OPTION VALUE="Missouri">Missouri</OPTION>
<OPTION VALUE="Montana">Montana</OPTION>
<OPTION VALUE="Nebraska">Nebraska</OPTION>
<OPTION VALUE="Nevada">Nevada</OPTION>
<OPTION VALUE="New Hampshire">New Hampshire</OPTION>
<OPTION VALUE="New Jersey">New Jersey</OPTION>
<OPTION VALUE="New Mexico">New Mexico</OPTION>
<OPTION VALUE="New York">New York</OPTION>
<OPTION VALUE="North Carolina">North Carolina</OPTION>
<OPTION VALUE="North Dakota">North Dakota</OPTION>
<OPTION VALUE="Ohio">Ohio</OPTION>
<OPTION VALUE="Oklahoma">Oklahoma</OPTION>
<OPTION VALUE="Oregon">Oregon</OPTION>
<OPTION VALUE="Pennsylvania">Pennsylvania</OPTION>
<OPTION VALUE="Puerto Rico">Puerto Rico</OPTION>
<OPTION VALUE="Rhode Island">Rhode Island</OPTION>
<OPTION VALUE="South Carolina">South Carolina</OPTION>
<OPTION VALUE="South Dakota">South Dakota</OPTION>
<OPTION VALUE="Tennessee">Tennessee</OPTION>
<OPTION VALUE="Texas">Texas</OPTION>
<OPTION VALUE="Utah">Utah</OPTION>
<OPTION VALUE="Vermont">Vermont</OPTION>
<OPTION VALUE="Virgin Islands">Virgin Islands</OPTION>
<OPTION VALUE="Virginia">Virginia</OPTION>
<OPTION VALUE="Washington">Washington</OPTION>
<OPTION VALUE="West Virginia">West Virginia</OPTION>
<OPTION VALUE="Wisconsin">Wisconsin</OPTION>
<OPTION VALUE="Wyoming">Wyoming</OPTION>
	</select>
	</td>
</tr>

<tr>
	<td>Zip </td>
	<td><input type=text name=NewZip value="<?=$a1[CompanyZip]?>"></td>
</tr>

<tr>
	<td>City </td>
	<td><input type=text name=NewCity value="<?=$a1[CompanyCity]?>"></td>
</tr>

<tr>
	<td>Address </td>
	<td><input type=text name=NewAddress value="<?=$a1[CompanyAddress]?>"></td>
</tr>

<tr>
	<td>Phone </td>
	<td><input type=text name=NewPhone value="<?=$a1[CompanyPhone]?>"></td>
</tr>

<tr>
	<td>Phone 2 </td>
	<td><input type=text name=NewPhone2 value="<?=$a1[CompanyPhone2]?>"></td>
</tr>

<tr>
	<td>Email </td>
	<td><input type=text name=NewEmail value="<?=$a1[CompanyEmail]?>"></td>
</tr>

<tr>
	<td colspan=2 align=center>
	<input type=submit value=submit name=submit>
	</td>
</tr>
</table>
</form>









<? include_once('../foother.html'); ?>