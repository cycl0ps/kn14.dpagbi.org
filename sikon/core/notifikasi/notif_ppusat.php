<?php
//edit data

if ($notif_type == 'na_na'){
      echo "<h3>MAAF!</h3>
			<p>Nama KPA belum diisi.</p>";
}

if ($notif_type == 'prop_na'){
      echo "<h3>MAAF!</h3>
			<p>Propinsi KPA belum diisi.</p>";
}

if ($notif_type == 'kabkota_na'){
      echo "<h3>MAAF!</h3>
			<p>Kabupaten/Kota KPA belum diisi.</p>";
}

if ($notif_type == 'pdn_na'){
      echo "<h3>MAAF!</h3>
			<p>Anda belum memilih PD/PLN KPA.</p>";
}

if ($notif_type == 'kre_na'){
      echo "<h3>MAAF!</h3>
			<p>Nama pemegang kredensi belum diisi.</p>";
}

if ($notif_type == 'kpa_na'){
      echo "<h3>MAAF!</h3>
			<p>Anda belum memilih Asal KPA.</p>";
}

?>