$("select#AreaPrefId").change(function(){
	var $pref_id = $(this).val();
	if ($pref_id != 0) {
		$.getJSON("/files/json/city/" + $pref_id + ".json?id=" + getUnique(), function(j){
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].city_id + '">' + j[i].name + '</option>';
			}
			$("#AreaCity").html(options);
		})
	}
});

function add_row(type){
	move("AreaCity", "AreaCityIds");
}
function del_row(type, obj){
	$("#AreaCityIds option:selected").each(function() {
		i = $("#AreaCityIds > option").index(this);
		$("#AreaCity").append($(this).clone());
		$(this).remove();
	});
}

function move(_this, target) {
	$("#" + _this + " option:selected").each(function() {
		$("#" + target).append($(this).clone());
		$(this).remove();
	});
}

function allSelected(){
	$("#AreaCityIds option").each(function(){
		$(this).attr('selected', 'selected');
	})
}
