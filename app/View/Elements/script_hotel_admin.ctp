var latlng = new google.maps.LatLng(<?= isset($data['Hotel']['lat']) ? $data['Hotel']['lat'] : LAT ?>, <?= isset($data['Hotel']['lon']) ? $data['Hotel']['lon'] : LON ?>);
var myOptions = {
	zoom: 16,
	center: latlng,
	mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map(document.getElementById("gmap"), myOptions);
marker = new google.maps.Marker({
	position: latlng,
	map: map
});

google.maps.event.addListener(map, 'drag', function(event){
	var LatLngObj = map.getCenter();
	var lat = LatLngObj.lat();
	var lng = LatLngObj.lng();

	$("#HotelLat").val(lat);
	$("#HotelLon").val(lng);

	marker.setPosition(new google.maps.LatLng(lat, lng));
});

function showTheLatLng(){
//	var adrs = $("#HotelPrefName").val() + $("#HotelCityName").val() + $("#HotelAddressAddition").val();
	var adrs = $("#HotelAddress").val();
	var gc = new google.maps.Geocoder();
	gc.geocode({ address : adrs }, function(results, status){
		if (status == google.maps.GeocoderStatus.OK) {
			var lat = results[0].geometry.location.lat();
			var lng = results[0].geometry.location.lng();
			$("#HotelLat").val(lat);
			$("#HotelLon").val(lng);

			map.setCenter(results[0].geometry.location);
			marker.setPosition(new google.maps.LatLng(lat, lng));
		} else {
			alert(status+" : ジオコードに失敗しました");
		}
	});
}

<?php
if (isset($data['Hotel']['pref_id']) ||
	isset($data['Hotel']['city_id'])
) {
?>
setTimeout(function(){
	if ($("#HotelSend").val() != 1) {
		var $pref_id = $("select#HotelPrefId").val();
		if ($pref_id != 0) {
			getCities($pref_id);
			getAreas($pref_id);
		}
	}
}, 100);
<?php
}
?>

$("select#HotelPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		getCities($pref_id);
		getAreas($pref_id);
		setPrefName($pref_id);
	} else {
		var options = '<option value="0">▼選択</option>';
		$("#HotelCityId").html(options);
		$("#HotelAreaId").html(options);
	}
});
$("select#HotelCityId").change(function(){
	var $city_id = $(this).val();
	if ($city_id != 0) {
		setCityName();
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
		$("#HotelCityId").html(options);
		$("#HotelCityId").val(0);
		<?php
		if (isset($data['Hotel']['city_id'])) {
		?>
		$("#HotelCityId").val(<?= $data['Hotel']['city_id'] ?>)
		<?php
		}
		?>
	})
}

/*
 * エリアの設定
 */
function getAreas($pref_id){
	$.getJSON("/files/json/area/" + $pref_id + ".json?id=" + getUnique(), function(j){
		var options = '<option value="0">▼選択</option>';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].area_id + '">' + j[i].name + '</option>';
		}
		$("#HotelAreaId").html(options);
		$("#HotelAreaId").val(0);
		<?php
		if (isset($data['Hotel']['area_id'])) {
		?>
		$("#HotelAreaId").val(<?= $data['Hotel']['area_id'] ?>)
		<?php
		}
		?>
	})
}

// JSONから都道府県名を取得する
function setPrefName($pref_id){
	$.getJSON("/files/json/pref-" + ("0" + $pref_id).slice(-2) + ".json?id=" + getUnique(), function(j){
		$("#HotelPrefName").val(j[1]);
	})
}
// 市区町村名を取得する
function setCityName(){
	$("#HotelCityName").val($('#HotelCityId option:selected').text());
}

function del_row(type){
	if (type == 'station') {
		$("#HotelStationIds option:selected").each(function() {
			$(this).remove();
		});
	} else if (type == 'tag') {
		$("#HotelTags option:selected").each(function() {
			$(this).remove();
		});
	}
}

function allSelected(){
	$("#HotelStationIds option").each(function(){
		$(this).attr('selected', 'selected');
	})
	$("#HotelTags option").each(function(){
		$(this).attr('selected', 'selected');
	})
}
