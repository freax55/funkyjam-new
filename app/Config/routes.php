<?php
Router::parseExtensions('xml', 'rss');
Router::connect('/', array('controller' => 'root', 'action' => 'index'));
Router::connect('/company', array('controller' => 'root', 'action' => 'company'));
Router::connect('/recruit', array('controller' => 'root', 'action' => 'recruit'));
Router::connect('/scout', array('controller' => 'root', 'action' => 'scout'));
Router::connect('/studio', array('controller' => 'root', 'action' => 'studio'));


App::uses('AppController', 'Controller');
$App = new AppController();
$artists = $App->getArtistParams();
foreach($artists as $v){
	Router::connect('/artist/:name' , array('controller' => 'artist', 'name' => $v, 'action' => 'index'));
	Router::connect('/artist/:name/profile', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/discography', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/performance', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/*', array('controller' => 'artist', 'action' => 'news_contents'));
}


CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';