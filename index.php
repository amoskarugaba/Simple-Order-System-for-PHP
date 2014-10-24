<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8">
	<title>Simple Signup for PHP</title>
	<meta name="description" content="Example usage of the Simple Signup for PHP" />
	<meta name="author" content="Elliot J. Reed" />
</head>

<body>

	<header role="banner">
		<h1>Simple Signup for PHP</h1>
	</header>

	<main role="main">

		<section>

			<h2>Register</h2>

			<form id="customerform">

				<label for="name">Company Contact's First Name</label>
				<input type="text" id="firstname" name="firstname" placeholder="First Name" required="required" autofocus="autofocus" />

				<label for="name">Company Contact's Surname</label>
				<input type="text" id="lastname" name="lastname" placeholder="Last Name" required="required" />

				<label for="company">Company Name</label>
				<input type="text" id="company" name="company" placeholder="Company" required="required" />

				<label for="address1">House / Building / Unit Number &amp; Street</label>
				<input type="text" id="address1" name="address1" placeholder="Address Line 1" required="required" />

				<label for="address2">Additional Address Information</label>
				<input type="text" id="address2" name="address2" placeholder="Address Line 2" />

				<label for="town">Village, Town or City</label>
				<input type="text" id="town" name="town" list="towns" placeholder="Town or City" required="required" />
					<datalist id="towns">
						<option value="London">London</option>
						<option value="Birmingham">Birmingham</option>
						<option value="Leeds">Leeds</option>
						<option value="Glasgow">Glasgow</option>
						<option value="Sheffield">Sheffield</option>
						<option value="Bradford">Bradford</option>
						<option value="Liverpool">Liverpool</option>
						<option value="Edinburgh">Edinburgh</option>
						<option value="Manchester">Manchester</option>
						<option value="Bristol">Bristol</option>
						<option value="Kirklees">Kirklees</option>
						<option value="Fife">Fife</option>
						<option value="Wirral">Wirral</option>
						<option value="North Lanarkshire">North Lanarkshire</option>
						<option value="Wakefield">Wakefield</option>
						<option value="Cardiff">Cardiff</option>
						<option value="Dudley">Dudley</option>
						<option value="Wigan">Wigan</option>
						<option value="East Riding">East Riding</option>
						<option value="South Lanarkshire">South Lanarkshire</option>
						<option value="Coventry">Coventry</option>
						<option value="Belfast">Belfast</option>
						<option value="Leicester">Leicester</option>
						<option value="Sunderland">Sunderland</option>
						<option value="Sandwell">Sandwell</option>
						<option value="Doncaster">Doncaster</option>
						<option value="Stockport">Stockport</option>
						<option value="Sefton">Sefton</option>
						<option value="Nottingham">Nottingham</option>
						<option value="Newcastle-upon-Tyne">Newcastle-upon-Tyne</option>
						<option value="Kingston-upon-Hull">Kingston-upon-Hull</option>
						<option value="Bolton">Bolton</option>
						<option value="Walsall">Walsall</option>
						<option value="Plymouth">Plymouth</option>
						<option value="Rotherham">Rotherham</option>
						<option value="Stoke-on-Trent">Stoke-on-Trent</option>
						<option value="Wolverhampton">Wolverhampton</option>
						<option value="Rhondda, Cynon, Taff">Rhondda, Cynon, Taff</option>
						<option value="South Gloucestershire">South Gloucestershire</option>
						<option value="Derby">Derby</option>
						<option value="Swansea">Swansea</option>
						<option value="Salford">Salford</option>
						<option value="Aberdeenshire">Aberdeenshire</option>
						<option value="Barnsley">Barnsley</option>
						<option value="Tameside">Tameside</option>
						<option value="Oldham">Oldham</option>
						<option value="Trafford">Trafford</option>
						<option value="Aberdeen">Aberdeen</option>
						<option value="Southampton">Southampton</option>
						<option value="Highland">Highland</option>
						<option value="Rochdale">Rochdale</option>
						<option value="Solihull">Solihull</option>
						<option value="Gateshead">Gateshead</option>
						<option value="Milton Keynes">Milton Keynes</option>
						<option value="North Tyneside">North Tyneside</option>
						<option value="Calderdale">Calderdale</option>
						<option value="Northampton">Northampton</option>
						<option value="Portsmouth">Portsmouth</option>
						<option value="Warrington">Warrington</option>
						<option value="North Somerset">North Somerset</option>
						<option value="Bury">Bury</option>
						<option value="Luton">Luton</option>
						<option value="St Helens">St Helens</option>
						<option value="Stockton-on-Tees">Stockton-on-Tees</option>
						<option value="Renfrewshire">Renfrewshire</option>
						<option value="York">York</option>
						<option value="Thamesdown">Thamesdown</option>
						<option value="Southend-on-Sea">Southend-on-Sea</option>
						<option value="New Forest">New Forest</option>
						<option value="Caerphilly">Caerphilly</option>
						<option value="Carmarthenshire">Carmarthenshire</option>
						<option value="Bath">Bath</option>
						<option value="Wycombe">Wycombe</option>
						<option value="Basildon">Basildon</option>
						<option value="Bournemouth">Bournemouth</option>
						<option value="Peterborough">Peterborough</option>
						<option value="North East Lincolnshire">North East Lincolnshire</option>
						<option value="Chelmsford">Chelmsford</option>
						<option value="Brighton">Brighton</option>
						<option value="South Tyneside">South Tyneside</option>
						<option value="Charnwood">Charnwood</option>
						<option value="Aylesbury Vale">Aylesbury Vale</option>
						<option value="Colchester">Colchester</option>
						<option value="Knowsley">Knowsley</option>
						<option value="North Lincolnshire">North Lincolnshire</option>
						<option value="Huntingdonshire">Huntingdonshire</option>
						<option value="Macclesfield">Macclesfield</option>
						<option value="Blackpool">Blackpool</option>
						<option value="West Lothian">West Lothian</option>
						<option value="South Somerset">South Somerset</option>
						<option value="Dundee">Dundee</option>
						<option value="Basingstoke &amp; Deane">Basingstoke &amp; Deane</option>
						<option value="Harrogate">Harrogate</option>
						<option value="Dumfries &amp; Galloway">Dumfries &amp; Galloway</option>
						<option value="Middlesbrough">Middlesbrough</option>
						<option value="Flintshire">Flintshire</option>
						<option value="Rochester-upon-Medway">Rochester-upon-Medway</option>
						<option value="The Wrekin">The Wrekin</option>
						<option value="Newbury">Newbury</option>
						<option value="Falkirk">Falkirk</option>
						<option value="Reading">Reading</option>
						<option value="Wokingham">Wokingham</option>
						<option value="Windsor &amp; Maidenhead">Windsor &amp; Maidenhead</option>
						<option value="Maidstone">Maidstone</option>
						<option value="Redcar &amp; Cleveland">Redcar &amp; Cleveland</option>
						<option value="North Ayrshire">North Ayrshire</option>
						<option value="Blackburn">Blackburn</option>
						<option value="Neath Port Talbot">Neath Port Talbot</option>
						<option value="Poole">Poole</option>
						<option value="Wealden">Wealden</option>
						<option value="Arun">Arun</option>
						<option value="Bedford">Bedford</option>
						<option value="Oxford">Oxford</option>
						<option value="Lancaster">Lancaster</option>
						<option value="Newport">Newport</option>
						<option value="Canterbury">Canterbury</option>
						<option value="Preston">Preston</option>
						<option value="Dacorum">Dacorum</option>
						<option value="Cherwell">Cherwell</option>
						<option value="Perth &amp; Kinross">Perth &amp; Kinross</option>
						<option value="Thurrock">Thurrock</option>
						<option value="Tendring">Tendring</option>
						<option value="Kings Lynn">Kings Lynn</option>
						<option value="St Albans">St Albans</option>
						<option value="Bridgend">Bridgend</option>
						<option value="South Cambridgeshire">South Cambridgeshire</option>
						<option value="Braintree">Braintree</option>
						<option value="Norwich">Norwich</option>
						<option value="Thanet">Thanet</option>
						<option value="Isle of Wight">Isle of Wight</option>
						<option value="Mid Sussex">Mid Sussex</option>
						<option value="South Oxfordshire">South Oxfordshire</option>
						<option value="Guildford">Guildford</option>
						<option value="Elmbridge">Elmbridge</option>
						<option value="Stafford">Stafford</option>
						<option value="Powys">Powys</option>
						<option value="East Hertfordshire">East Hertfordshire</option>
						<option value="Torbay">Torbay</option>
						<option value="Wrexham Maelor">Wrexham Maelor</option>
						<option value="East Devon">East Devon</option>
						<option value="East Lindsey">East Lindsey</option>
						<option value="Halton">Halton</option>
						<option value="Warwick">Warwick</option>
						<option value="East Ayrshire">East Ayrshire</option>
						<option value="Newcastle-under-Lyme">Newcastle-under-Lyme</option>
						<option value="North Wiltshire">North Wiltshire</option>
						<option value="South Kesteven">South Kesteven</option>
						<option value="Epping Forest">Epping Forest</option>
						<option value="Vale of Glamorgan">Vale of Glamorgan</option>
						<option value="Reigate &amp; Banstead">Reigate &amp; Banstead</option>
						<option value="Chester">Chester</option>
						<option value="Mid Bedfordshire">Mid Bedfordshire</option>
						<option value="Suffolk Coastal">Suffolk Coastal</option>
						<option value="Horsham">Horsham</option>
						<option value="Nuneaton &amp; Bedworth">Nuneaton &amp; Bedworth</option>
						<option value="Gwynedd">Gwynedd</option>
						<option value="Swale">Swale</option>
						<option value="Havant &amp; Waterloo">Havant &amp; Waterloo</option>
						<option value="Teignbridge">Teignbridge</option>
						<option value="Cambridge">Cambridge</option>
						<option value="Vale Royal">Vale Royal</option>
						<option value="Amber Valley">Amber Valley</option>
						<option value="North Hertfordshire">North Hertfordshire</option>
						<option value="South Ayrshire">South Ayrshire</option>
						<option value="Waverley">Waverley</option>
						<option value="Broadland">Broadland</option>
						<option value="Crewe &amp; Nantwich">Crewe &amp; Nantwich</option>
						<option value="Breckland">Breckland</option>
						<option value="Ipswich">Ipswich</option>
						<option value="Pembrokeshire">Pembrokeshire</option>
						<option value="Vale of White Horse">Vale of White Horse</option>
						<option value="Salisbury">Salisbury</option>
						<option value="Gedling">Gedling</option>
						<option value="Eastleigh">Eastleigh</option>
						<option value="Broxtowe">Broxtowe</option>
						<option value="Stratford-on-Avon">Stratford-on-Avon</option>
						<option value="South Bedfordshire">South Bedfordshire</option>
						<option value="Angus">Angus</option>
						<option value="East Hampshire">East Hampshire</option>
						<option value="East Dunbartonshire">East Dunbartonshire</option>
						<option value="Conway">Conway</option>
						<option value="Sevenoaks">Sevenoaks</option>
						<option value="Slough">Slough</option>
						<option value="Bracknell Forest">Bracknell Forest</option>
						<option value="West Lancashire">West Lancashire</option>
						<option value="West Wiltshire">West Wiltshire</option>
						<option value="Ashfield">Ashfield</option>
						<option value="Lisburn">Lisburn</option>
						<option value="Scarborough">Scarborough</option>
						<option value="Stroud">Stroud</option>
						<option value="Wychavon">Wychavon</option>
						<option value="Waveney">Waveney</option>
						<option value="Exeter">Exeter</option>
						<option value="Dover">Dover</option>
						<option value="Test Valley">Test Valley</option>
						<option value="Gloucester">Gloucester</option>
						<option value="Erewash">Erewash</option>
						<option value="Cheltenham">Cheltenham</option>
						<option value="Bassetlaw">Bassetlaw</option>
					</datalist>

				<label for="county">County</label>
				<select name="county" id="county" name="county" placeholder="County" required="required">
					<option value="" disabled="disabled">Your County</option>
					<optgroup label="England">
						<option value="Bedfordshire">Bedfordshire</option>
						<option value="Berkshire">Berkshire</option>
						<option value="Bristol">Bristol</option>
						<option value="Buckinghamshire">Buckinghamshire</option>
						<option value="Cambridgeshire">Cambridgeshire</option>
						<option value="Cheshire">Cheshire</option>
						<option value="City of London">City of London</option>
						<option value="Cornwall">Cornwall</option>
						<option value="Cumbria">Cumbria</option>
						<option value="Derbyshire">Derbyshire</option>
						<option value="Devon">Devon</option>
						<option value="Dorset">Dorset</option>
						<option value="Durham">Durham</option>
						<option value="East Riding of Yorkshire">East Riding of Yorkshire</option>
						<option value="East Sussex">East Sussex</option>
						<option value="Essex">Essex</option>
						<option value="Gloucestershire">Gloucestershire</option>
						<option value="Greater London">Greater London</option>
						<option value="Greater Manchester">Greater Manchester</option>
						<option value="Hampshire">Hampshire</option>
						<option value="Herefordshire">Herefordshire</option>
						<option value="Hertfordshire">Hertfordshire</option>
						<option value="Isle of Wight">Isle of Wight</option>
						<option value="Kent">Kent</option>
						<option value="Lancashire">Lancashire</option>
						<option value="Leicestershire">Leicestershire</option>
						<option value="Lincolnshire">Lincolnshire</option>
						<option value="Merseyside">Merseyside</option>
						<option value="Norfolk">Norfolk</option>
						<option value="North Yorkshire">North Yorkshire</option>
						<option value="Northamptonshire">Northamptonshire</option>
						<option value="Northumberland">Northumberland</option>
						<option value="Nottinghamshire">Nottinghamshire</option>
						<option value="Oxfordshire">Oxfordshire</option>
						<option value="Rutland">Rutland</option>
						<option value="Shropshire">Shropshire</option>
						<option value="Somerset">Somerset</option>
						<option value="South Yorkshire">South Yorkshire</option>
						<option value="Staffordshire">Staffordshire</option>
						<option value="Suffolk">Suffolk</option>
						<option value="Surrey">Surrey</option>
						<option value="Tyne and Wear">Tyne and Wear</option>
						<option value="Warwickshire">Warwickshire</option>
						<option value="West Midlands">West Midlands</option>
						<option value="West Sussex">West Sussex</option>
						<option value="West Yorkshire">West Yorkshire</option>
						<option value="Wiltshire">Wiltshire</option>
						<option value="Worcestershire">Worcestershire</option>
					</optgroup>
					<optgroup label="Wales">
						<option value="Anglesey">Anglesey</option>
						<option value="Brecknockshire">Brecknockshire</option>
						<option value="Caernarfonshire">Caernarfonshire</option>
						<option value="Carmarthenshire">Carmarthenshire</option>
						<option value="Cardiganshire">Cardiganshire</option>
						<option value="Denbighshire">Denbighshire</option>
						<option value="Flintshire">Flintshire</option>
						<option value="Glamorgan">Glamorgan</option>
						<option value="Merioneth">Merioneth</option>
						<option value="Monmouthshire">Monmouthshire</option>
						<option value="Montgomeryshire">Montgomeryshire</option>
						<option value="Pembrokeshire">Pembrokeshire</option>
						<option value="Radnorshire">Radnorshire</option>
					</optgroup>
					<optgroup label="Scotland">
						<option value="Aberdeenshire">Aberdeenshire</option>
						<option value="Angus">Angus</option>
						<option value="Argyllshire">Argyllshire</option>
						<option value="Ayrshire">Ayrshire</option>
						<option value="Banffshire">Banffshire</option>
						<option value="Berwickshire">Berwickshire</option>
						<option value="Buteshire">Buteshire</option>
						<option value="Cromartyshire">Cromartyshire</option>
						<option value="Caithness">Caithness</option>
						<option value="Clackmannanshire">Clackmannanshire</option>
						<option value="Dumfriesshire">Dumfriesshire</option>
						<option value="Dunbartonshire">Dunbartonshire</option>
						<option value="East Lothian">East Lothian</option>
						<option value="Fife">Fife</option>
						<option value="Inverness-shire">Inverness-shire</option>
						<option value="Kincardineshire">Kincardineshire</option>
						<option value="Kinross">Kinross</option>
						<option value="Kirkcudbrightshire">Kirkcudbrightshire</option>
						<option value="Lanarkshire">Lanarkshire</option>
						<option value="Midlothian">Midlothian</option>
						<option value="Morayshire">Morayshire</option>
						<option value="Nairnshire">Nairnshire</option>
						<option value="Orkney">Orkney</option>
						<option value="Peeblesshire">Peeblesshire</option>
						<option value="Perthshire">Perthshire</option>
						<option value="Renfrewshire">Renfrewshire</option>
						<option value="Ross-shire">Ross-shire</option>
						<option value="Roxburghshire">Roxburghshire</option>
						<option value="Selkirkshire">Selkirkshire</option>
						<option value="Shetland">Shetland</option>
						<option value="Stirlingshire">Stirlingshire</option>
						<option value="Sutherland">Sutherland</option>
						<option value="Lothian">West Lothian</option>
						<option value="Wigtownshire">Wigtownshire</option>
					</optgroup>
					<optgroup label="Northern Ireland">
						<option value="Antrim">Antrim</option>
						<option value="Armagh">Armagh</option>
						<option value="Down">Down</option>
						<option value="Fermanagh">Fermanagh</option>
						<option value="Londonderry">Londonderry</option>
						<option value="Tyrone">Tyrone</option>
					</optgroup>
				</select>

				<label for="postcode">Postcode</label>
				<input type="text" id="postcode" name="postcode" placeholder="Postcode" />

				<label for="phone">Phone Number</label>
				<input type="tel" name="phone" id="phone" placeholder="Telephone Number" required="required" />

				<label for="email">Email Address</label>
				<input type="email" name="email" id="email" placeholder="Email Address" required="required" />

				<label for="notes">Additional Notes</label>
				<textarea name="notes" id="notes" form="customerform" placeholder="Enter additional notes here if required..."></textarea>

				<button type="submit">Continue</button>

			</form>

		</section>

	</main>

</body>
</html>
