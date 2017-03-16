<?php
App::uses('AppController', 'Controller');
class ArtistController extends AppController {
	public $name = 'Artist';
	public $uses = [
		'Post',
		'Postmeta',
		'Term',
		'TermRelationship'
	];

	public function index()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}


	public function profile()
	{
		$term_id = null;
		$ary_artists = $this->getArtists();
		$action = $this->action;
		$controller = $this->params['controller'];
		$artist = str_replace([$action, $controller, '/'], ['', '', ''], $this->params->url);
		$ary_name = $ary_artists[$artist];
		$term = $this->Term->getTerm($artist . '/' . $action);
		if($term){
			$term_id = $term['Term']['term_id'];
		} else {
			throw new NotFoundException();
		}
		$post_ids = $this->TermRelationship->getPostIds($term_id);

		if($post_ids) {
			foreach($post_ids as $id) {
				$ids[] = $id['TermRelationship']['object_id'];
			}
		} else {
			throw new NotFoundException();
		}

		$posts = $this->Post->getPostsById($ids);
		if($posts) {
			$content = $posts[0]['Post'];
		} else {
			throw new NotFoundException();
		}
		$this->pageInit();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$ary_name['en'],
				$_action
			],
			[
				'/',
				'/'
			]
		);
		
		$this->set([
			'content' => $content,
			'title' => 'fankyjam',
			'ary_name' => $ary_name,
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function profile_detail()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function producing()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function media()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function discography()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function performance()
	{
		$term_id = null;
		$ary_artists = $this->getArtists();
		$action = $this->action;
		$controller = $this->params['controller'];
		$artist = str_replace([$action, $controller, '/'], ['', '', ''], $this->params->url);
		$ary_name = $ary_artists[$artist];
		$term = $this->Term->getTerm($artist . '/' . $action);
		if($term){
			$term_id = $term['Term']['term_id'];
		} else {
			throw new NotFoundException();
		}
		$post_ids = $this->TermRelationship->getPostIds($term_id);

		if($post_ids) {
			foreach($post_ids as $id) {
				$ids[] = $id['TermRelationship']['object_id'];
			}
		} else {
			throw new NotFoundException();
		}

		$posts = $this->Post->getPostsById($ids);
		if($posts) {
			$content = $posts[0]['Post'];
		} else {
			throw new NotFoundException();
		}
		$this->pageInit();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$ary_name['en'],
				$_action
			],
			[
				'/',
				'/'
			]
		);
		
		$this->set([
			'content' => $content,
			'title' => 'fankyjam',
			'ary_name' => $ary_name,
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function fanclub()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}


}
