$(function(){
	function findValue(li) {
		if( li == null ) return alert("No match!");
		if( !!li.extra ) var sValue = li.extra[0];
		else var sValue = li.selectValue;
		console.log(li.extra[2]);
		options = '<option value="' + sValue + '">' + li.extra[2] + '</option>';
		$(".areas").append(options);
		$('.area_q').focus();
	}

	function selectItem(li) {
		findValue(li);
	}

	function formatItem(row) {
		return row[0] + " (id: " + row[1] + " 都道府県名: " + row[2] + " エリア名: " + row[0] + ")";
	}

	$('.area_q').autocomplete('/area/auto_complete/', {
		onItemSelect : selectItem,
		onFindValue : findValue,
		formatItem : formatItem
	});
});
