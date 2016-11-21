<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>导航菜单</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>博客-详情页</title>
    <link rel="stylesheet" href="public/css/primer.css">
    <link rel="stylesheet" href="public/css/user-content.min.css">
    <link rel="stylesheet" href="public/css/octicons.css">
    <link rel="stylesheet" href="public/css/collection.css">
    <link rel="stylesheet" href="public/css/repo-card.css">
    <link rel="stylesheet" href="public/css/repo-list.css">
    <link rel="stylesheet" href="public/css/mini-repo-list.css">
    <link rel="stylesheet" href="public/css/boxed-group.css">
    <link rel="stylesheet" href="public/css/common.css">
    <link rel="stylesheet" href="public/css/share.min.css">
    <link rel="stylesheet" href="public/css/responsive.css">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/iconfont.css">
    <link rel="stylesheet" href="public/css/prism.css"></script>
	


<style>
body,td,th {
	font-family: Tahoma, Verdana, Arial, sans-serif;
	font-size: 12px;
	color: #333333;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a {
	color: #333333;
	text-decoration: none;
}
a:hover {
	color: #FF0000;
	text-decoration: none;
}
a:active{
	color: #FF0000;
	text-decoration: none;
}
#menu{
	height:32px;
	margin-top:8px; background-color:#990000;
}
#menu ul{
	margin:auto; width:778px; height:32px;
	list-style-type:none; padding:0px; margin-top:-10px; margin-bottom:0px;
}
.m_li{
	float:left; width:114px; line-height:32px;  text-align:center; margin-right:-2px; margin-left:-2px;
}
.m_li a{
	display:block; color:#FFFFFF; width:114px;
}
.m_line{
	float:left; width:1px; height:32px;
	line-height:32px;   /*ff下有效(图片垂直居中)*/
}
.m_line img{
	margin-top:expression(( 32 - this.height ) / 2);   /*ie下有效(图片垂直居中)*/
}
.m_li_a{
	float:left; width:114px; line-height:32px; text-align:center; padding-top:3px; font-weight:bold;
	position:relative; height:32px; margin-top:-3px; margin-right:-2px; margin-left:-2px;
}
.m_li_a a{
	display:block; color:#FF0000; width:114px;
}

.smenu{
	width:774px; margin:0px auto 0px auto; padding:0px; list-style-type:none; height:32px;
}
.s_li{
	line-height:32px; width:auto; display:none; height:32px; 
}
.s_li_a{
	line-height:32px; width:auto; display:block; height:32px; 
}


		.site-header {
			padding-top: 20px;
			padding-bottom: 20px;
			margin-bottom: 20px;
			background-color: #6CEEFE;
			border-bottom: 1px solid #eee;
			}
			
		.collection-head {
    padding: 1.5rem 0;
    margin-top: 0px;
    margin-bottom: 20px;
    background: url(/assets/images/octicons-bg.png) center #302F2F;
    box-shadow: inset 0 10px 20px rgba(0,0,0,.1);
    color: #fff;
}
	
</style>
<script>
//初始化
var def="1";
function mover(object){
  //主菜单
  var mm=document.getElementById("m_"+object);
  mm.className="m_li_a";
  //初始主菜单隐藏效果
  if(def!=0){
    var mdef=document.getElementById("m_"+def);
    mdef.className="m_li";
  }
  //子菜单
  var ss=document.getElementById("s_"+object);
  ss.style.display="block";
  //初始子菜单隐藏效果
  if(def!=0){
    var sdef=document.getElementById("s_"+def);
    sdef.style.display="none";
  }
}

function mout(object){
  //主菜单
  var mm=document.getElementById("m_"+object);
  mm.className="m_li";
  //初始主菜单
  if(def!=0){
    var mdef=document.getElementById("m_"+def);
    mdef.className="m_li_a";
  }
  //子菜单
  var ss=document.getElementById("s_"+object);
  ss.style.display="none";
  //初始子菜单
  if(def!=0){
    var sdef=document.getElementById("s_"+def);
    sdef.style.display="block";
  }
}
</script>
</head>
<body>
<div id="menu">
  <ul>
  
    <li id="m_1" class='m_li_a'><a href="index.php?m=article&a=person">个人介绍</a></li>
   
    <li id="m_2" class='m_li' onmouseover='mover(2);' onmouseout='mout(2);'><a href="index.php?m=article&a=add">发表博文</a></li>
   
    <li id="m_3" class='m_li' onmouseover='mover(3);' onmouseout='mout(3);'><a href="index.php?m=article">文章管理</a></li>

    <li id="m_7" class='m_li' onmouseover='mover(7);' onmouseout='mout(7);'><a href="index.php?m=replay">回复管理</a></li>
	
	  <li id="m_4" class='m_li' onmouseover='mover(5);' onmouseout='mout(5);'><a href="index.php?m=user&a=repassword">修改密码</a></li>
    
    <li id="m_5" class='m_li' onmouseover='mover(4);' onmouseout='mout(4);'><a href="index.php?m=user&a=logout">退出</a></li>
    
    <li id="m_6" class='m_li' onmouseover='mover(6);' onmouseout='mout(6);'><a href="index.php">返回首页</a></li>
	
  
   
   
  </ul>
</div>












<section class="banner">
    <div class="collection-head">
        <div class="container">
            <div class="collection-title">
                <h1 class="collection-header">Fly's Blog</h1>
                <div class="collection-info">
                    <span class="meta-info">
                        <span class="octicon octicon-location"></span>
                        China Beijing
                    </span>
                    <span class="tooltipped tooltipped-s tooltipped-multiline meta-info" aria-label="PHP, JavaScript, HTML+CSS, C/C++">
                        <span class="octicon octicon-code"></span>
                        Web development
                    </span>
                    <span class="meta-info">
                        <span class="octicon octicon-organization"></span>
                        <a href="http://weibo.com/kaiwenli" target="_blank">Weibo.com</a>
                    </span>
                    <span class="meta-info last-updated">
                        <span class="octicon octicon-mark-github"></span>
                        <a href="https://github.com/kaiwenli" target="_blank">董航宇</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
	
	
    <!-- / header -->
	
	
	<div class="container">
        <div class="columns">
            <div class="column three-fourths">
                <div class="collection-title">
                    <h1 class="collection-header"><a href=""> 姓名 ：董航宇</a></h1>
                    <div class="collection-info">
                        <span class="meta-info">
                            <span class="octicon octicon-calendar"></span> 
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / .banner -->
 <section class="container content">
    <div class="columns">
        <div class="column three-fourths">
            <article class="article-content markdown-body">
                

<blockquote>
  <p>出生于1994.12.25一个宁静的小村庄，地理位置十分优越
	<br />
	毕业的学校：合肥师范学院
	<br />
	专业是：物联网工程
	<br />
	在校奖励: 奖学金 、优秀团员、优秀劳动者
	<br />
	参加的活动有： 雷锋日、植树日、乒乓社
	<br />
	毕业时间：2012 - 2016
	<br />
	
	</p>

</blockquote>
            </article>

   
</body>
</html>