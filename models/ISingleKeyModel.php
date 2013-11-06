<?php
interface ISingleKeyModel {
	function DeleteByKey($key);
	function SelectAll();
	function SelectByKey($key);
	function SelectFilteredByKey($key);
	function SelectFilteredByFields(array $fields, $value);
}
?>
