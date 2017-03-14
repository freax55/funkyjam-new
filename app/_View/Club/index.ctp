<div class="main-columun-wrapper">
	<div style="width:100%;border:1px solid #000;margin:0 auto;background:#fff">
	<?php
	if (!isset($pref_name_ja)) {
		$pref_name_ja = false;
	}

	// 店舗
	$this->common->getFilterList('Shop', $params, $pref_name_ja, $data_shop_tag_categories, $data_tags_shop, $condition_list, 1, $shop_tag_category[1]['name'],  $shop_tag_category[1]['short_name']);
	$this->common->getFilterList('Shop', $params, $pref_name_ja, $data_shop_tag_categories, $data_tags_shop, $condition_list, 2, $shop_tag_category[2]['name'],  $shop_tag_category[2]['short_name']);
	$this->common->getFilterList('Shop', $params, $pref_name_ja, $data_shop_tag_categories, $data_tags_shop, $condition_list, 3, $shop_tag_category[3]['name'],  $shop_tag_category[3]['short_name']);

	// 嬢
	$this->common->getFilterList('Girl', $params, $pref_name_ja, $data_girl_tag_categories, $data_tags_girl, $condition_list, 1, $girl_tag_category[1]['name'],  $girl_tag_category[1]['short_name']);
	$this->common->getFilterList('Girl', $params, $pref_name_ja, $data_girl_tag_categories, $data_tags_girl, $condition_list, 2, $girl_tag_category[2]['name'],  $girl_tag_category[2]['short_name']);
	$this->common->getFilterList('Girl', $params, $pref_name_ja, $data_girl_tag_categories, $data_tags_girl, $condition_list, 3, $girl_tag_category[3]['name'],  $girl_tag_category[3]['short_name']);
	$this->common->getFilterList('Girl', $params, $pref_name_ja, $data_girl_tag_categories, $data_tags_girl, $condition_list, 4, $girl_tag_category[4]['name'],  $girl_tag_category[4]['short_name']);
	?>
	</div>

	<?= View::element('part_shop_list') ?>
</div>

<?php
// function getFilterList(
// 	$sg,
// 	$params,
// 	$pref_name_ja,
// 	$data_tag_categories,
// 	$data_tags,
// 	$condition_list,
// 	$category_id,
// 	$type,
// 	$short_name
// ) {
// 	$ds = null;
// 	if ($pref_name_ja) {
// 		$location_href = '/pref/' . $pref_name_en . '/';
// 	} else {
// 		$location_href = '/';
// 	}
// 	$html = '<h3 class="ttl ttl-black mt30">' . $data_tag_categories[$category_id] . '</h3>';
// 	$html.= '<ul class="ul-search-refine">';
// 	if (!empty($condition_list[$type]['current'][0])) {
// 		$current_id_type = array_flip($condition_list[$type]['current']);
// 	} else {
// 		$current_id_type = [];
// 	}
// 	$array_params = array();
// 	foreach ($params['named'] as $k => $v) {
// 		if (!is_array($v)) {
// 			$array_params[] = $k . ':' . $v;
// 		} else {
// 			foreach ($v as $v2) {
// 				$array_params[] = $k . ':' . $v2;
// 			}
// 		}
// 	}
// 	if (count($array_params) != 0) {
// 		$ds = '/';
// 	}
// 	foreach ($data_tags as $v) {
// 		if ($sg == 'Shop') {
// 			$v = $v['ShopTag'];
// 		} else {
// 			$v = $v['GirlTag'];
// 		}
// 		// $disabled_link = true;
// 		// foreach ($data as $v2) {
// 		// 	$v2 = $v2['Shop'];
// 		// 	if ($sg == 'Shop') {
// 		// 		if (isset($v2['tags']) && strpos($v2['tags'], "i:" . $v['id'] . ";s:1:\"1\";") !== false) {
// 		// 			$disabled_link = false;
// 		// 		}
// 		// 	} else {
// 		// 		if (isset($v2['tags_girl_default']) && strpos($v2['tags_girl_default'], "i:" . $v['id'] . ";s:1:\"1\";") !== false) {
// 		// 			$disabled_link = false;
// 		// 		}
// 		// 	}
// 		// }
// 		// if (!$disabled_link) {
// 		if ($v['category_id'] == $category_id) {
// 			if (isset($current_id_type[$v['id']])) {
// 				unset($array_params[array_search($short_name . ':' . $v['id'], $array_params)]);
// 				if (count($array_params) == 0) {
// 					$html.= '<li class="check"><a href="/shop' . $location_href . '" style="border:1px solid #000">' . $v['name'] . '</a></li>';
// 				} else {
// 					$html.= '<li class="check"><a href="/shop' . $location_href . implode($array_params, '/') . $ds . '" style="border:1px solid #000">' . $v['name'] . '</a></li>';
// 				}
// 				$array_params[] = $short_name . ':' . $v['id'];
// 			} else {
// 				$html.= '<li class="check"><a href="/shop' . $location_href . implode($array_params, '/') . $ds . $short_name . ':' . $v['id'] . '/">' . $v['name'] . '</a></li>';
// 			}
// 		// } else {
// 		// 	$html.= '<li>' . $v['name'] . '</li>';
// 		// }
// 		}
// 	}
// 	$html.= '</ul>';
// 	print $html;
// }
?>