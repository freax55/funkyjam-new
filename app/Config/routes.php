<?php
Router::parseExtensions('xml', 'rss');
Router::connect('/', array('controller' => 'root', 'action' => 'index'));

// App::uses('AppController', 'Controller');
// $App = new AppController();
// $prefs_en = $App->getPrefs('en');
// foreach ($prefs_en as $v) {
// 	Router::connect('/' . $v . '/*', array('controller' => 'pref', 'action' => 'index', 'type' => 'pref'));
// }

// Router::connect('/admin', array('controller' => 'user', 'action' => 'login'));
// Router::connect('/admin/logout', array('controller' => 'user', 'action' => 'logout'));

CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';