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