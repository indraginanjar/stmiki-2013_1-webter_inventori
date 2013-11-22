$('.Name').attr('maxlength', '71');
$('.ShortName').attr('maxlength', '35');
$('.LongName').attr('maxlength', '255');
$('.Date').attr('maxlength', '10');
$('.PhoneNumber').attr('maxlength', '20');
$('.Year').attr('maxlength', '4');
$('.Currency').attr('maxlength', '19');

$('.Date').datepicker({
	buttonImage: 'ui-icon-calendar'
	, changeMonth: true
	, changeYear: true
	, showOtherMonths: true
	, selectOtherMonths: true
});

$( '.Date' ).attr('pattern', '([0-9]){2}\/([0-9]){2}\/([0-9]){4}');
$( '.Date' ).attr('title', 'dd/mm/yyyy, misal: 28/09/2013');
$( '.Currency' ).attr('pattern', '([0-9.,])*');
$( '.Integer' ).attr('pattern', '([0-9])*');
$( '.Integer' ).attr('title', 'Bilangan bulat, misal: 34000');
$( '.Integer' ).attr('maxlength', 9);
$( '.ShortText' ).attr('maxlength', 10);
$( '.Search' ).attr('maxlength', 71);

$( "input:submit, input:button" ).button();
$( "input:reset, input:button" ).button();

$('input:text, input:password')
.button()
.css({
	'font' : 'inherit',
	'color' : 'inherit',
	'text-align' : 'left',
	'outline' : 'none',
	'background-image': 'none',
	'background-color': 'white',
	'cursor' : 'text'
	});

