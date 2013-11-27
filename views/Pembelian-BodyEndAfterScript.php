<script>
    $('#SearchButton').click(function() {
	jQuery.ajax({
		async:"true",
        	type: "GET",
        	url: "./Rest/Pembelian/" + $('#Search').val(),
        	contentType: "application/json; charset=utf-8",
        	dataType: "json",
		success: function (data, status, jqXHR) {
			alert(JSON.stringify(data));
			DrawDataTable(data);
		},
	    
		error: function (jqXHR, status) {           
		     // error handler
		       //$('body').append("aaaaa " + JSON.stringify(jqXHR.statusCode()));
		},

		complete: function (jqXHR, status) {
		}
	});

//        $('#SearchForm').prop('action', '<?php echo $this->GetPageUrl() ?>/search/' + $('#Search').val());
	return false;
    });


var DaftarBarang = "";

jQuery.ajax({
	async:"true",
	type: "GET",
	url: "./Rest/Barang",
	contentType: "application/json; charset=utf-8",
	dataType: "json",

	success: function (data, status, jqXHR) {
		DaftarBarang = '[';
		for(var i = 0; i < data.entities.length; i++){
			DaftarBarang += '{"label":"'
					+ data.entities[i].properties.namabrg
					+ " : "
					+ data.entities[i].properties.kodebrg
					+ '", "value":"'
					+ data.entities[i].properties.kodebrg
					+ '"},'
		}
		DaftarBarang = DaftarBarang.substr(0, DaftarBarang.length - 1);
		DaftarBarang += ']';
		DaftarBarang = JSON.parse(DaftarBarang);
		$('#Barang').autocomplete({
			source: DaftarBarang
		});
	},
    
	error: function (jqXHR, status) {           
		// error handler
	}
});

var DaftarSupplier = "";
 
jQuery.ajax({
	async:"true",
	type: "GET",
	url: "./Rest/Supplier",
	contentType: "application/json; charset=utf-8",
	dataType: "json",

	success: function (data, status, jqXHR) {
		DaftarSupplier = '[';
		for(var i = 0; i < data.entities.length; i++){
			DaftarSupplier += '{"label":"'
					+ data.entities[i].properties.namasupp
					+ " : "
					+ data.entities[i].properties.kodesupp
					+ '", "value":"'
					+ data.entities[i].properties.kodesupp
					+ '"},'
		}
		DaftarSupplier = DaftarSupplier.substr(0, DaftarSupplier.length - 1);
		DaftarSupplier += ']';
		DaftarSupplier = JSON.parse(DaftarSupplier);
		$('#Supplier').autocomplete({
			source: DaftarSupplier
		});
	},
    
	error: function (jqXHR, status) {           
		// error handler
	}
});

function AfterInputSupplier(){
        var found = $.grep(DaftarSupplier, function(e) {
            return e.value === $('#Supplier').val();
        });
        if (found.length == 1) {
		$('#NamaSupplier').html(found[0].label);
		jQuery.ajax({
			async:"true",
			type: "GET",
			url: "./Rest/Supplier/" + $('#Supplier').val(),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (data, status, jqXHR) {
				$('#NamaSupplier').html(data.properties.namasupp);
				$('#Supplier')[0].setCustomValidity('');
			},
		    
			error: function (jqXHR, status) {           
				// error handler
			}

		});
        }
	else {
		$('#NamaSupplier').html(null);
		if($('#Supplier')[0].checkValidity()){
			$('#Supplier')[0].setCustomValidity('Supplier tidak terdaftar.\nCoba dengan ketikkan nama supplier, dan pilih dari yang tersedia');
			$('#Supplier')[0].validity.valid = false;
			$('#SimpanButton')[0].click();
		}
		else {
			$('#Supplier')[0].setCustomValidity('');
		}
	}
}

function AfterInputBarang(timpaHarga){
        var found = $.grep(DaftarBarang, function(e) {
            return e.value === $('#Barang').val();
        });
        if (found.length == 1) {
		$('#NamaBarang').html(found[0].label);
		jQuery.ajax({
			async:"true",
			type: "GET",
			url: "./Rest/Barang/" + $('#Barang').val(),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (data, status, jqXHR) {
				if(timpaHarga) {
					$('#Harga').val(data.properties.harga);
				}
				$('#NamaBarang').html(data.properties.namabrg);
				$('#Barang')[0].setCustomValidity('');
			},
		    
			error: function (jqXHR, status) {           
				if(timpaHarga) {
					$('#Harga').val(null);
				}
			}

		});
        }
	else {
		$('#NamaBarang').html(null);
		$('#Barang')[0].setCustomValidity('Barang tidak terdaftar.\nCoba dengan ketikkan nama barang, dan pilih dari yang tersedia');
		$('#Barang')[0].validity.valid = false;
	}
}


$('#Barang').blur(function() {
	AfterInputBarang(true);	
});

$('#Supplier').blur(function() {
	AfterInputSupplier();
});

$('#Tanggal').blur(function(){
	if($(this)[0].checkValidity()){
		if(isNaN(new Date(IndonesiaDateToIso8601($(this).val())))){
			$(this)[0].setCustomValidity('Tanggal yang dimasukkan tidak benar');
			$(this)[0].validity.valid = false;
			$('#SimpanButton').click();
		}
		else {
			$(this)[0].validity.valid = true;
		}
	}
	else {
		$(this)[0].setCustomValidity('');
	}
});

function delData(id) {
if (!window.confirm("Data pembelian dengan nomor faktur '" + id + "' ini akan dihapus.\nLanjutkan menghapus?")) {
    return;
}
window.location = "<?php echo $this->GetPageUrl() ?>/delete/" + id;
}

function editData(id) {
window.location = "<?php echo $this->GetPageUrl() ?>/edit/" + id;
}

function Item() {
	var Barang = $('#Barang').val();
}

$('#Harga, #Jumlah').change(function(){
	$('#Nilai').html($('#Harga').val() * $('#Jumlah').val());
});

var Items = new Object();
var BarangList = Array();
var NamaBarangList = Array();
var HargaList = Array();
var JumlahList = Array();
var NilaiList = Array();

$('#ItemNumber').html(BarangList.length + 1);


$('#ItemSubmitButton').click(function(){
	var ItemForm = $('#ItemForm');
	if(!ItemForm.get(0).checkValidity()){
		return true;
	}

	if($('#ItemSubmitButton').val() === 'Perbarui') {
		var Index = $('#ItemNumber').html() - 1;
		BarangList[Index] = $('#Barang').val();
		NamaBarangList[Index] = $('#NamaBarang').html();
		HargaList[Index] = $('#Harga').val();
		JumlahList[Index] = $('#Jumlah').val();
		NilaiList[Index] = parseInt($('#Harga').val()) * parseInt($('#Jumlah').val());
		$('#ItemSubmitButton').val('Tambah');
	}
	else {
		BarangList.push($('#Barang').val());
		NamaBarangList.push($('#NamaBarang').html());
		HargaList.push($('#Harga').val());
		JumlahList.push($('#Jumlah').val());
		NilaiList.push(parseInt($('#Harga').val()) * parseInt($('#Jumlah').val()));
	}

	$('#ItemNumber').html(BarangList.length + 1);

	DrawItemTable();
	document.getElementById('ItemForm').reset();
	$('#NamaBarang').html('');
	$('#NamaSupplier').html('');
	$('#Nilai').html('');
	return false;
});

$('#SimpanButton').click(function(){
	if(!$('#DataForm')[0].checkValidity()){
		return true;
	}
	AddPembelian();
	return false;
});

function AddPembelian () {
	var O = new Object();
	O.BarangList = BarangList;
	O.HargaList = HargaList;
	O.JumlahList = JumlahList;
	O.Nomor = $('#Nomor').val();
	O.Tanggal = $('#Tanggal').val();
	O.Supplier = $('#Supplier').val();

	jQuery.ajax({
		async:"true",
		type: "POST",
		url: "",
		data: JSON.stringify(O),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function (data, status, jqXHR) {
		},

		error: function (jqXHR, status) {           
		},

		complete:function(jqXHR, textStatus){
			RefreshDataTable();
			$('#DataForm')[0].reset();
			$('#ItemForm')[0].reset();
			$('#ItemTable tbody').html(null);
			$('#ItemNumber').html(1);
		}

	});
}

function RefreshDataTable() {
	jQuery.ajax({
		async:"true",
        	type: "GET",
        	url: "./Rest/Pembelian",
        	contentType: "application/json; charset=utf-8",
        	dataType: "json",
		success: function (data, status, jqXHR) {
			DrawDataTable(data);
		},
	    
		error: function (jqXHR, status) {
		}

	});
}


function DrawDataTable(data){
	$('#DataTable tbody').html(null);
	var i = 0;
	for(i; i < data.entities.length; i++){
		$('#DataTable tbody').append(
			'<tr><td>'
			+ data.entities[i].properties.nofaktur
			+ '</td><td>'
			+ Iso8601DateToIndonesia(data.entities[i].properties.tanggal)
			+ '</td><td>'
			+ data.entities[i].properties.kodesupp
			+ '</td><td>'
			+ data.entities[i].properties.namasupp
			+ '</td><td>'
			+ data.entities[i].properties.nilai
			+ '</td><td><button onclick="DelData('
			+ data.entities[i].nofaktur
			+ ')">Hapus</button><button onclick="EditData('
			+ data.entities[i].properties.nofaktur
			+ ')">Edit</button>'
			+ '</td></tr>'
		//return JSON.stringify(data[i]);
		);
	}
}


RefreshDataTable();

function DelData(id){
	jQuery.ajax({
		async:"true",
        	type: "DELETE",
        	url: "./Rest/Pembelian/" + id,
        	contentType: "application/json; charset=utf-8",
        	dataType: "json",
		success: function (data, status, jqXHR) {
			RefreshDataTable();
		},
	    
		error: function (jqXHR, status) {           
		     // error handler
		       //$('body').append("aaaaa " + JSON.stringify(jqXHR.statusCode()));
		},

		complete:function(jqXHR, textStatus){
			RefreshDataTable();
		}

	});
}

function EditData(id){
	jQuery.ajax({
		async:"true",
        	type: "GET",
        	url: "./Rest/Pembelian/" + id,
        	contentType: "application/json; charset=utf-8",
        	dataType: "json",
		success: function (data, status, jqXHR) {
			$('#Nomor').val(data[0].nofaktur);
			$('#Supplier').val(data[0].kodesupp);
			AfterInputSupplier();
			var Tanggal = data[0].tanggal;
			var Arr = Tanggal.split('-');
			Tanggal = Arr[2] + '/' + Arr[1] + '/' + Arr[0];
			$('#Tanggal').val(Iso8601DateToIndonesia(data[0].tanggal));
			//DrawDataTable(data);
		},
	    
		error: function (jqXHR, status) {           
		     // error handler
		       //$('body').append("aaaaa " + JSON.stringify(jqXHR.statusCode()));
		},

		complete: function (jqXHR, status) {
			jQuery.ajax({
				async:"true",
				type: "GET",
				url: "./Rest/Pembelian/" + id + '/Item',
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function (data, status, jqXHR) {
					BarangList = Array();
					HargaList = Array();
					JumlahList = Array();
					NamaBarangList = Array();
					NilaList = Array();
					for(var i = 0; i < data.length; i++){
						BarangList.push(data[0].kodebrg);
						NamaBarangList.push(data[0].namabrg);
						JumlahList.push(data[0].jumlah);
						HargaList.push(data[0].harga);
						NilaiList.push(data[0].jumlah * data[0].harga);
					}
					$('#ItemNumber').html(i + 1);
					DrawItemTable();
				}
			});

		}

	});
}

function EditItem(id){
	$('#ItemNumber').html(id + 1);
	$('#Barang').val(BarangList[id]);
	$('#Harga').val(HargaList[id]);
	$('#Jumlah').val(JumlahList[id]);
	$('#Nilai').val(HargaList[id] * JumlahList[id]);
	$('#ItemSubmitButton').val('Perbarui');
	AfterInputBarang(false);
}

function DelItem(id){
	BarangList.splice(id, 1);
	HargaList.splice(id , 1);
	JumlahList.splice(id, 1);
	HargaList.splice(id, 1);
	NilaiList.splice(id, 1);
	$('#ItemNumber').html(BarangList.length + 1);
	DrawItemTable();
}

function DrawItemTable(){
	var Bayar = 0;
	$('#ItemTable tbody').html(null);
	for(var i = 0; i < BarangList.length; ++i) {
		$('#ItemTable tbody').append(
			'<tr><td>' 
			+ (i + 1)
			+ '</td><td>'
			+ BarangList[i]
			+ '</td><td>'
			+ NamaBarangList[i]
			+ '</td><td>'
			+ HargaList[i]
			+ '</td><td>'
			+ JumlahList[i]
			+ '</td><td>'
			+ NilaiList[i]
			+ '</td><td>'
			+ '<button onclick="DelItem(' + i + ')">Hapus</button>'
			+ '<button onclick="EditItem(' + i + ')">Edit</button>'
			+ '</td></tr>'
		);
		Bayar += parseInt(NilaiList[i])
	}
	$('#ItemTable tbody').append(
			'<tr id="BarangResult" class="ResultRow">'
			+ '	<td colspan="5">Bayar</td>'
			+ '	<td id="Bayar">' + Bayar + '</td>'
			+ '	<td></td>'
			+ '</tr>'
			);

}

$('#ItemResetButton').click(function(){
	$('#NamaBarang').html(null);
	$('#Nilai').html(0);
	$('#ItemSubmitButton').val('Tambah');
	document.getElementById('ItemForm').reset();
});

function Iso8601DateToIndonesia(isoDate){
	var Arr = isoDate.split('-');
	return Arr[2] + '/' + Arr[1] + '/' + Arr[0];
}

function IndonesiaDateToIso8601(indonesiaDate){
	var Arr = indonesiaDate.split('/');
	return Arr[2] + '-' + Arr[1] + '-' + Arr[0];
}

</script>

