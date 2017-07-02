<script>
	$( document ).ready(function( $ ) {
		$('#thumb-h').sliderPro({
			width:1140,//横幅
			height: 420,
			buttons: false,//ナビゲーションボタン
			// shuffle: true,//スライドのシャッフル
			thumbnailWidth: 225,//サムネイルの横幅
			thumbnailHeight: 80,//サムネイルの縦幅
			slideDistance:0,//スライド同士の距離
			breakpoints: {
				480: {//表示方法を変えるサイズ
					thumbnailWidth: 110,
					thumbnailHeight: 40
				}
			}
		});
	});
</script>