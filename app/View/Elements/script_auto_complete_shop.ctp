<?php
if($controller_camel_case == 'Banner') {
?>
	var Ctrl = 'Banner';
<?php
} else if($controller_camel_case == 'Movie') {
?>
	var Ctrl = 'Movie';
<?php
}
?>
$(function(){
	var ID = '#' + Ctrl + 'ShopId';

	function findValue(li) {
		if( li == null ) return alert("No match!");
		if( !!li.extra ) var sValue = li.extra[0];
		else var sValue = li.selectValue;
		$(ID).focus();
	}

	function selectItem(li) {
		findValue(li);
	}

	function formatItem(row) {
		return row[0] + " (id: " + row[1] + " url: " + row[2] + ")";
	}
	$(ID).autocomplete('/admin/shop/auto_complete/', {
		onItemSelect : selectItem,
		onFindValue : findValue,
		formatItem : formatItem
	});
});
