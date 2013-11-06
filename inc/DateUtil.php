<?php

class DateUtil {
	const MysqlDefaultDateFormat = 'Y-m-d';
	const IndonesianAbbreviation = 'id-ID';
	const IndonesiaDefaultDateFormat = 'd/m/Y';

	public static function GetLastDateOfMonth( $date ){
		$lastDate = date_create( date_format( $date , 'Y-m-' ) . '1' );
		date_add($lastDate, new DateInterval( 'P1M' ) ); // +1 month
		date_sub($lastDate,  new DateInterval( 'P1D' ) ); // -1 day
		return $lastDate;
	}

	public static function ChangeStringFormat( $dateString , $originalFormat , $targetFormat ){
		$date = date_create_from_format($originalFormat, $dateString);
		if( ! $date ) {
			return $date;
		}
		return date_format( $date , $targetFormat );
	}

}
?>
