$(function(){
	function findValue(li) {
		if( li == null ) return alert("No match!");
		if( !!li.extra ) var sValue = li.extra[0];
		else var sValue = li.selectValue;
		$('#ShopUserId').focus();
	}

	function selectItem(li) {
		findValue(li);
	}

	function formatItem(row) {
		return row[0] + " (id: " + row[1] + " mail: " + row[2] + ")";
	}
	$('#ShopUserId').autocomplete('/admin/user/auto_complete/4/', {
		onItemSelect : selectItem,
		onFindValue : findValue,
		formatItem : formatItem
	});
});

$(function(){
	function findValue(li) {
		if( li == null ) return alert("No match!");
		if( !!li.extra ) var sValue = li.extra[0];
		else var sValue = li.selectValue;
		$('#ShopAgencyId').focus();
	}

	function selectItem(li) {
		findValue(li);
	}

	function formatItem(row) {
		return row[0] + " (id: " + row[1] + " mail: " + row[2] + ")";
	}
	$('#ShopAgencyId').autocomplete('/admin/user/auto_complete/3/', {
		onItemSelect : selectItem,
		onFindValue : findValue,
		formatItem : formatItem
	});
});
