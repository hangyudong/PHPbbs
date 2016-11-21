<?php
namespace Controller;

use \Model\ArticleModel;
use \Framework\Page;
use \Model\ReplyModel;

class ShowController extends Controller
{
	
	public function index()
	{
		$article = new ArticleModel();
		
		$aid = $_GET['aid'];
		
		$data = $article->where("aid=$aid")->select();
		
		$this->assign('data',$data);

		$replay = new ReplyModel();

		$sql = "select count(rid) as t from bbs_reply where aid=$aid";

		$result = mysqli_query($replay->link,$sql);

		$count = mysqli_fetch_assoc($result);

		$total = $count['t'];

		$page = new Page($total);
		
		$current =  $page->limit();

		$reply = $replay -> where("aid=$aid")->limit($current) -> select();

		$this -> assign('reply',$reply);
		$this->assign('page',$page->render());

		$this->display(null,true,$_SERVER['REQUEST_URI']);
		
	}
	
}
