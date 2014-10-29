document.addEventListener("DOMContentLoaded", function(){
	document.forms["register"].addEventListener("submit",registerLogin);
});

function registerLogin(a){

	var email = encodeURIComponent(document.getElementById("email").value);
	var password = encodeURIComponent(document.getElementById("password").value);

	// Checks if fields are filled-in or not, returns response "<p>Please enter your details.</p>" if not.
	if(email == "" || password == ""){
		document.getElementById("response").innerHTML = "<p>Please enter your username (email address) and password.</p>";
		return;
	}

	// Parameters to send to PHP script. The bits in the "quotes" are the POST indexes to be sent to the PHP script.
	var params = "email=" + email + "&password=" + password;

	var http = new XMLHttpRequest();
	http.open("POST","ajax/registerLogin.php",true);

	// Set headers
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

	http.onreadystatechange = function(){
		if(http.readyState == 4 && http.status == 200){
			document.getElementById("response").innerHTML = http.responseText;
		}
	}
	http.send(params);
	a.preventDefault();
}
