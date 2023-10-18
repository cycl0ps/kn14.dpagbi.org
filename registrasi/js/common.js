/*
Created by: Xaverius Najoan
*/
var xmlhttp = createRequestObject();

function createRequestObject() {
	var ro;
	var browser = navigator.appName;
	if (browser == "Microsoft Internet Explorer") {
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		ro = new XMLHttpRequest();
	}
	return ro;
}

function klikNegara(combobox) {
	var kode = combobox.value;
	if (!kode) return;
	xmlhttp.open("GET", 'getdata.php?cat=negara&kode_neg='+kode, true);
	xmlhttp.onreadystatechange = function() {
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
			document.getElementById("propinsi").innerHTML =
				xmlhttp.responseText;
		}
		return false;
	}

	xmlhttp.send(null);
}

function klikPropinsi(combobox2) {
	var kode2 = combobox2.value;
	if (!kode2) return;
	xmlhttp.open('get', 'getdata.php?cat=propinsi&kode_prop='+kode2, true);
	xmlhttp.onreadystatechange = function() {
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
			document.getElementById("kabkota").innerHTML =
				xmlhttp.responseText;
		}
		return false;
	}
	xmlhttp.send(null);
}