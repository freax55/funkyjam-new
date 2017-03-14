<?php
if (isset($data['Banner']['pref_id'])) {
?>
setTimeout(function(){
	var $pref_id = $("#BannerPrefId").val();
	if ($pref_id != 0) {
		//getAreas(1, $pref_id);
		areaConfig();
	}
}, 500);
<?php
}
?>

function areaConfig(){
	$('.area-config').each(function(index){
		$pref_id = $(this).val();
		if ($pref_id == 0) {
			return false;
		}
		$.getJSON("/files/json/area/" + $pref_id + ".json?id=" + getUnique(), function(j){
			var options = '<option value="0">▼選択</option>';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].area_id + '">' + j[i].name + '</option>';
			}
			$area = $('.area').eq(index);
			$area.html(options);
			$area.val($area.attr('data-selected'));
		})
	});
}

/*
 * エリア名の設定
 */
$(".area-config").change(function(){
	$pref_id = $(this).val();
	if ($pref_id == 0) {
		return false;
	}
	index = $('.area-config').index(this);

	$.getJSON("/files/json/area/" + $pref_id + ".json?id=" + getUnique(), function(j){
		var options = '<option value="0">▼選択</option>';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].area_id + '">' + j[i].name + '</option>';
		}
		$area = $('.area').eq(index);
		$area.html(options);
		$area.val(0);
	})
});

function getAreas($pref_id){

	$.getJSON("/files/json/area/" + $pref_id + ".json?id=" + getUnique(), function(j){
		var options = '<option value="0">▼選択</option>';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].area_id + '">' + j[i].name + '</option>';
		}
		$("+select", this).html(options);
	})
}

$("select#BannerPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		getCities($pref_id);
//		getAreas($pref_id);
	} else {
		var options = '<option value="0">▼選択</option>';
//		$("#BannerAreaId").html(options);
	}
});