<?php
include "config/fungsi_indotgl.php";

$valkab 	= getNilai(db_kabkota,nama_kabkota,id_kabkota,$kabkota);
$valprop	= getNilai(db_prop,nama_propinsi,id_propinsi,$propinsi);
$valneg		= getNilai(db_negara,nama_negara,id_negara,$negara);
$valpd		= getNilai(pdn_dpa,nama_pdn,id_pdn,$asal_pd);
$valkom		= getNilai(komisi,nama_komisi,id_komisi,$komisi);
$valsph		= getNilai(sphere,nama_sphere,id_sphere,$sphere);

$subject  ='#'.$no_registrasi.' - Pendaftaran Peserta KN XIV DPA GBI';
$headers  = 'From: '."pan-kn14@dpagbi.org\r\n".
		        'Reply-To: '."pan-kn14@dpagbi.org\r\n".
		        'Content-Type: text/plain; charset="iso-8859-1"';
		
$pesan = "Kepada Yth. ".$nama_lengkap.".\n\n";
$pesan .= "Aplikasi anda akan segera kami proses. Nomor Registrasi anda adalah: #".$no_registrasi.". Mohon anda dapat mencatat nomor registrasi ini, yang nantinya diperlukan pada saat konfirmasi pembayaran dan Registrasi-Ulang.\n\n";
$pesan .= "Silahkan melakukan pembayaran yang dapat disetorkan ke rekening:\n";
$pesan .= "1. BCA cab. Ranotana No. 780-0202-099. a/n. Chandra Manalip & Nico Edwin Paath.\n";
$pesan .= "2. BRI cab. MTC Manado No. 2024-01-002668-50-5. a/n. Panitia Kongres Nasional DPA GBI.\n\n";
$pesan .= "Berikut data yang anda input\n";
$pesan .= "-------------------------------------------------\n";
$pesan .= "Nama Lengkap : ".$nama_lengkap."\n";
$pesan .= "Tempat Tanggal Lahir : ".$tempat_lahir.", ".$tgl_lahir." ".getBulan($bln_lahir)." ".$thn_lahir."\n";
$pesan .= "Jenis Kelamin : ".$jenis_kelamin."\n";
$pesan .= "Alamat : ".$alamat."\n";
$pesan .= "Kabupaten/Kota : ".$valkab."\n";
$pesan .= "Propinsi : ".$valprop."\n";
$pesan .= "Negara : ".$valneg."\n";
$pesan .= "Kode Pos : ".$kodepos."\n";
$pesan .= "No Telp : ".$no_tlp.". No HP : ".$no_hp."\n";
$pesan .= "Email : ".$email."\n";
$pesan .= "Pekerjaan : ".$pekerjaan."\n\n";
$pesan .= "Nama Gembala : ".$gelar.$gembala."\n";
$pesan .= "Alamat Gereja : ".$alamat_grj."\n";
$pesan .= "Telp Gereja : ".$tlp_grj.". No Fax : ".$fax_grj."\n";
$pesan .= "Asal Pengurus Daerah (PD) : ".$valpd."\n";
$pesan .= "Jabatan di KPA : ".$jabatan_kpa."\n";
$pesan .= "Ketua KPA : ".$ketua_kpa."\n";
$pesan .= "Komisi : ".$valkom." "."\n";
$pesan .= "Pilihan Sphere : ".$valsph."\n\n";
$pesan .= "Rencana kedatangan dengan : ".$arrive_by."\n";
$pesan .= "Tiba di Manado tanggal : ".$arrive_tgl." ".getBulan($arrive_bln)." ".$arrive_thn.". Jam : ".$arrive_jam." Wita\n";
$pesan .= "-------------------------------------------------\n";
$pesan .= "cat: Untuk perubahan data, silahkan email ke pan-kn14@dpagbi.org\n";
$pesan .= "sebelum tanggal 13 Agustus 2013\n\n";
$pesan .= "Demikian pemberitahuan kami. Terima Kasih dan Tuhan Memberkati\n\n\n";
$pesan .= "Hormat kami,\n";
$pesan .= "Panitia Pelaksana Kongres Nasional XIV DPA GBI Tahun 2013";

@mail($email,$subject,$pesan,$headers);

?>
