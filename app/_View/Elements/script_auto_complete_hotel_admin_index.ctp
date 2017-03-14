$(function(){
	function findValue(li) {
		if( li == null ) return alert("No match!");

		// if coming from an AJAX call, let's use the CityId as the value
		if( !!li.extra ) var sValue = li.extra[0];

		// otherwise, let's just display the value in the text box
		else var sValue = li.selectValue;

		$('.hotel_q').focus();
	}

	function selectItem(li) {
		findValue(li);
	}

	function formatItem(row) {
		return row[0] + " (id: " + row[1] + " 都道府県名: " + row[2] + ")";
	}

	$('.hotel_q').autocomplete('/admin/hotel/auto_complete/', {
		onItemSelect : selectItem,
		onFindValue : findValue,
		formatItem : formatItem
	});
});
