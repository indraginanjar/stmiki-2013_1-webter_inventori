<script>
    $('#SearchButton').click(function() {
        $('#SearchForm').prop('action', '<?php echo $this->GetPageUrl() ?>/search/' + $('#Search').val());
    });

    var DaftarBarang = <?php
$json = '[';
foreach ($viewParams['BarangStatement'] as $Row) {
    $json .= '{"label":"' . $Row['namabrg'] . '","value":"' . $Row['kodebrg'] . '"},';
}
$json = rtrim($json, ',');
$json .= '];';
echo $json;
?>

    $('#barang').autocomplete({
        source: DaftarBarang
    });

    var DaftarCustomer = <?php
$json = '[';
foreach ($viewParams['CustomerStatement'] as $Row) {
    $json .= '{"label":"' . $Row['namacst'] . '","value":"' . $Row['kodecst'] . '"},';
}
$json = rtrim($json, ',');
$json .= '];';
echo $json;
?>

    $('#customer').autocomplete({
        source: DaftarCustomer
    });

    $('#barang').blur(function() {
        var found = $.grep(DaftarBarang, function(e) {
            return e.value === $('#barang').val();
        });
        if (found.length == 1) {
            $('#NamaBarang').html(found[0].label);
        }
    });

    $('#customer').blur(function() {
        var found = $.grep(DaftarCustomer, function(e) {
            return e.value === $('#customer').val();
        });
        if (found.length == 1) {
            $('#NamaCustomer').html(found[0].label);
        }
    });

    function delData(id) {
        if (!window.confirm("Data penjualan dengan nomor faktur '" + id + "' ini akan dihapus.\nLanjutkan menghapus?")) {
            return;
        }
        window.location = "<?php echo $this->GetPageUrl() ?>/delete/" + id;
    }

    function editData(id) {
        window.location = "<?php echo $this->GetPageUrl() ?>/edit/" + id;
    }

</script>

