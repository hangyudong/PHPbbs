<?php
namespace Controller;

use \Model\ArticleModel;
use \Model\ReplyModel;
use \Framework\Page;

class ArticleController extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		
		if (empty($_SESSION['uid'])) {
			$this->error('没有登陆');
		}
		
	}
	
	public function index()
	{
		$article = new ArticleModel();
		
		$total = $article->count();
		
		$page = new Page($total);
		
		$current =  $page->limit();
		
		
		$data = $article->limit($current)->order('aid desc')->select();
		
		$this->assign('page',$page->render());
		$this->assign('articles',$data);
		$this->display(null,true,$_SERVER['REQUEST_URI']);
		
	}
	
	public function add()
	{
		$this->display();
	}
	
	public function insert()
	{
		$article = new ArticleModel();
		
		$_POST['createtime'] = time();
		$_POST['article'] = $_POST['content'];
		unset($_POST['content']);
		
		$id = $article->add($_POST);
		
		if ($id) {
			$this->success('发表成功','index.php');
		} else {
			$this->error('发表失败');
		}
	}
	
	public function del()
	{
		$aid = $_GET['aid'];
		
		$delete = new ArticleModel();
		
		$id = $delete -> where("aid = $aid") ->delete();
		
		if($id){
			
			$this -> success('删除成功','index.php?m=article');
			
		}
	}
	
	public function edit()
	{
		$article = new ArticleModel();
		
		$aid = $_GET['aid'];
		
		$data = $article->where("aid = $aid")->select();
		
		$this->assign('data',$data);
		
		$this->display(null,true);
		
		
	}
	
	public function editor()
	{
		$article = new ArticleModel();
		
		$aid = $_POST['aid'];
		
		$title = $_POST['title'];
		
		$_POST['article'] = $_POST['editorValue'];
		
		unset($_POST['editorValue']);
		
		$id = $article->where("aid = $aid")->update($_POST);
		
		
			if($id) {
				
				$this -> success('编辑成功','index.php?m=article');
				
			} else {
				
				$this -> error('编辑失败','index.php?m=article');
				
			}
	}
	
	public function person(){
		
	
		$this -> display();
		
	}


	public function reply(){

		//判断回复名是否符合规范
		
		$replyName = trim($_POST['replyName']);
		$aid = $_GET['aid'];

		if (!(strlen($replyName) > 3 && strlen($replyName) < 20)) {
		
			$this -> error('回复名不能为空，长度在3-10长度','index.php?m=show&aid='.$aid);

		} 
		$_POST['aid'] = $aid;
		$_POST['content'] = trim($_POST['editorValue']);

		//判断评论是否存在，如果不存在返回一个错误
		
		if (!$_POST['content']) {
			
			$this ->  error('评论不能为空','index.php?m=show&aid='.$aid);


		} 
		

		unset($_POST['editorValue']);
		unset($_POST['replyName']);

		$reply = new ReplyModel();

		$_POST['createtime'] = time();

		$_POST['replyname'] = $replyName;
		

		$id = $reply  -> where("aid = $aid") -> add($_POST); 


		if ($id) {
		
	
			$this -> success('评论成功','index.php?m=show&aid='.$aid);
		
		} else {
		
			
			$this -> error('评论失败,可能和人品有着巨大的关系','index.php?m=show&aid='.$aid);

		}
		



	}
	
}
