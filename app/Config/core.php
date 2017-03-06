<?php
require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'deployment.php');

Configure::write('debug', DEBUG_LEVEL);
Configure::write('Error', array(
	'handler' => 'ErrorHandler::handleError',
	'level' => E_ALL & ~E_DEPRECATED,
	'trace' => true
));
Configure::write('Exception', array(
	'handler' => 'ErrorHandler::handleException',
	'renderer' => 'ExceptionRenderer',
	'log' => true
));
Configure::write('App.encoding', 'UTF-8');
Configure::write('Routing.prefixes', array('admin'));
Configure::write('Session', array(
	'defaults' => 'php'
));
Configure::write('Security.salt', 'DYhG23b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');
Configure::write('Security.cipherSeed', '76859309237453542496749683645');
Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');

Cache::config('default', array(
       'engine' => CACHE_ENGINE, //[required]
       'duration' => 3600, //[optional]
       'probability' => 100, //[optional]
       'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
));

$engine = CACHE_ENGINE;
$duration = '+999 days';
if (Configure::read('debug') > 0) {
	$duration = '+10 seconds';
}
$prefix = 'myapp_';
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_model_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));