<?php
if (isset($query['pref_id']) ||
	isset($query['city_id'])
) {
?>
setTimeout(function(){
	var $pref_id = $("select#ShopPrefId").val();
	if ($pref_id != 0) {
		getCities($pref_id);
	}
}, 500);
<?php
}
?>

$("select#ShopPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		getCities($pref_id);
	} else {
		var options = '<option value="0">▼選択</option>';
		$("#ShopCityId").html(options);
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
		$("#ShopCityId").html(options);
		$("#ShopCityId").val(0);
		<?php
		if (isset($query['city_id'])) {
		?>
		$("#ShopCityId").val("<?= $query['city_id'] ?>")
		<?php
		}
		?>
	})
}
