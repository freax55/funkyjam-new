<?php
Router::parseExtensions('xml', 'rss');
Router::connect('/', array('controller' => 'root', 'action' => 'index'));
Router::connect('/company', array('controller' => 'root', 'action' => 'company'));
Router::connect('/recruit', array('controller' => 'root', 'action' => 'recruit'));
Router::connect('/scout', array('controller' => 'root', 'action' => 'scout'));
Router::connect('/studio', array('controller' => 'root', 'action' => 'studio'));


// App::uses('AppController', 'Controller');
// $App = new AppController();
// $prefs_en = $App->getPrefs('en');
// foreach ($prefs_en as $v) {
// 	Router::connect('/' . $v . '/*', array('controller' => 'pref', 'action' => 'index', 'type' => 'pref'));
// }

// Router::connect('/admin', array('controller' => 'user', 'action' => 'login'));
// Router::connect('/admin/logout', array('controller' => 'user', 'action' => 'logout'));
$artists = [
	'kubota',
	'urashima',
	'mori',
	'bse'
];
foreach($artists as $v){
	Router::connect('/artist/' . $v . '/profile', array('controller' => 'artist', 'action' => 'profile'));
	Router::connect('/artist/' . $v . '/discography', array('controller' => 'artist', 'action' => 'discography'));
	Router::connect('/artist/' . $v . '/performance', array('controller' => 'artist', 'action' => 'performance'));
}
// Router::connect('/artist/' . $v . '/profile', array('controller' => 'artist', 'action' => 'profile'));
// Router::connect('/artist/' . $v . '/profile', array('controller' => 'artist', 'action' => 'profile'));
// Router::connect('/artist/' . $v . '/profile', array('controller' => 'artist', 'action' => 'profile'));


CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';