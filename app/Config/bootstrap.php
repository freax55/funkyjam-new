<?php
require_once(APP.'Config'.DS.'deployment.php');

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

define('MYDOMAIN', 'fj-new.untamed.com');
define('MYHOST', env('HTTP_HOST'));

define('SEP', ' | ');
define('SITENAME', 'ファンキージャム');
define('SITENAMESHORT', 'ファンキージャム');
define('SITENAMEMETA', SEP . 'ファンキージャム');
define('SITENAMEADMIN', SEP . SITENAME);
define('TITLE', SITENAMEMETA);
define('DESCRIPTION', 'funkyjam公式サイト');
define('H1', TITLE);

define('LAT', '35.659612');
define('LON', '139.723835');
define('ZOOM', '16');

// Files
define('IMG_DIR', ASSETS . 'img/');
define('JSON_DIR', ASSETS . 'files/json/');
define('JSON_DIR_AREA', JSON_DIR . 'area/');
define('JSON_DIR_STATION', JSON_DIR . 'station/');
define('JSON_DIR_CITY', JSON_DIR . 'city/');
define('JSON_DIR_TOWN', JSON_DIR . 'town/');

define('CSV_DIR', ASSETS . 'files/csv/');

// 一時間（3600秒）として、何秒遅らせるかによって任意の日付変更線を定義する
// 18000 = 5:00
define('DELAY', 18000);
define('TODAY', mktime(0, 0, 0, date("m"), date("d"), date("y")));
define('NOW_DATE_TIME', date("H:i:s"));
define('ONE_WEEK_AGO', date('Y-m-d H:i:s', strtotime('-1 week')));

// ファイル更新時のキャッシュ問題をクリアするためのバージョン番号
define('VERSION_JS', '1.0.0');
define('VERSION_CSS', '1.0.2');

define('ANONYMOUSE', '匿名');
