window.onload = function responsiveTables(){

	// Create a new style element
	var css = document.createElement("style");

	// Only for smaller screens / responsive
	css.innerHTML = '@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {';

	// Get all the tables
	var tables = document.getElementsByTagName("table");

	// Iterate through all tables in document
	for(var i = 0; i < tables.length; ++i){

		// Add id so that if there is more than one table on a page it will use separate labels for each
		tables[i].setAttribute("id", "t" + i);

		// Get all table headers for each table
		var headers = tables[i].getElementsByTagName("th");

		// Iterate through all headers in each table
		for(var j = 1; j < headers.length+1; ++j){
			var k = j-1;
			var id = 't' + i;
			css.innerHTML += '#' + id + ' td:nth-of-type(' + j + '):before { content: "' + headers[k].innerHTML + '"; font-weight: bold; }';
		}

	}

	// Close the media query
	css.innerHTML += '}';

	// Add the new styles to the style element created earlier
	document.body.appendChild(css);

}
