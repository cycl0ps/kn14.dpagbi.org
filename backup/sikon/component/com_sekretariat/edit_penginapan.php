<?php
$id   = $_POST[id];

$sql  = mysql_query("SELECT * FROM penginapan WHERE id_penginapan='$id'");
$r    = mysql_fetch_array($sql);

echo "<div class='contentHeading'>Edit Penginapan</div>
		<form id='edit_penginapan' action='component/com_sekretariat/proses.php?act=edit_penginapan' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label class='label2' for='nama'>Nama Penginapan : &nbsp;</label>
			<input type='text' name='nama_penginapan' size='30' value='$r[nama_penginapan]'/>
		</p>
		<p>
			<label class='label2' for='alamat'>Alamat Penginapan : &nbsp;</label>
			<input type='text' name='alamat_penginapan' size='50' value='$r[alamat_penginapan]'/>
		</p>
		<p>
			<label class='label2' for='kapasitas'>Kapasitas : &nbsp;</label>
			<input type='text' name='kapasitas' size='5' value='$r[kapasitas]'/>
		</p>
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";

			
echo "<br><a href=javascript:history.back()>[kembali]</a>";


?>