<?php
//Query daftar user
$sql = mysql_query("SELECT * FROM user WHERE user_id != '1'");

echo "<div class='contentHeading'>Kelola User</div>";
echo "<p>&nbsp;</p>";
echo "<table>
		<tr><thead>
			<th>No</th>
			<th>Username</th>
			<th>Nama</th>
			<th>Akses Level</th>
			<th>Status</th>
			<th></th>
		</tr></thead>";
		$i=1;
		while ($r=mysql_fetch_array($sql)){
			echo "<tr>
					<td align='center'>$i.</td>
					<td>$r[username]</td>
					<td>$r[name]</td>
					<td>$r[akses_level]</td>
					<td>$r[active]</td>
					<td>
						<form name='useredit$i' method='POST' action='index.php?component=admin&act=edit_user'>
						<input name='userid' type='hidden' value='$r[user_id]'></input></form>
						<form name='userdel$i' method='POST' action='component/com_admin/proses.php?form=deluser'>
						<input name='userid' type='hidden' value='$r[user_id]'></input></form>
						<a href='javascript:document.useredit$i.submit();'>edit</a> &nbsp;
						<a href='javascript:document.userdel$i.submit();'>delete</a>
					</td>
				</tr>";
		$i++;
		}
echo "</form></table>";

			
echo "<br><a href=javascript:history.back()>[kembali]</a>";


?>