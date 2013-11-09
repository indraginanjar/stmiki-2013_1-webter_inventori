<div id="ContentWrap">
    <form id="DataForm" class="box" method="post" autocomplete="off" action="<?php echo $this->GetPageUrl() ?>/Insert">
        <div id="FormHeader">
            <h2>Pembelian</h2>
        </div>
        <fieldset>
            <label for="nomor">No. Faktur</label>
            <input type="text" name="nomor" id="nomor" placeholder="Optional" class="Integer" value="<?php echo isset($viewParams['SingleItem']->nofaktur) ? $viewParams['SingleItem']->nofaktur : '' ?>" /><br />
            <label for="barang">Barang</label>
            <input type="text" name="barang" id="barang" placeholder="Ketik kode/ nama barang" class="InlineImportant" required value="<?php echo isset($viewParams['SingleItem']->kodebrg) ? $viewParams['SingleItem']->kodebrg : '' ?>" />
            <span id="NamaBarang"></span>
            <br />
            <label for="supplier">Supplier</label>
            <input type="text" name="supplier" id="supplier" placeholder="Ketik kode/ nama supplier" class="InlineImportant" required value="<?php echo isset($viewParams['SingleItem']->kodesupp) ? $viewParams['SingleItem']->kodesupp : '' ?>" />
            <span id="NamaSupplier"></span>
            <br />
            <label for="tanggal">Tanggal</label>
            <input type="text" name="tanggal" id="tanggal" class="Date" required value="<?php echo isset($viewParams['SingleItem']->tanggal) ? (new DateTime($viewParams['SingleItem']->tanggal))->format(INDONESIAN_DATE_FORMAT) : '' ?>" /><br />
            <label for="harga">Harga</label>
            <input type="text" name="harga" id="harga" class="Currency" required value="<?php echo isset($viewParams['SingleItem']->harga) ? $viewParams['SingleItem']->harga : '' ?>" /><br />
            <label for="jumlah">Jumlah</label>
            <input type="text" name="jumlah" id="jumlah" class="Integer" required value="<?php echo isset($viewParams['SingleItem']->jumlah) ? $viewParams['SingleItem']->jumlah : '' ?>" /><br />
        </fieldset>
        <footer>
            <input type="submit" value="Simpan">
            <input type="reset" value="Reset">
        </footer>
    </form>
    <div id="DataTableWrap">
        <div>
            <form id="SearchForm" action="" method="post">
                <fieldset>
                    <input type="text" name="text" id="Search" class="Search" placeholder="Nomor faktur, nama barang atau nama supplier" value="<?php echo isset($viewParams['SearchKeyword']) ? $viewParams['SearchKeyword'] : '' ?>" />
                    <input type="submit" id="SearchButton" value="Cari"/>
                </fieldset>

            </form>
        </div>
        <table id="DataTable">
            <thead>
                <tr>
                    <th rowspan="2">No.Faktur</th>
                    <th colspan="2">Barang</th>
                    <th colspan="2">Supplier</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Harga</th>
                    <th rowspan="2">Jumlah</th>
                </tr>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($viewParams['Statement'] as $row) {
                    echo '<tr>
			<!--<th><input type="checkbox" name="RowCheckbox" /></th>-->
			<td>', $row[PembelianModel::KODE_FIELD], '</td>
			<td>', $row['kodebrg'], '</td>
			<td>', $row['namabrg'], '</td>
			<td>', $row['kodesupp'], '</td>
			<td>', $row['namasupp'], '</td>
			<td>', (new DateTime($row['tanggal']))->format(INDONESIAN_DATE_FORMAT), '</td>
			<td>', $row['harga'], '</td>
			<td>', $row['jumlah'], '</td>
			<td>
				<button onclick="delData(', $row[PembelianModel::KODE_FIELD], ')" >Hapus</button>
				<button onclick="editData(', $row[PembelianModel::KODE_FIELD], ')">Ubah</button>
			</td>
		</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
