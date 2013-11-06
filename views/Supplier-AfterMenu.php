<form id="DataForm" method="post" action="<?php echo $this->GetPageUrl() ?>/Insert">
	<fieldset>
		<legend>Supplier</legend>
		<label for="kode">Kode</label>
		<input type="text" name="kode" id="kode" placeholder="Optional" class="Integer" value="<?php echo isset($viewParams['SingleItem']->kodesupp) ? $viewParams['SingleItem']->kodesupp : '' ?>" /><br />
		<label for="nama">Nama</label>
		<input type="text" name="nama" id="nama" class="Name" required value="<?php echo isset($viewParams['SingleItem']->namasupp) ? $viewParams['SingleItem']->namasupp : '' ?>" /><br />
		<label for="alamat">Alamat</label>
		<textarea name="alamat" id="alamat" required><?php echo isset($viewParams['SingleItem']->alamat) ? $viewParams['SingleItem']->alamat : '' ?></textarea><br />
		<label for="telp">Telepon</label>
		<input type="text" name="telp" id="telp" class="PhoneNumber" required value="<?php echo isset($viewParams['SingleItem']->telp) ? $viewParams['SingleItem']->telp : '' ?>" /><br />
	</fieldset>
	<input type="submit" value="Simpan"/>
</form>
<div>
<form id="SearchForm" action="" method="post">
	<fieldset>
		<input type="text" name="text" id="Search" class="Search" placeholder="Kode atau nama supplier" value="<?php echo isset($viewParams['SearchKeyword']) ? $viewParams['SearchKeyword'] : '' ?>" />
		<input type="submit" id="SearchButton" value="Cari"/>
	</fieldset>

</form>
</div>
<table id="DataTable">
	<thead>
		<tr>
			<!--<th><input type="checkbox" id="SelectAll" /></th>-->
			<th>Kode</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Telp</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
foreach($viewParams['Statement'] as $row) {
	echo '		<tr>
			<!--<th><input type="checkbox" name="RowCheckbox" /></th>-->
			<td>', $row[SupplierModel::KODE_FIELD], '</td>
			<td>', $row['namasupp'], '</td>
			<td>', $row['alamat'], '</td>
			<td><a href="tel:', $row['telp'], '">'.$row['telp'].'</td>
			<td>
				<button onclick="delData(', $row[SupplierModel::KODE_FIELD], ')" >Hapus</button>
				<button onclick="editData(', $row[SupplierModel::KODE_FIELD], ')">Ubah</button>
			</td>
		</tr>
';
}
?>
	</tbody>
</table>
