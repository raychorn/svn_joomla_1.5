<?
include_once "../main.php";
?>
<script language="JavaScript">
function chk()
{
	if (document.form.uname.value=='') 
	{
		alert("Please enter name");
		document.form.uname.focus();
		return false;
	}
	if (document.form.upass.value=='') 
	{
		alert("Please enter password");
		document.form.upass.focus();
		return false;
	}
	if (document.form.cpass.value=='') 
	{
		alert("Please enter password");
		document.form.cpass.focus();
		return false;
	}
	if (document.form.upass.value != document.form.cpass.value)
	{
		alert("Passwords donot match");
		document.form.upass.focus();
		return false;
	}
	if (document.form.title.value=='') 
	{
		alert("Please select title");
		document.form.title.focus();
		return false;
	}
	if (document.form.fname.value=='') 
	{
		alert("Please enter first name");
		document.form.fname.focus();
		return false;
	}
	if (document.form.lname.value=='') 
	{
		alert("Please enter last name");
		document.form.lname.focus();
		return false;
	}
	if (document.form.bmonth.value=='') 
	{
		alert("Please select month name");
		document.form.bmonth.focus();
		return false;
	}

	if (document.form.bday.value=='') 
	{
		alert("Please select day");
		document.form.bday.focus();
		return false;
	}
	if (document.form.byear.value=='') 
	{
		alert("Please select year");
		document.form.byear.focus();
		return false;
	}
		if (document.form.city.value=='') 
	{
		alert("Please enter city name");
		document.form.city.focus();
		return false;
	}
	if (document.form.country.value=='') 
	{
		alert("Please select country");
		document.form.country.focus();
		return false;
	}
	if (document.form.zip.value=='') 
	{
		alert("Please enter zip code");
		document.form.zip.focus();
		return false;
	}
	if (document.form.address.value=='') 
	{
		alert("Please enter address");
		document.form.address.focus();
		return false;
	}

	if (document.form.phone.value=='') 
	{
		alert("Please enter  phone");
		document.form.phone.focus();
		return false;
	}
	if (document.form.job_seeker_email.value=='') 
	{
		alert("Please enter email addreess");
		document.form.job_seeker_email.focus();
		return false;
	}
		if (document.form.careerlevel.value=='') 
	{
		alert("Please select career level");
		document.form.careerlevel.focus();
		return false;
	}

	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.job_seeker_email.value))
		{
				return (true)
		}
		else
		{
				alert("Invalid E-mail Address! Please re-enter.")
				document.form.job_seeker_email.focus()
				return (false)
		}		
		

return true;		
}

</script>

<form action=jobseeker_registration2.php method=post name="form" onSubmit="return chk();"  style="background:none;">
  <table align=center width=446 cellspacing=0 cellpadding="3" bgcolor="#FFFFFF">
    <tr>
	<td>
	Username:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=uname size=23 maxlength=10><br> <font size=1>max. 10 symbols (letters and/or numbers) </font>
	</td>
</tr>

<tr>
	<td>
	Password:<font color=red>*</font>
	</td>

	<td>
	<input type=password name=upass size=23 maxlength=10><br> <font size=1>max. 10 symbols (letters and/or numbers) </font>
	</td>
</tr>

<tr>
	<td>
	Confirm password:<font color=red>*</font>
	</td>

	<td>
	<input type=password name=cpass size=23 maxlength=10>
	</td>
</tr>

<tr>
	  <td> Title:<font color=red>*</font> </td>

	<td>
	<select name=title>
          <option value="Mr.">Mr. </option>
          <option value="Mrs">Mrs</option>
          <option value="Miss">Miss</option>
          <option value="Ms.">Ms. </option>
        </select>
	</td>


</tr>

<tr>
	<td>
	First name:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=fname size=23>
	</td>

</tr>


<tr>
	<td>
	Last name:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=lname size=23>
	</td>
</tr>

<tr>
	<td>
	Date of birth: <font color=red>*</font>
	</td>

	<td>
	<select name=bmonth>
	<option value=""> Month </option>
	<option value=1> January </option>
	<option value=2> February </option>
	<option value=3> March </option>
	<option value=4> April </option>
	<option value=5> May </option>
	<option value=6> June </option>
	<option value=7> July </option>
	<option value=8> August </option>
	<option value=9> September </option>
	<option value=10> October </option>
	<option value=11> November </option>
	<option value=12> December </option>
	</select>

	<select name=bday>
	<option value=""> Day </option>
	<option value=1> 1 </option>
	<option value=2> 2 </option>
	<option value=3> 3 </option>
	<option value=4> 4 </option>
	<option value=5> 5 </option>
	<option value=6> 6 </option>
	<option value=7> 7 </option>
	<option value=8>  8 </option>
	<option value=9> 9 </option>
	<option value=10> 10 </option>
	<option value=11> 11 </option>
	<option value=12> 12 </option>
	<option value=13> 13 </option>
	<option value=14> 14 </option>
	<option value=15> 15 </option>
	<option value=16> 16 </option>
	<option value=17> 17 </option>
	<option value=18> 18 </option>
	<option value=19> 19 </option>
	<option value=20> 20 </option>
	<option value=21> 21 </option>
	<option value=22> 22 </option>
	<option value=23> 23 </option>
	<option value=24> 24 </option>
	<option value=25> 25 </option>
	<option value=26> 26 </option>
	<option value=27> 27 </option>
	<option value=28> 28 </option>
	<option value=29> 29 </option>
	<option value=30> 30 </option>
	<option value=31> 31 </option>
	</select>

	<select name=byear>
	<option value=""> Year </option>
	<option value=1986> 1986 </option>
	<option value=1985> 1985 </option>
	<option value=1984> 1984 </option>
	<option value=1983> 1983 </option>
	<option value=1982> 1982 </option>
	<option value=1981> 1981 </option>
	<option value=1980> 1980 </option>
	<option value=1979> 1979 </option>
	<option value=1978> 1978 </option>
	<option value=1977> 1977 </option>
	<option value=1976> 1976 </option>
	<option value=1975> 1975 </option>
	<option value=1974> 1974 </option>
	<option value=1973> 1973 </option>
	<option value=1972> 1972 </option>
	<option value=1971> 1971 </option>
	<option value=1970> 1970 </option>
	<option value=1969> 1969 </option>
	<option value=1968> 1968 </option>
	<option value=1967> 1967 </option>
	<option value=1966> 1966 </option>
	<option value=1965> 1965 </option>
	<option value=1964> 1964 </option>
	<option value=1963> 1963 </option>
	<option value=1962> 1962 </option>
	<option value=1961> 1961 </option>
	<option value=1960> 1960 </option>
	<option value=1959> 1959 </option>
	<option value=1958> 1958 </option>
	<option value=1957> 1957 </option>
	<option value=1956> 1956 </option>
	<option value=1955> 1955 </option>
	<option value=1954> 1954 </option>
	<option value=1953> 1953 </option>
	<option value=1952> 1952 </option>
	<option value=1951> 1951 </option>
	<option value=1950> 1950 </option>
	<option value=1949> 1949 </option>
	<option value=1948> 1948 </option>
	<option value=1947> 1947 </option>
	<option value=1946> 1946 </option>
	<option value=1945> 1945 </option>
	<option value=1943> 1943 </option>
	<option value=1942> 1942 </option>
	<option value=1941> 1941 </option>
	<option value=1940> 1940 </option>
	<option value=1939> 1939 </option>
	<option value=1938> 1938 </option>
	<option value=1937> 1937 </option>
	<option value=1936> 1936 </option>
	<option value=1935> 1935 </option>
	<option value=1934> 1934 </option>
	<option value=1933> 1933 </option>
	<option value=1932> 1932 </option>
	</select>
	</td>
</tr>

<tr>
	<td>
	Marital Status:
	</td>

	<td>
	<SELECT NAME="maritalstatus">
          <option value="Domestic Partner">Domestic Partner</option>
          <option value="Engaged">Engaged</option>
          <option value="Married">Married</option>
          <option value="Separated/Divorced">Separated/Divorced</option>
          <option value="Single" selected>Single</option>
          <option value="Widowed">Widowed</option>
        </SELECT>

	</td>
</tr>

<tr>
	  <td> Salary: </td>

	<td>
	<SELECT NAME="income" style=width:149>
          <option value="1">Under $15,000</option>
          <option value="2">$15,000-$19,999</option>
          <option value="3">$20,000-$24,999</option>
          <option value="4">$25,000 -$29,999</option>
          <option value="5">$30,000 -$34,999</option>
          <option value="6">$35,000-$39,999 </option>
          <option value="7">$40,000-Over</option>
        </SELECT>
	</td>
</tr>

<tr>
	<td>
	City:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=city  size=33>
	</td>
</tr>

<tr>
	<td>
	State:
	</td>

	<td>
	<select name=state style=width:154>
          <option value="Not in US">Not in US</option>
          <option value="Alabama">Alabama</option>
          <option value="Alaska">Alaska</option>
          <option value="Arizona">Arizona</option>
          <option value="Arkansas">Arkansas</option>
          <option value="California">California</option>
          <option value="Colorado">Colorado</option>
          <option value="Connecticut">Connecticut</option>
          <option value="Delaware">Delaware</option>
          <option value="District of Columbia">District of Columbia</option>
          <option value="Florida">Florida</option>
          <option value="Georgia">Georgia</option>
          <option value="Hawaii">Hawaii</option>
          <option value="Idaho">Idaho</option>
          <option value="Illinois">Illinois</option>
          <option value="Indiana">Indiana</option>
          <option value="Iowa">Iowa</option>
          <option value="Kansas">Kansas</option>
          <option value="Kentucky">Kentucky</option>
          <option value="Louisiana">Louisiana</option>
          <option value="Maine">Maine</option>
          <option value="Maryland">Maryland</option>
          <option value="Massachusetts">Massachusetts</option>
          <option value="Michigan">Michigan</option>
          <option value="Minnesota">Minnesota</option>
          <option value="Mississippi">Mississippi</option>
          <option value="Missouri">Missouri</option>
          <option value="Montana">Montana</option>
          <option value="Nebraska">Nebraska</option>
          <option value="Nevada">Nevada</option>
          <option value="New Hampshire">New Hampshire</option>
          <option value="New Jersey">New Jersey</option>
          <option value="New Mexico">New Mexico</option>
          <option value="New York">New York</option>
          <option value="North Carolina">North Carolina</option>
          <option value="North Dakota">North Dakota</option>
          <option value="Ohio">Ohio</option>
          <option value="Oklahoma">Oklahoma</option>
          <option value="Oregon">Oregon</option>
          <option value="Pennsylvania">Pennsylvania</option>
          <option value="Puerto Rico">Puerto Rico</option>
          <option value="Rhode Island">Rhode Island</option>
          <option value="South Carolina">South Carolina</option>
          <option value="South Dakota">South Dakota</option>
          <option value="Tennessee">Tennessee</option>
          <option value="Texas">Texas</option>
          <option value="Utah">Utah</option>
          <option value="Vermont">Vermont</option>
          <option value="Virgin Islands">Virgin Islands</option>
          <option value="Virginia">Virginia</option>
          <option value="Washington">Washington</option>
          <option value="West Virginia">West Virginia</option>
          <option value="Wisconsin">Wisconsin</option>
          <option value="Wyoming">Wyoming</option>
        </select>
	</td>
</tr>

<tr>
	<td>
	Country:<font color=red>*</font>
	</td>

	<td>
	<select name=country>
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
	  <td> Postcode:<font color=red>*</font> </td>

	<td>
	<input type=text name=zip size=9>
	</td>
</tr>


<tr>
	<td>
	Address:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=address>


	</td>	
</tr>

<tr>
	  <td> Phone<font color=red>:*</font> </td>
	
	<td>
	<input type=text name=phone>
	</td>
</tr>

<tr>
	  <td> Mobile:</td>
	
	<td>
	<input type=text name=phone2>
	</td>
</tr>

<tr>
	<td>
	Email:<font color=red>*</font>
	</td>

	<td>
	<input type=text name=job_seeker_email>
	</td>
</tr>

<tr>
	<td valign=top>
	Job Category:<font color=red>*</font> <br> 
	</td>

	<td valign=top>
	<SELECT NAME="JobCategory">
          <option value="Accounting/Auditing">Accounting/Auditing</option>
          <option value="Administrative and Support Services">Administrative and 
          Support Services</option>
          <option value="Advertising/Public Relations">Advertising/Public Relations</option>
          <option value="Computers, Hardware">Computers, Hardware</option>
          <option value="Computers, Software">Computers, Software</option>
          <option value="Consulting Services">Consulting Services</option>
          <option value="Customer Service and Call Center">Customer Service and 
          Call Center</option>
          <option value="Director">Director</option>
          <option value="Executive Management">Executive Management</option>
          <option value="Finance/Economics">Finance/Economics</option>
          <option value="Human Resources">Human Resources</option>
          <option value="Information Technology">Information Technology</option>
          <option value="Installation, Maintenance,Repairs">Installation, Maintenance,Repairs</option>
          <option value="Internet/E-Commerce">Internet/E-Commerce</option>
          <option value="Legal">Legal</option>
          <option value="Management">Management</option>
          <option value="Marketing">Marketing</option>
          <option value="Sales">Sales</option>
          <option value="Supervisor">Supervisor</option>
          <option value="Telecommunications">Telecommunications</option>
          <option value="Transportation and Warehousing">Transportation and Warehousing</option>
          <option value="Other">Other</option>
        </SELECT><br>

	</td>
</tr>

<tr>
	<td>
	Your career level:<font color=red>*</font>
	</td>

	<td>
	<select name="careerlevel">
          <option value="1">Student</option>
          <option value="2">Student (undergraduate/graduate)</option>
          <option value="3">Entry Level (less than 2 years of experience)</option>
          <option value="4">Mid Career (2+ years of experience)</option>
          <option value="5">Management (Manager/Director of Staff)</option>
          <option value="6">Executive (SVP, EVP, VP)</option>
          <option value="7">Senior Executive (President, CEO)</option>
        </select>
	</td>
</tr>

<tr>
	<td>
	Target company:
	</td>

	<td>
	<select name="target_company">
	<option value=""> </option>
	<option value="Small (up to 99 empl.)"> Small (up to 99 empl.) </option>
	<option value="Medium (100 - 500 empl.)"> Medium (100 - 500 empl.) </option>
	<option value="Large (over 500 empl.)"> Large (over 500 empl.) </option>
	</select>
	</td>
</tr>

<tr>
	<td valign=top>
	Willing to relocate?
	</td>
	<td>
	<input type=radio name=relocate value=Yes checked>Yes<br>
	<input type=radio name=relocate value=No>No
	</td>
</tr>

<tr>

	<td align=left>&nbsp;	</td>

	<td align=center>
	  <input class=s2 type=submit name=submit value="Register me" align=left>
	  <input class=s2 type=reset name=reset value="Reset" align=right>
	</td>
</tr>
</table>
</form>


<? include_once('../foother.html'); ?>