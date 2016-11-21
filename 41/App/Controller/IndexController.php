<?php
namespace Controller;

use \Model\ArticleModel;
use \Framework\Page;

class IndexController extends Controller
{
	
	public function index()
	{
		$article = new ArticleModel();
		
		$total = $article->count();
		
		$page = new Page($total);
		
		$current =  $page->limit();
		
		
		$data = $article->limit($current)->order('aid desc')->select();
		
		$this->assign('page',$page->render());
		$this->assign('data',$data);
		$this->display(null,true,$_SERVER['REQUEST_URI']);
		
	}


	
	public function edit()
	{
		echo 222;
	}
	
}
