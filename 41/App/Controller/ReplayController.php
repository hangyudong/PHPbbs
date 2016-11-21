<?php
namespace Controller;

use \Model\ArticleModel;
use \Model\ReplyModel;
use \Framework\Page;


class ReplayController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$_SESSION['uid']) {
			
			echo '你没有权限';
		}
	}

	public function Index()
	{
		
		$reply = new ReplyModel();

		$data = $reply -> select();

		$total = $reply->count();
		
		$page = new Page($total);
		
		$current =  $page->limit();
		
		$data = $reply->limit($current)->order('rid asc')->select();

		$this -> assign('page',$page->render());
		$this -> assign('data',$data);
		$this -> display(null,true,$_SERVER['REQUEST_URI']);
	
	}

	public function del()
	{
		
		$delete = new ReplyModel();

		$rid = $_GET['rid'];

		$page = $_GET['page'];

		$id = $delete -> where("rid = $rid") -> delete();

		if ($id) {
			
			$this -> success('删除成功','index.php?m=replay');

		}
	}


}