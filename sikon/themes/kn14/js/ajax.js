/*
Created by: Xaverius Najoan
*/

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

function klikNegara(kode,kode_propinsi,form,id) {
	var elemenProp = document.getElementById('div_prop');
	var elemenKabkota = document.getElementById('div_kabkota');
	var kode_negara = kode.value;

	if (kode_negara != 107) {
		reply_prop = "<select name='propinsi' id='propinsi' required><option value='0' selected>-- Luar Negeri --</option></select>";
		reply_kabkota = "<select name='kabkota' id='kabkota' required><option value='0' selected>-- Luar Negeri --</option></select>";
		elemenProp.innerHTML = reply_prop;
		elemenKabkota.innerHTML = reply_kabkota;

	} else {
		var xmlhttp = createRequestObject();
		var url = 'getdata.php?cat=select_propinsi&form=' + form + '&id=' + id;
		xmlhttp.open('get', url);
		xmlhttp.onreadystatechange = function() {
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
					elemenProp.innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.send(null);

		var xmlhttp2 = createRequestObject();
		url = 'getdata.php?cat=select_kabkota&filter=id_propinsi&kode=' + kode_propinsi + '&form=' + form + '&id=' + id;
		xmlhttp2.open('get', url);
		xmlhttp2.onreadystatechange = function() {
			if ((xmlhttp2.readyState == 4) && (xmlhttp2.status == 200)) {
					elemenKabkota.innerHTML = xmlhttp2.responseText;
			}
		}
		xmlhttp2.send(null);
	} 
}


function klikPropinsi(kode,form,id) {
	var elemenKabkota = document.getElementById('div_kabkota');
	var kode_propinsi = kode.value;

	var xmlhttp3 = createRequestObject();
	url = 'getdata.php?cat=select_kabkota&filter=id_propinsi&kode=' + kode_propinsi + '&form=' + form + '&id=' + id;
	xmlhttp3.open('get', url);
	xmlhttp3.onreadystatechange = function() {
		if ((xmlhttp3.readyState == 4) && (xmlhttp3.status == 200)) {
			elemenKabkota.innerHTML = xmlhttp3.responseText;
		}
	}
	xmlhttp3.send(null);
}

function filterPropinsi(kode,form,id) {
	var filterKabkota = document.getElementById('div_filterkabkota');
	var elemenKpa = document.getElementById('div_kpa');
	var kode_propinsi = kode.value;

	if (kode_propinsi == 0) {
		filterKabkota.innerHTML = "-- LUAR NEGERI --";

	} else {	
		var xmlhttp4 = createRequestObject();
		url = 'getdata.php?cat=select_kabkota_kpa&filter=id_propinsi&kode=' + kode_propinsi;
		xmlhttp4.open('get', url);
		xmlhttp4.onreadystatechange = function() {
			if ((xmlhttp4.readyState == 4) && (xmlhttp4.status == 200)) {
				filterKabkota.innerHTML = xmlhttp4.responseText;
			}
		}
		xmlhttp4.send(null);
	}
	
	var xmlhttp5 = createRequestObject();
	url = 'getdata.php?cat=select_kpa&filter=propinsi_kpa&kode=' + kode_propinsi + '&form=' + form + '&id=' + id;
	xmlhttp5.open('get', url);
	xmlhttp5.onreadystatechange = function() {
		if ((xmlhttp5.readyState == 4) && (xmlhttp5.status == 200)) {
			elemenKpa.innerHTML = xmlhttp5.responseText;
		}
	}
	xmlhttp5.send(null);
}

function filterKabkota(kode,form,id) {
	var elemenKpa = document.getElementById('div_kpa');
	var kode_kabkota = kode.value;

	var xmlhttp6 = createRequestObject();
	url = 'getdata.php?cat=select_kpa&filter=kabkota_kpa&kode=' + kode_kabkota + '&form=' + form + '&id=' + id;
	xmlhttp6.open('get', url);
	xmlhttp6.onreadystatechange = function() {
		if ((xmlhttp6.readyState == 4) && (xmlhttp6.status == 200)) {
			elemenKpa.innerHTML = xmlhttp6.responseText;
		}
	}
	xmlhttp6.send(null);
}

function filterKpd(kode,form,id) {
	var elemenKpa = document.getElementById('div_kpa');
	var kode_kpd = kode.value;

	var xmlhttp7 = createRequestObject();
	url = 'getdata.php?cat=select_kpa&filter=pdn_kpa&kode=' + kode_kpd + '&form=' + form + '&id=' + id;
	xmlhttp7.open('get', url);
	xmlhttp7.onreadystatechange = function() {
		if ((xmlhttp7.readyState == 4) && (xmlhttp7.status == 200)) {
			elemenKpa.innerHTML = xmlhttp7.responseText;
		}
	}
	xmlhttp7.send(null);
}