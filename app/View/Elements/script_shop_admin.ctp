<?php
if (isset($data['Shop']['pref_id']) ||
	isset($data['Shop']['city_id'])
) {
?>
setTimeout(function(){
	var $pref_id = $("#ShopPrefId").val();
	if ($pref_id != 0) {
		getCities($pref_id);
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

$("select#ShopPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		getCities($pref_id);
//		getAreas($pref_id);
	} else {
		var options = '<option value="0">▼選択</option>';
		$("#ShopCityId").html(options);
//		$("#ShopAreaId").html(options);
	}
});

$("select#ShopCityId").change(function(){
	var $city_id = $(this).val();
	if ($city_id != 0) {
		getTowns($city_id);
	} else {
		var options = '<option value="0">▼選択</option>';
		$("#ShopTownId").html(options);
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
		if (isset($data['Shop']['city_id'])) {
		?>
		$("#ShopCityId").val("<?= $data['Shop']['city_id'] ?>");
		$city_id = $("#ShopCityId").val();
		if ($city_id != 0) {
			getTowns($city_id);
		}
		<?php
		}
		?>
	})
}

/*
 * 町域名の設定
 */
function getTowns($city_id){
	$.getJSON("/files/json/town/" + $city_id + ".json?id=" + getUnique(), function(j){
		var options = '<option value="0">▼選択</option>';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].town_id + '">' + j[i].name + '</option>';
		}
		$("#ShopTownId").html(options);
		$("#ShopTownId").val(0);
		<?php
		if (isset($data['Shop']['town_id'])) {
		?>
		console.log("<?= $data['Shop']['town_id'] ?>");
		$("#ShopTownId").val("<?= $data['Shop']['town_id'] ?>")
		<?php
		}
		?>
	})
}

/*
 * 派遣可能範囲の設定
 */
$("select#ShopDeliCityPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		$.getJSON("/files/json/city/" + $pref_id + ".json?id=" + getUnique(), function(j){
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].city_id + '">' + j[i].name + '</option>';
			}
			$("#ShopDeliCityCity").html(options);
		})
	}
});

function add_row_delivery_fee(){
	$("#tr_delivery_fee").append($("#skel").clone());
	$("#skel").css('display','table-row');
}

function add_row(type){
	if (type == 'city') {
		move("ShopDeliCityCity", "ShopCityIds");
	} else if (type == 'station') {
		move("ShopDeliStationStation", "ShopStationIds");
	} else if (type == 'sender') {
		var origin = $('#001 .origin');
		var clone = origin.clone();
		$('#001').append(clone.removeClass('origin'));
	}
}
function del_row(type, obj){
	if (type == 'city') {
		$("#ShopCityIds option:selected").each(function() {
			i = $("#ShopCityIds > option").index(this);

			$("#ShopDeliCityCity").append($(this).clone());
			$(this).remove();
		});
	} else if (type == 'station') {
		$("#ShopStationIds option:selected").each(function() {
			$(this).remove();
		});
	} else if (type == 'sender') {
		var $input   = $(obj).closest('.input-group').find('input');
		var $email   = $input.eq(0).val();
		var $id      = $input.eq(1).val();
		var $shop_id = $input.eq(2).val();

		if ($email == "") {
			$(obj).closest('tr').remove();
		} else {
			if (window.confirm('削除してもよろしいですか？')) {
				$(obj).closest('tr').remove();
				asyncCrud('/sender/async_crud/delete/' + $email + '/' + $id + '/' + $shop_id + '/');
			}
		}
	}
}
function update_row(obj){
	var $input   = $(obj).closest('.input-group').find('input');
	var $email   = $input.eq(0).val();
	var $id      = $input.eq(1).val();
	var $shop_id = $input.eq(2).val();

	if ($email == "") {
		alert('メールアドレスが入力されていません');
	} else {
		if ($id == 0) {
			var type = 'add';
		} else {
			var type = 'update';
		}
		asyncCrud('/sender/async_crud/' + type + '/' + $email + '/' + $id + '/' + $shop_id + '/');
	}
}

function asyncCrud(url){
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json'
	})
	.done(function( data ) {
//		alert(data);
	})
	.fail(function( data ) {
		alert('error !!');
	})
	.always(function( data ) {
		if (data.type == 'add') {
			var msg = 'の登録が完了しました！';
		} else if (data.type == 'update') {
			var msg = 'に更新が完了しました！';
		} else if (data.type == 'delete') {
			var msg = 'の削除が完了しました！';
		}
		alert(data.email + msg);
	});
}

function move(_this, target) {
	$("#" + _this + " option:selected").each(function() {
		$("#" + target).append($(this).clone());
		$(this).remove();
	});
}

function allSelected(){
	$("#ShopCityIds option").each(function(){
		$(this).attr('selected', 'selected');
	})
	$("#ShopStationIds option").each(function(){
		$(this).attr('selected', 'selected');
	})
}

$('.tt').tooltip({placement:'top'});

<?php
if (isset($coordinate)) {
?>
var latlng = new google.maps.LatLng(<?= isset($data['Shop']['lat']) ? $data['Shop']['lat'] : LAT ?>, <?= isset($data['Shop']['lon']) ? $data['Shop']['lon'] : LON ?>);
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

	$("#ShopLat").val(lat);
	$("#ShopLon").val(lng);

	marker.setPosition(new google.maps.LatLng(lat, lng));
});

function showTheLatLng(){
	var adrs = $("#ShopPrefName").val() + $("#ShopCityName").val() + $("#ShopAddressNum").val();
	var gc = new google.maps.Geocoder();
	gc.geocode({ address : adrs }, function(results, status){
		if (status == google.maps.GeocoderStatus.OK) {
			var lat = results[0].geometry.location.lat();
			var lng = results[0].geometry.location.lng();
			$("#ShopLat").val(lat);
			$("#ShopLon").val(lng);

			map.setCenter(results[0].geometry.location);
			marker.setPosition(new google.maps.LatLng(lat, lng));
		} else {
			alert(status+" : ジオコードに失敗しました");
		}
	});
}
<?php
}
?>