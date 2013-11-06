<script>
$('#SearchButton').click(function(){
	$('#SearchForm').prop('action', '<?php echo $this->GetPageUrl() ?>/search/' + $('#Search').val());
});

var DaftarBarang = <?php
$json = '[';
foreach($viewParams['BarangStatement'] as $Row) {
	$json .= '{"label":"'.$Row['namabrg'].'","value":"'.$Row['kodebrg'].'"},';
}
$json = rtrim($json, ',');
$json .= '];';
echo $json;
?>

$('#barang').autocomplete({
	source:DaftarBarang
});

var DaftarSupplier = <?php
$json = '[';
foreach($viewParams['SupplierStatement'] as $Row) {
	$json .= '{"label":"'.$Row['namasupp'].'","value":"'.$Row['kodesupp'].'"},';
}
$json = rtrim($json, ',');
$json .= '];';
echo $json;
?>

$('#supplier').autocomplete({
	source:DaftarSupplier
});

$('#barang').blur(function(){
	var found = $.grep(DaftarBarang, function(e){
		return e.value === $('#barang').val();
	});
	if(found.length == 1){
		$('#NamaBarang').html(found[0].label);
	}
});

$('#supplier').blur(function(){
	var found = $.grep(DaftarSupplier, function(e){
		return e.value === $('#supplier').val();
	});
	if(found.length == 1){
		$('#NamaSupplier').html(found[0].label);
	}
});

function delData(id) {
	if( ! window.confirm( "Data pembelian dengan nomor faktur '" + id +"' ini akan dihapus.\nLanjutkan menghapus?" ) ) {
		return;
	}
	window.location = "<?php echo $this->GetPageUrl() ?>/delete/" + id;
}

function editData(id){
	window.location = "<?php echo $this->GetPageUrl() ?>/edit/" + id;
}

</script>

