/* Indonesian initialisation for the jQuery UI date picker plugin. */
/* Modified by Indra Ginanjar from Stuart's jquery.ui.datepicker-en-GB.js. */

jQuery(function($){
	$.datepicker.regional['id-ID'] = {
		closeText: 'Tutup',
		prevText: 'Sebelumnya',
		nextText: 'Berikutnya',
		currentText: 'Hari ini',
		monthNames: ['Januari','Februari','Maret','April','Mei','Juni',
		'Juli','Agustus','September','Oktober','November','Desember'],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
		'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
		dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'],
		dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		dayNamesMin: ['Mi','Se','Se','Ra','Ka','Ju','Sa'],
		weekHeader: 'Minggu',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['id-ID']);
});
