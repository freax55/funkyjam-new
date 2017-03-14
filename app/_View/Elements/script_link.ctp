var arr_ja = ['北海道','青森','岩手','宮城','秋田','山形','福島','茨城','栃木','群馬','埼玉','千葉','東京','神奈川','新潟','富山','石川','福井','山梨','長野','岐阜','静岡','愛知','三重','滋賀','京都','大阪','兵庫','奈良','和歌山','鳥取','島根','岡山','広島','山口','徳島','香川','愛媛','高知','福岡','佐賀','長崎','熊本','大分','宮崎','鹿児島','沖縄'];
var arr_en = ['hokkaido','aomori','iwate','miyagi','akita','yamagata','fukushima','ibaraki','tochigi','gunma','saitama','chiba','tokyo','kanagawa','niigata','toyama','ishikawa','fukui','yamanashi','nagano','gifu','shizuoka','aichi','mie','shiga','kyoto','osaka','hyougo','nara','wakayama','tottori','shimane','okayama','hiroshima','yamaguchi','tokushima','kagawa','ehime','kouchi','fukuoka','saga','nagasaki','kumamoto','oita','miyazaki','kagoshima','okinawa'];
var pref_ja = arr_ja[12];
var pref_en = arr_en[12];

replacePref($(".select-pref :selected").val()-1);

$(".select-pref").change(function(){
	$(".select-pref").val($(this).val())
	replacePref($(this).val()-1)
});

function replacePref(_this){
	ja = arr_ja[_this];
	en = arr_en[_this];

	$('.bnr-change').each(function(){
		var txt = $(this).html();
		$(this).html(
			txt.replace(RegExp(pref_ja, 'g'), ja)
		);
	});
	$('.bnr-change').each(function(){
		var txt = $(this).html();
		$(this).html(
			txt.replace(RegExp(pref_en, 'g'), en)
		);
	});
	pref_ja = ja;
	pref_en = en;
}
