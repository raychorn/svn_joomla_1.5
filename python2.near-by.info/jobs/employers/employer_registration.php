<?
session_start();
include_once "../main.php";
?>
<script language="JavaScript">
function chk()
{
	if (document.form.ename.value=='') 
	{
		alert("Please enter name");
		document.form.ename.focus();
		return false;
	}
	if (document.form.epass.value=='') 
	{
		alert("Please enter password");
		document.form.epass.focus();
		return false;
	}
	if (document.form.cpass.value=='') 
	{
		alert("Please enter password");
		document.form.cpass.focus();
		return false;
	}
	if (document.form.epass.value != document.form.cpass.value)
	{
		alert("Passwords donot match");
		document.form.epass.focus();
		return false;
	}
	if (document.form.CompanyName.value=='') 
	{
		alert("Please enter company name");
		document.form.CompanyName.focus();
		return false;
	}
	if (document.form.CompanyCountry.value=='') 
	{
		alert("Please select country");
		document.form.CompanyCountry.focus();
		return false;
	}
	if (document.form.CompanyZip.value=='') 
	{
		alert("Please enter zip code");
		document.form.CompanyZip.focus();
		return false;
	}
		if (document.form.CompanyCity.value=='') 
	{
		alert("Please enter city name");
		document.form.CompanyCity.focus();
		return false;
	}

	if (document.form.CompanyAddress.value=='') 
	{
		alert("Please enter address");
		document.form.CompanyAddress.focus();
		return false;
	}

	if (document.form.CompanyPhone.value=='') 
	{
		alert("Please enter  phone");
		document.form.CompanyPhone.focus();
		return false;
	}
	if (document.form.CompanyEmail.value=='') 
	{
		alert("Please enter email addreess");
		document.form.CompanyEmail.focus();
		return false;
	}
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.CompanyEmail.value))
		{
				return (true)
		}
		else
		{
				alert("Invalid E-mail Address! Please re-enter.")
				document.form.CompanyEmail.focus()
				return (false)
		}		
		

return true;		
}
</script>
<form action=employer_registration2.php method=post name="form" onSubmit="return chk();"  style="background:none;">
<table align=center width=446 cellspacing=0 cellpadding="5" bgcolor="#FFFFFF">

<tr>
	<td valign=middle>
	Username:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=ename maxlength=10><br> <font size=1>max. 10 symbols (letters and/or numbers) </font>
	</td>
</tr>

<tr>
	<td>
	Password:<font color=red>*</font>
	</td>

	<td>
	<input type=password name=epass maxlength=10><br> <font size=1>max. 10 symbols (letters and/or numbers) </font>
	</td>
</tr>

<tr>
	<td>
	Confirm password:<font color=red>*</font>
	</td>

	<td>
	<input type=password name=cpass maxlength=10>
	</td>
</tr>

<tr>
	<td>
	Company name:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=CompanyName>
	</td>
</tr>

<tr>
	<td>
	Country:<font color=red>*</font>
	</td>

	<td>
	<select name=CompanyCountry>
          <option value="UK">UK</option>
          <option value="Afghanistan">Afghanistan</option>
          <option value="Albania">Albania</option>
          <option value="Algeria">Algeria</option>
          <option value="American Samoa">American Samoa</option>
          <option value="Andorra">Andorra</option>
          <option value="Angola">Angola</option>
          <option value="Anguilla">Anguilla</option>
          <option value="Antartica">Antartica</option>
          <option value="Antigua and Barbuda">Antigua and Barbuda</option>
          <option value="Argentina">Argentina</option>
          <option value="Armenia">Armenia</option>
          <option value="Aruba">Aruba</option>
          <option value="Australia">Australia</option>
          <option value="Austria">Austria</option>
          <option value="Azerbaidjan">Azerbaidjan</option>
          <option value="Bahamas">Bahamas</option>
          <option value="Bahrain">Bahrain</option>
          <option value="Bangladesh">Bangladesh</option>
          <option value="Barbados">Barbados</option>
          <option value="Belarus">Belarus</option>
          <option value="Belgium">Belgium</option>
          <option value="Belize">Belize</option>
          <option value="Benin">Benin</option>
          <option value="Bermuda">Bermuda</option>
          <option value="Bhutan">Bhutan</option>
          <option value="Bolivia">Bolivia</option>
          <option value="Bosnia-Herzegovina">Bosnia-Herzegovina</option>
          <option value="Botswana">Botswana</option>
          <option value="Bouvet Island">Bouvet Island</option>
          <option value="Brazil">Brazil</option>
          <option value="British Indian Ocean Territory">British Indian Ocean 
          Territory</option>
          <option value="Brunei Darussalam">Brunei Darussalam</option>
          <option value="Bulgaria">Bulgaria</option>
          <option value="Burkina Faso">Burkina Faso</option>
          <option value="Burundi">Burundi</option>
          <option value="Cambodia">Cambodia</option>
          <option value="Cameroon">Cameroon</option>
          <option value="Canada">Canada</option>
          <option value="Cape Verde">Cape Verde</option>
          <option value="Cayman Islands">Cayman Islands</option>
          <option value="Central African Republic">Central African Republic</option>
          <option value="Chad">Chad</option>
          <option value="Chile">Chile</option>
          <option value="China">China</option>
          <option value="Christmas Island">Christmas Island</option>
          <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
          <option value="Colombia">Colombia</option>
          <option value="Comoros">Comoros</option>
          <option value="Congo">Congo</option>
          <option value="Cook Islands">Cook Islands</option>
          <option value="Costa Rica">Costa Rica</option>
          <option value="Croatia">Croatia</option>
          <option value="Cuba">Cuba</option>
          <option value="Cyprus">Cyprus</option>
          <option value="Czech Republic">Czech Republic</option>
          <option value="Denmark">Denmark</option>
          <option value="Djibouti">Djibouti</option>
          <option value="Dominica">Dominica</option>
          <option value="Dominican Republic">Dominican Republic</option>
          <option value="East Timor">East Timor</option>
          <option value="Ecuador">Ecuador</option>
          <option value="Egypt">Egypt</option>
          <option value="El Salvador">El Salvador</option>
          <option value="Equatorial Guinea">Equatorial Guinea</option>
          <option value="Eritrea">Eritrea</option>
          <option value="Estonia">Estonia</option>
          <option value="Ethiopia">Ethiopia</option>
          <option value="Falkland Islands">Falkland Islands</option>
          <option value="Faroe Islands">Faroe Islands</option>
          <option value="Fiji">Fiji</option>
          <option value="Finland">Finland</option>
          <option value="Former USSR">Former USSR</option>
          <option value="France">France</option>
          <option value="France (European Territory)">France (European Territory)</option>
          <option value="French Guyana">French Guyana</option>
          <option value="French Southern Territories">French Southern Territories</option>
          <option value="Gabon">Gabon</option>
          <option value="Gambia">Gambia</option>
          <option value="Georgia">Georgia</option>
          <option value="Germany">Germany</option>
          <option value="Ghana">Ghana</option>
          <option value="Gibraltar">Gibraltar</option>
          <option value="Greece">Greece</option>
          <option value="Greenland">Greenland</option>
          <option value="Grenada">Grenada</option>
          <option value="Guadeloupe (French)">Guadeloupe (French)</option>
          <option value="Guam">Guam</option>
          <option value="Guatemala">Guatemala</option>
          <option value="Guinea">Guinea</option>
          <option value="Guinea Bissau">Guinea Bissau</option>
          <option value="Guyana">Guyana</option>
          <option value="Haiti">Haiti</option>
          <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
          <option value="Honduras">Honduras</option>
          <option value="Hong Kong">Hong Kong</option>
          <option value="Hungary">Hungary</option>
          <option value="Iceland">Iceland</option>
          <option value="India">India</option>
          <option value="Indonesia">Indonesia</option>
          <option value="Iran">Iran</option>
          <option value="Iraq">Iraq</option>
          <option value="Ireland">Ireland</option>
          <option value="Israel">Israel</option>
          <option value="Italy">Italy</option>
          <option value="Ivory Coast">Ivory Coast</option>
          <option value="Jamaica">Jamaica</option>
          <option value="Japan">Japan</option>
          <option value="Jordan">Jordan</option>
          <option value="Kazakhstan">Kazakhstan</option>
          <option value="Kenya">Kenya</option>
          <option value="Kiribati">Kiribati</option>
          <option value="Kuwait">Kuwait</option>
          <option value="Kyrgyzstan">Kyrgyzstan</option>
          <option value="Laos">Laos</option>
          <option value="Latvia">Latvia</option>
          <option value="Lebanon">Lebanon</option>
          <option value="Lesotho">Lesotho</option>
          <option value="Liberia">Liberia</option>
          <option value="Libya">Libya</option>
          <option value="Liechtenstein">Liechtenstein</option>
          <option value="Lithuania">Lithuania</option>
          <option value="Luxembourg">Luxembourg</option>
          <option value="Macau">Macau</option>
          <option value="Macedonia">Macedonia</option>
          <option value="Madagascar">Madagascar</option>
          <option value="Malawi">Malawi</option>
          <option value="Malaysia">Malaysia</option>
          <option value="Maldives">Maldives</option>
          <option value="Mali">Mali</option>
          <option value="Malta">Malta</option>
          <option value="Marshall Islands">Marshall Islands</option>
          <option value="Martinique (French)">Martinique (French)</option>
          <option value="Mauritania">Mauritania</option>
          <option value="Mauritius">Mauritius</option>
          <option value="Mayotte">Mayotte</option>
          <option value="Mexico">Mexico</option>
          <option value="Micronesia">Micronesia</option>
          <option value="Moldavia">Moldavia</option>
          <option value="Monaco">Monaco</option>
          <option value="Mongolia">Mongolia</option>
          <option value="Montserrat">Montserrat</option>
          <option value="Morocco">Morocco</option>
          <option value="Mozambique">Mozambique</option>
          <option value="Myanmar, Union of (Burma)">Myanmar, Union of (Burma)</option>
          <option value="Namibia">Namibia</option>
          <option value="Nauru">Nauru</option>
          <option value="Nepal">Nepal</option>
          <option value="Netherlands">Netherlands</option>
          <option value="Netherlands Antilles">Netherlands Antilles</option>
          <option value="Neutral Zone">Neutral Zone</option>
          <option value="New Caledonia (French)">New Caledonia (French)</option>
          <option value="New Zealand">New Zealand</option>
          <option value="Nicaragua">Nicaragua</option>
          <option value="Niger">Niger</option>
          <option value="Nigeria">Nigeria</option>
          <option value="Niue">Niue</option>
          <option value="Norfolk Island">Norfolk Island</option>
          <option value="North Korea">North Korea</option>
          <option value="Northern Mariana Islands">Northern Mariana Islands</option>
          <option value="Norway">Norway</option>
          <option value="Oman">Oman</option>
          <option value="Pakistan">Pakistan</option>
          <option value="Palau">Palau</option>
          <option value="Panama">Panama</option>
          <option value="Papua New Guinea">Papua New Guinea</option>
          <option value="Paraguay">Paraguay</option>
          <option value="Peru">Peru</option>
          <option value="Philippines">Philippines</option>
          <option value="Pitcairn Island">Pitcairn Island</option>
          <option value="Poland">Poland</option>
          <option value="Polynesia (French)">Polynesia (French)</option>
          <option value="Portugal">Portugal</option>
          <option value="Qatar">Qatar</option>
          <option value="Reunion (French)">Reunion (French)</option>
          <option value="Romania">Romania</option>
          <option value="Russian Federation">Russian Federation</option>
          <option value="Rwanda">Rwanda</option>
          <option value="S. Georgia &amp; S. Sandwich Islands">S. Georgia &amp; 
          S. Sandwich Islands</option>
          <option value="Saint Helena">Saint Helena</option>
          <option value="Saint Kitts &amp; Nevis Anguilla">Saint Kitts &amp; Nevis 
          Anguilla</option>
          <option value="Saint Lucia">Saint Lucia</option>
          <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
          <option value="Saint Tome and Principe">Saint Tome and Principe</option>
          <option value="Saint Vincent &amp; Grenadines">Saint Vincent &amp; Grenadines</option>
          <option value="Samoa">Samoa</option>
          <option value="San Marino">San Marino</option>
          <option value="Saudi Arabia">Saudi Arabia</option>
          <option value="Senegal">Senegal</option>
          <option value="Seychelles">Seychelles</option>
          <option value="Sierra Leone">Sierra Leone</option>
          <option value="Singapore">Singapore</option>
          <option value="Slovakia">Slovakia</option>
          <option value="Slovenia">Slovenia</option>
          <option value="Solomon Islands">Solomon Islands</option>
          <option value="Somalia">Somalia</option>
          <option value="South Africa">South Africa</option>
          <option value="South Korea">South Korea</option>
          <option value="Spain">Spain</option>
          <option value="Sri Lanka">Sri Lanka</option>
          <option value="Sudan">Sudan</option>
          <option value="Suriname">Suriname</option>
          <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen 
          Islands</option>
          <option value="Swaziland">Swaziland</option>
          <option value="Sweden">Sweden</option>
          <option value="Switzerland">Switzerland</option>
          <option value="Syria">Syria</option>
          <option value="Tadjikistan">Tadjikistan</option>
          <option value="Taiwan">Taiwan</option>
          <option value="Tanzania">Tanzania</option>
          <option value="Thailand">Thailand</option>
          <option value="Togo">Togo</option>
          <option value="Tokelau">Tokelau</option>
          <option value="Tonga">Tonga</option>
          <option value="Trinidad and Tobago">Trinidad and Tobago</option>
          <option value="Tunisia">Tunisia</option>
          <option value="Turkey">Turkey</option>
          <option value="Turkmenistan">Turkmenistan</option>
          <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
          <option value="Tuvalu">Tuvalu</option>
          <option value="Uganda">Uganda</option>
          <option value="Ukraine">Ukraine</option>
          <option value="United Arab Emirates">United Arab Emirates</option>
          <option value="Uruguay">Uruguay</option>
          <option value="US">US</option>
          <option value="USA Minor Outlying Islands">USA Minor Outlying Islands</option>
          <option value="Uzbekistan">Uzbekistan</option>
          <option value="Vanuatu">Vanuatu</option>
          <option value="Vatican City">Vatican City</option>
          <option value="Venezuela">Venezuela</option>
          <option value="Vietnam">Vietnam</option>
          <option value="Virgin Islands (British)">Virgin Islands (British)</option>
          <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
          <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
          <option value="Western Sahara">Western Sahara</option>
          <option value="Yemen">Yemen</option>
          <option value="Yugoslavia">Yugoslavia</option>
          <option value="Zaire">Zaire</option>
          <option value="Zambia">Zambia</option>
          <option value="Zimbabwe">Zimbabwe</option>
        </select>
	</td>
</tr>

<tr>
	<td>
	State:
	</td>

	<td>
		<select name=CompanyState>
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
	  <td> Post Code::<font color=red>*</font> </td>

	<td>
	<input type=text name=CompanyZip>
	</td>
</tr>

<tr>
	<td>
	City:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=CompanyCity>
	</td>
</tr>

<tr>
	<td>
	Address:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=CompanyAddress>
	</td>
		
</tr>

<tr>
	<td>
	Phone:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=CompanyPhone>
	</td>
</tr>
	
    <tr> 
      <td>Mobile:</td>

	<td>
	<input type=text name=CompanyPhone2>
	</td>
</tr>

<tr>
	<td>
	E-mail:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=CompanyEmail>
	</td>
</tr>

<tr>
	<td align=left>&nbsp;	</td>

	<td align=left>
	  <input type=submit name=submit value="Register me">
	  <input type=reset name=reset value="Reset">
	</td>
</tr>
	
</table>
	
</form>

</body>
</html>
<? include_once('../foother.html'); ?>