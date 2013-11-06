<form id="DataForm" method="post" action="<?php echo $this->GetPageUrl() ?>/Insert">
	<fieldset>
		<legend>Barang</legend>
		<label for="kode">Kode</label>
		<input type="text" name="kode" id="kode" placeholder="Optional" class="Integer" value="<?php echo isset($viewParams['SingleItem']->kodebrg) ? $viewParams['SingleItem']->kodebrg : '' ?>" /><br />
		<label for="barcode">Barcode</label>
		<input type="text" name="barcode" id="barcode" class="ShortText" required value="<?php echo isset($viewParams['SingleItem']->barcode) ? $viewParams['SingleItem']->barcode : '' ?>" /><br />
		<label for="nama">Nama</label>
		<input type="text" name="nama" id="nama" class="Name" required value="<?php echo isset($viewParams['SingleItem']->namabrg) ? $viewParams['SingleItem']->namabrg : '' ?>" /><br />
		<label for="satuan">Satuan</label>
		<input type="text" name="satuan" id="satuan" class="ShortText" required value="<?php echo isset($viewParams['SingleItem']->satuan) ? $viewParams['SingleItem']->satuan : '' ?>" /><br />
		<label for="stok">Stok</label>
		<input type="text" min="0" name="stok" id="stok" class="Integer" required value="<?php echo isset($viewParams['SingleItem']->stok) ? $viewParams['SingleItem']->stok : '' ?>" /><br />
		<label for="harga">Harga</label>
		<input type="text" min="0" name="harga" id="harga" class="Currency" required value="<?php echo isset($viewParams['SingleItem']->harga) ? $viewParams['SingleItem']->harga : '' ?>" /><br />
	</fieldset>
	<input type="submit" value="Simpan"/>
</form>
<div>
<form id="SearchForm" action="" method="post">
	<fieldset>
		<input type="text" name="text" id="Search" class="Search" placeholder="Kode, barcode, atau nama barang" value="<?php echo isset($viewParams['SearchKeyword']) ? $viewParams['SearchKeyword'] : '' ?>" />
		<input type="submit" id="SearchButton" value="Cari"/>
	</fieldset>

</form>
</div>
<table id="DataTable">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Barcode</th>
			<th>Nama</th>
			<th>Satuan</th>
			<th>Stok</th>
			<th>Harga</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
foreach($viewParams['Statement'] as $row) {
	echo '		<tr>
			<!--<th><input type="checkbox" name="RowCheckbox" /></th>-->
			<td>', $row['kodebrg'], '</td>
			<td>', $row['barcode'], '</td>
			<td>', $row['namabrg'], '</td>
			<td>', $row['satuan'], '</td>
			<td>', $row['stok'], '</td>
			<td>', $row['harga'], '</td>
			<td>
				<button onclick="delData(', $row[BarangModel::KODE_FIELD], ')" >Hapus</button>
				<button onclick="editData(', $row[BarangModel::KODE_FIELD], ')">Ubah</button>
			</td>
		</tr>
';
}
?>
	</tbody>
</table>
