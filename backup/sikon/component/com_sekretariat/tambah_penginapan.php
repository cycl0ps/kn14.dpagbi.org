<?php

echo "<div class='contentHeading'>Tambah Penginapan</div>
		<form id='tambah_penginapan' action='component/com_sekretariat/proses.php?act=tambah_penginapan' method='post'>
		<p>
			<label class='label2' for='nama'>Nama Penginapan : &nbsp;</label>
			<input type='text' name='nama_penginapan' size='30'/>
		</p>
		<p>
			<label class='label2' for='alamat'>Alamat Penginapan : &nbsp;</label>
			<input type='text' name='alamat_penginapan' size='50'/>
		</p>
		<p>
			<label class='label2' for='kapasitas'>Kapasitas : &nbsp;</label>
			<input type='text' name='kapasitas' size='5'/>
		</p>
		<p>
			<input type='submit' name='tombol-tambah' value='Tambah' />
		</p>
		</form>";

			
echo "<br><a href=javascript:history.back()>[kembali]</a>";


?>