<div class="form-actions tac mt30">
	<ol class="pagination">
		<?php
		// カスタムURL対処
		// routes.phpを見ろ
		if ($this->params['controller'] == 'pref') {
			$action = $prefs_en[$pref_id];
//			if (isset($this->params['action']) && $this->params['action'] != 'index') {
//				$action = $prefs_en[$pref_id] . '/' . $this->params['action'] . '/' . $this->params['pass'][0];
//			}
			// ロケーション
			if (isset($this->params['type']) && $this->params['type'] != 'pref') {
				$action.= DS . $this->params['type'] . DS . $this->params['pass'][0];
			}
			// タグ
			if (isset($this->params['named']) && isset($shop_tag_category)) {
				// 店舗タグ
				$tag_shop = [];
				$short_name_shop = array_map(function($r) { return $r['short_name']; }, $shop_tag_category);
				foreach (explode('/', $this->params->url) as $v) {
					if (in_array(substr($v, 0, 2), $short_name_shop)) {
							$tag_shop[] = substr($v, 0, 2) . ':' . substr($v, 3);
					}
				}
				if (!empty($tag_shop)) {
					$action = $action . DS . implode('/', $tag_shop);
				}
				// 嬢タグ
				$tag_girl = [];
				$short_name_girl = array_map(function($r) { return $r['short_name']; }, $girl_tag_category);
				foreach (explode('/', $this->params->url) as $v) {
					if (in_array(substr($v, 0, 2), $short_name_girl)) {
							$tag_girl[] = substr($v, 0, 2) . ':' . substr($v, 3);
					}
				}
				if (!empty($tag_girl)) {
					$action = $action . DS . implode('/', $tag_girl);
				}
			}
			// 見栄え切り替え
			$options = [
				'url' => [
					'controller' => '',
					'action' => $action,
				]
			];
			if (isset($this->params->query['view'])) {
				$options['url']['?'] = 'view=girls';
			}
			$this->Paginator->options($options);
		}
		echo $this->Paginator->first('<<', array('tag' => 'li'));
		echo $this->Paginator->prev(__('<'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1, 'modulus'=>$pg_num));
		echo $this->Paginator->next(__('>'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
		echo $this->Paginator->last('>>', array('tag' => 'li'));
		?>
	</ol>
</div>