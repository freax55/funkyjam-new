<?php
$auth_user = $this->Session->read('User');
$disabled_text = '<span style="color:#999">[変更不可]</span> <a href="javascript:void(0);" class="tt" title="変更するには、担当営業マンにお問い合わせください。">変更するには？</a>';
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?> -タグ設定</h2>
	<h3><?= $data['Shop']['name'] ?></h3>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	if ($data[$controller_camel_case]['id'] != "") {
		$view_shop_detail = '<div class="pull-left"><a href="/shop/detail/' . $data[$controller_camel_case]['id'] . '/" class="btn btn-success" target="_blank">掲載ページを確認</a></div>';
	} else {
		$view_shop_detail = "";
	}
	print $this->common->getContentHeader($view_shop_detail, $buttons);
	?>
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'tag', 'url'=>'/admin/' .$params['controller']. '/tag/' . $data[$controller_camel_case]['id'] . '/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	print $this->Form->input('name', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['name']
	));
	?>
	<table class="table table-bordered">
		<tr>
			<th colspan="2" class="sep_row">タグ設定</th>
		</tr>
		<tr>
			<td>
				<?= $this->Form->error("Shop.tags") ?>
				<?php
				$tags = json_decode($data[$controller_camel_case]['tags'], true);
				if ($auth_user['User']['role_id'] <= 3) {
					foreach ($data_shop_tag_categories as $k2 => $v2) {
						print '<fieldset>';
						print '<legend>' . $v2 . '</legend>';
						foreach ($data_shop_tags as $k => $v) {
							$v = $v['ShopTag'];
							if ($v['category_id'] == $k2) {
								print '<div style="float: left; margin: 0 0 10px 0; width: 200px;">';
								print $this->Form->input('tags]['.$v['id'], array(
									'type' => 'checkbox',
									'value' => 1,
									'label' => false,
									'checked' => @($tags[$v['id']] == 1) ? true : false,
									'div' => false,
								));
								print $this->Form->label('tags]['.$v['id'], $v['name'], ['class'=>'tt','title'=>$v['content']]);
								print "</div>\n\n";
							}
						}
						print '</fieldset>';
					}
				?>
				<?php
				} else {
					foreach ($data_shop_tags as $k => $v) {
						$v = $v['ShopTag'];
						if (@$tags[$v['id']] == 1) {
							$shop_tags[] = $v['name'];
						}
						print $this->Form->input('tags][' . $v['id'], array(
							'type' => 'hidden',
							'value' => (isset($tags[$v['id']])) ? true : false
						));
					}
					if (!empty($shop_tags)) {
						print $disabled_text . implode('、', $shop_tags);
					} else {
						print $disabled_text . 'タグが付けられていません。';
					}
				}
				?>
				<?= $this->Form->error("Shop.tags_girl") ?>
				<?php
				$tags_girl = json_decode($data[$controller_camel_case]['tags_girl'], true);
				if ($auth_user['User']['role_id'] <= 3) {
					foreach ($data_girl_tag_categories as $k2 => $v2) {
						// バストカップは自動で処理するので表示しない
						if ($k2 != 4) {
							print '<fieldset>';
							print '<legend>' . $v2 . '</legend>';
							foreach ($data_girl_tags as $k => $v) {
								$v = $v['GirlTag'];
								if ($v['category_id'] == $k2) {
									print '<div style="float: left; margin: 0 0 10px 0; width: 200px;">';
									print $this->Form->input('tags_girl]['.$v['id'], array(
										'type' => 'checkbox',
										'value' => 1,
										'label' => false,
										'checked' => @($tags_girl[$v['id']] == 1) ? true : false,
										'div' => false,
									));
									print $this->Form->label('tags_girl]['.$v['id'], $v['name'], ['class'=>'tt','title'=>$v['content']]);
									print "</div>\n\n";
								}
							}
							print '</fieldset>';
						}
					}
				?>
				<?php
				} else {
					foreach ($data_girl_tags as $k => $v) {
						$v = $v['GirlTag'];
						if (@$tags_girl[$v['id']] == 1) {
							$girl_tags[] = $v['name'];
						}
						print $this->Form->input('tags_girl][' . $v['id'], array(
							'type' => 'hidden',
							'value' => (isset($tags_girl[$v['id']])) ? true : false
						));
					}
					if (!empty($girl_tags)) {
						print $disabled_text . implode('、', $girl_tags);
					} else {
						print $disabled_text . 'タグが付けられていません。';
					}
				}
				?>
			</td>
		</tr>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
