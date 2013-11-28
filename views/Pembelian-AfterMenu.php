<div id="ContentWrap">
    <div class="box">
        <form id="DataForm" method="post" autocomplete="off" action="javascript:void(0)"></form>
        <form id="ItemForm" method="post" autocomplete="off" action="javascript:void(0)"></form>
        <div id="FormHeader">
            <h2>Pembelian</h2>
        </div>
        <fieldset>
            <label for="Nomor">No. Faktur</label>
            <input type="text" name="Nomor" id="Nomor" placeholder="Optional" class="Integer" form="DataForm" value="<?php echo isset($viewParams['SingleItem']->nofaktur) ? $viewParams['SingleItem']->nofaktur : '' ?>" /><br />
            <label for="Tanggal">Tanggal</label>
            <input type="text" name="Tanggal" id="Tanggal" class="Date" required form="DataForm" value="<?php echo isset($viewParams['SingleItem']->tanggal) ? (new DateTime($viewParams['SingleItem']->tanggal))->format(INDONESIAN_DATE_FORMAT) : (new DateTime())->format(INDONESIAN_DATE_FORMAT) ?>" /><br />
            <label for="Supplier">Supplier</label>
            <input type="text" name="Supplier" id="Supplier" placeholder="kode / nama supplier" class="InlineImportant" required form="DataForm" value="<?php echo isset($viewParams['SingleItem']->kodesupp) ? $viewParams['SingleItem']->kodesupp : '' ?>" />
            <span id="NamaSupplier"></span>
            <br />
            <fieldset class="none">
                <legend>Item</legend>
                <label>Nomor</label>
                <span id="ItemNumber">1</span><br />
                <label for="Barang">Barang</label>
                <input type="text" name="Barang" id="Barang" placeholder="kode / nama barang" class="InlineImportant" required form="ItemForm" value="<?php echo isset($viewParams['SingleItem']->kodebrg) ? $viewParams['SingleItem']->kodebrg : '' ?>" />
                <span id="NamaBarang"></span>
                <br />
                <label for="Harga">Harga</label>
                <input type="text" name="Harga" id="Harga" class="Currency" required form="ItemForm" value="<?php echo isset($viewParams['SingleItem']->harga) ? $viewParams['SingleItem']->harga : '' ?>" /><br />
                <label for="Jumlah">Jumlah</label>
                <input type="text" name="Jumlah" id="Jumlah" class="Integer" required form="ItemForm" value="<?php echo isset($viewParams['SingleItem']->jumlah) ? $viewParams['SingleItem']->jumlah : '' ?>" /><br />
                <label>Nilai</label>
                <span id="Nilai">0</span><br />
                <label>&nbsp;</label>
                <input id="ItemSubmitButton" type="submit" form="ItemForm" value="Tambah" />
                <input id="ItemResetButton" type="reset" form="ItemForm" value="Batal" />
                <br />
                <br />
                <table id="ItemTable">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th colspan="2">Barang</th>
                            <th rowspan="2">Harga</th>
                            <th rowspan="2">Jumlah</th>
                            <th rowspan="2">Nilai</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="BarangResult" class="ResultRow">
                            <td colspan="5">Bayar</td>
                            <td id="Bayar">0</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </fieldset>
        <footer>
            <input type="submit" value="Simpan" id="SimpanButton" form="DataForm">
            <input type="reset" value="Reset" id="ResetButton" form="DataForm">
        </footer>
        </div>
        <div id="DataTableWrap">
            <div>
                <form id="SearchForm" action="javascript:void(0)" method="post">
                    <fieldset>
                        <input type="text" name="text" id="Search" class="Search" placeholder="Nomor faktur / nama supplier" value="<?php echo isset($viewParams['SearchKeyword']) ? $viewParams['SearchKeyword'] : '' ?>" />
                        <input type="submit" id="SearchButton" value="Cari"/>
                    </fieldset>

                </form>
            </div>
            <table id="DataTable">
                <thead>
                    <tr>
                        <th rowspan="2">No.Faktur</th>
                        <th rowspan="2">Tanggal</th>
                        <th colspan="2">Supplier</th>
                        <th rowspan="2">Nilai</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
