<?php
use Shared\Controller as Controller;
use Framework\ArrayMethods as ArrayMethods;
use Framework\Router as Router;
use Framework\Registry as Registry;
use Framework\RequestMethods as RequestMethods;
use Cocur\Slugify;

class Home extends Controller
{	
	public function index()
	{
		$view = $this->getActionView();
		$articles = Article::all(array('live=?'=>TRUE,'deleted=?'=>FALSE),array('*'),'created','desc',12,1);
		$author = Author::all(array('live=?'=>TRUE,'deleted=?'=>FALSE),array('*'));
		
		$view->set('articles',$articles)->set('author',$author);
	}

}