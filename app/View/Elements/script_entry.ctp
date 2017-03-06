<?php
if (isset($data['Entry']['pref_id']) ||
	isset($data['Entry']['city_id'])
) {
?>
setTimeout(function(){
	if ($("#EntrySend").val() != 1) {
		var $pref_id = $("select#EntryPrefId").val();
		if ($pref_id != 0) {
			getCities($pref_id);
		}
	}
}, 500);
<?php
}
?>

$("select#EntryPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		getCities($pref_id);
	} else {
		var options = '<option value="0">▼選択</option>';
		$("#EntryAreaId").html(options);
	}
});

/*
 * 市区町村名の設定
 */
function getCities($pref_id){
	$.getJSON("/files/json/city/" + $pref_id + ".json?id=" + getUnique(), function(j){
		var options = '<option value="0">▼選択</option>';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].city_id + '">' + j[i].name + '</option>';
		}
		$("#EntryCityId").html(options);
		$("#EntryCityId").val(0);
		<?php
		if (isset($data['Entry']['city_id'])) {
		?>
		$("#EntryCityId").val(<?= $data['Entry']['city_id'] ?>)
		<?php
		}
		?>
	})
}

function jump2Entry(){
	if ($("#EntryAccept").is(':checked') !== true) {
		alert('「無料掲載におけるご利用規約」のご同意が必須です。');
		return false;
	} else {
		return true;
	}
}

