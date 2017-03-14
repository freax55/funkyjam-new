<div id="submenu">
<?php
$auth_user = $_SESSION['User'];
if (!empty($auth_user)) {
	$i=0;
	foreach($pages_admin as $k => $v){
		if ($v['status'] == true) {
			if ($auth_user['Role'][$k. '_status'] == 'y') {
				$i++;

				$crrt_h4 = $params["controller"] == $k ? " class=\"active\"" : "";
				$crrt_ul = $params["controller"] == $v['url'] ? "" : " style=\"display: none;\"";

				print "<h4" .$crrt_h4. "><i class=\"icon icon-circle-arrow-right\"></i> " .$v['title']. "</h4>\n";
				print "<ul" .$crrt_ul. ">\n";

				foreach ($v['submenu'] as $v2) {
					switch ($v2) {
						case "view":
							print '<li><a href="/admin/' .$v['url']. '/"><i class="icon icon-th-list"></i>&nbsp;一覧を見る</a></li>';
							break;
						case "add":
							print '<li><a href="/admin/' .$v['url']. '/add/"><i class="icon icon-plus-sign"></i>&nbsp;新規登録する</a></li>';
							break;
						case "edit":
							print "<li class=\"icon_edit\"><a href=\"/admin/" .$v['url']. "/edit/\">編集する</a></li>\n";
							break;
						case "sort":
							print "<li class=\"icon_sort\"><a href=\"/admin/" .$v['url']. "/sort/\">並び替える</a></li>\n";
							break;
						case "schedule":
							print "<li class=\"icon_schedule\"><a href=\"/admin/" .$v['url']. "/\">調整する</a></li>\n";
							break;
					}
				}

				print "</ul>\n";
			}
		}
	}
}
?>
</div>