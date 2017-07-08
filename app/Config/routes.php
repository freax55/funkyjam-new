<?php
Router::parseExtensions('xml', 'rss');
Router::connect('/', array('controller' => 'root', 'action' => 'index'));
Router::connect('/company', array('controller' => 'root', 'action' => 'company'));
Router::connect('/recruit', array('controller' => 'root', 'action' => 'recruit'));
Router::connect('/scout', array('controller' => 'root', 'action' => 'scout'));
Router::connect('/studio', array('controller' => 'root', 'action' => 'studio'));
Router::connect('/privacy', array('controller' => 'root', 'action' => 'privacy'));
Router::connect('/art', array('controller' => 'root', 'action' => 'art'));
Router::connect('/baribaricrew', array('controller' => 'root', 'action' => 'baribaricrew'));
Router::connect('/fanletter', array('controller' => 'root', 'action' => 'fanletter'));
Router::connect('/fanclub_ticket', array('controller' => 'root', 'action' => 'fanclub_ticket'));
Router::connect('/message', array('controller' => 'root', 'action' => 'message'));


App::uses('AppController', 'Controller');
$App = new AppController();
$artists = $App->getArtistParams();
foreach($artists as $v){
	Router::connect('/artist/:name' , array('controller' => 'artist', 'name' => $v, 'action' => 'index'));
	Router::connect('/artist/:name/media', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/producing', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/profile', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/profile_detail', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/discography', array('controller' => 'artist', 'name' => $v, 'action' => 'discography'));
	Router::connect('/artist/:name/performance', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	Router::connect('/artist/:name/gallery', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));
	// Router::connect('/artist/:name/otherwork', array('controller' => 'artist', 'name' => $v, 'action' => 'contents'));	
	Router::connect('/artist/*', array('controller' => 'artist', 'action' => 'news_contents'));
}


CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';