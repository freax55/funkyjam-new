function callShop(coupon,shopid,bonus){
  if (coupon == 'y') {
    if (bonus != 0 ) {
      var msg = 'と伝えると' + bonus + '円割引になります。';
    } else {
      var msg = 'と伝えないと割引が受けられません。';
    }
  } else {
    var msg = 'と伝えないと割引が受けられません。';
  }
  alert('「デリヘルOK見た」' + msg);
}

function getUnique()
{
  d = new Date().getTime();
  return d;
}
function openWindow(href, width, height)
{
  window.open(href, "", "width=" + width + ", height=" + height + ", menubar=no, scrollbars=yes");
}
function deleteRecord(href)
{
  if (window.confirm('削除してもよろしいですか？')) {
    location.href = href;
  }
}
function sbm(formName){
  document.forms[formName].submit();
}
function sbmNewWindow(formName, href, width, height){
  window.open(href, "myApp", "width=" + width + ", height=" + height + ", menubar=yes,scrollbars=yes");
  document.forms[formName].submit();
}

function windowClose(){
  window.close();
  return false;
}

function customHistoryBack(){
  location.href = document.referrer;
}

$.fn.disableOnSubmit = function(disableList){

  if(disableList == null){var $list = 'input[type=submit],input[type=button],input[type=reset],button';}
  else{var $list = disableList;}

  // Makes sure button is enabled at start
  $(this).find($list).removeAttr('disabled');

  $(this).submit(function(){$(this).find($list).attr('disabled','disabled');});
  return this;
};

// 参考になった！
function iine(id,type) {
  $.ajax({
    url: "/hotel/iine/" + type + "/" + id + "/"
  }).then(function(data){
    $('#cnt' + id).text(data);
  }, function(data){
    alert("既に「参考になった」を押しています！");
  });
}

jQuery(function($){
    $("#jquery_jplayer_1").jPlayer({
    ready: function () {// jPlayer の準備ができたら実行される処理を記述
      $(this).jPlayer("setMedia", {
        mp3: "/sound.mp3" //再生するメディアを指定 カンマ区切りで複数指定できる。
      });
    },
    cssSelectorAncestor: '#jp_container_1', // コントロール部分をラップしているコンテナ
    cssSelector: {play: '.jp-play',pause: '.jp-pause'}, // cssセレクタを指定、それぞれメソッドに対応
    loop: false, // ループ再生　
    volume: 0.2, // ボリューム 0~1で指定
    swfPath: "js/jplayer", // Jplayer.swfのパス html5で再生されなかった場合、フラッシュで再生される
    ssupplied: 'mp3', // フォーマット（カンマ区切りで複数指定できる、優先度は左が高い）
    play: function(){
            // 再生時の処理
            $('.track-name').addClass('active');
    },
    pause: function(){
      // ポーズ時の処理
            $('.track-name').removeClass('active');
    },
    ended: function(){
      // 最後まで流れた時の処理
            $('.track-name').removeClass('active');
    }
    });
});

