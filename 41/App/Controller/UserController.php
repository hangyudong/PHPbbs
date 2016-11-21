<?php
namespace Controller;

use \Model\UserModel;
use \Framework\Verify;

class UserController extends Controller
{
	protected $user;
	
	public function __construct()
	{
		parent::__construct();
		$this->user = new UserModel();
		
	}
	
	public function register()
	{
		
		$this->display();
		
	}
	
	
	public function logout()
	{
		unset($_SESSION);
		session_destroy();
		$this->success('退出成功','index.php');
	}
	
	public function checkLogin()
	{
		$username = $_POST['username'];
		
		$data = $this->user->where("username='$username'")->select();
		
		if ($data[0]['password'] != trim($_POST['password'])) {
			$this->error('密码错误');
		}
		
		$_SESSION['uid'] = $data[0]['uid'];
		$_SESSION['username'] = $data[0]['username'];
		
		$this->success('登陆成功','index.php');
		
	}
	
	
	public function  login()
	{
		
		$this->display();
	}
	
	public function check()
	{
		if (strcmp($_POST['password'],$_POST['repassword'])) {
			$this->error('两次密码不一致');
		}
		
		if(strcasecmp($_POST['verify'],$_SESSION['verify'])) {
			$this->error('验证码不正确');
		}
		
		$_POST['createtime'] = time();
		unset($_POST['repassword']);
		unset($_POST['verify']);
		$insert_id = $this->user->add($_POST);
	
		if ($insert_id) {
			$this->success('注册成功');
		} else {
			$this->error('注册失败','index.php');
		}
		
		
		
		
	}
	
	public function verify()
	{
		$verify = new Verify();
		$verify->outImg();
		$_SESSION['verify'] = $verify->verifyCode;
	}
	
	public function repassword()
	{
		$this -> display();
	}
	
	public function checkrepassword()
	{
		$aid = $_SESSION['uid'];
		
		$data = $this -> user ->where("uid = $aid")->select();
		
		$oldPassword = $data[0]['password'];
		
		$keyPassword = trim($_POST['password']);
		
		if($oldPassword != $keyPassword){
			
			$this -> error('密码匹配不成功，请输入正确的密码','index.php?m=user&a=repassword');
			exit;
			
		}
		
		$repassword  = trim($_POST['repassword']);
		$newpassword = trim($_POST['newpassword']);
		
		if( $repassword != $newpassword ){
			
			$this -> error('两次密码输入不一致，请重新输入','index.php?m=user&a=repassword');
			
			exit;
			
		}
		
		if(!$newpassword){
			
			$this -> error('新密码不能为空，请重新输入','index.php?m=user&a=repassword');
			
			exit;
			
		}
		
		unset($_POST['password']);
		unset($_POST['repassword']);
		$_POST['password'] = trim($_POST['newpassword']);
		unset($_POST['newpassword']);
		$id = $this -> user ->update($_POST);
		if($id){
			
			$this -> success('修改密码完成','index.php?m=manage&a=index');
			
		} else {
			
			$this -> error('密码修改失败','index.php?m=user&a=repassword');
			
		}
		
	}
	
	
	
	
	
}