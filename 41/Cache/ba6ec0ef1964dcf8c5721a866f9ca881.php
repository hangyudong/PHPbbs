<!DOCTYPE html>
<html lang="zh-cmn-Hans" prefix="og: http://ogp.me/ns#" class="han-init">
<head>
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
	
	.site-header {
    padding-top: 20px;
    padding-bottom: 20px;
    margin-bottom: 20px;
    background-color: #6CEEFE;
    border-bottom: 1px solid #eee;
	}
	

    .three-frist a{
        
        padding-left:17%;
        }
	</style>


    <script type="text/javascript" charset="utf-8" src="./public/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="./public/ueditor/ueditor.all.min.js"> </script>
         <script type="text/javascript" charset="utf-8" src="./public/ueditor/lang/zh-cn/zh-cn.js"></script>

</head>
<body class="">
    <header class="site-header">
        <div class="container">
            <h1><a href="javascript:;"></a></h1>
            <nav class="site-header-nav" role="navigation">
                
				<?php if(empty($_SESSION['uid'])): ?>
					<a href="index.php?m=user&a=login">登陆</a>
				<?php else : ?>
					<a href="index.php?m=article&a=add">发表博文</a>
					<a href="index.php?m=manage&a=index">管理</a>
					<a href="index.php?m=user&a=logout">退出</a>
				<?php endif;?>
              <a href="index.php">返回首页</a>
            </nav>
        </div>
    </header>
	<section class="banner">
    <div class="collection-head">
        <div class="container">
            <div class="collection-title">
                <h1 class="collection-header">fight's Blog</h1>
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
                        <a href="https://github.com/kaiwenli" target="_blank">董航宇
                        </a>
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
                    <h1 class="collection-header"><a href=" "><?=$data[0]['title'];?></a></h1>
                    <div class="collection-info">
                        <span class="meta-info">
                            <span class="octicon octicon-calendar"></span> <?=date('Y/m/d H:i:s',$data[0]['createtime'])?>
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

  <p>内容是：<?=$data[0]['article'];?></p>

</blockquote>
            </article>

</section>

<br /><br />


    <div class="container">
        <div class="columns">
            <div class="column three-fourths">
                <div class="collection-title">
                    <h2 class="collection-header"><a href=" ">评论</a></h2>
                    <div class="collection-info">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<br /><br />


			<?php 
			$i=1;
			$paper = (empty($_GET['page']))?1:$_GET['page'];

			?>
			<?php foreach($reply as $val) :?>


            <div class="container">
        <div class="columns">
                           <div class="collection-title">
                 <a href=" ">评论者： <?=$val['replyname'];?></a>
                 <br />
                 第<?php

						echo ($paper - 1)*5 + $i;

                 ?>楼
                    <div class="collection-info">
                        <span class="meta-info">
                            <span class="octicon octicon-calendar"></span> 

                                    <?=date('Y-m-d H:i:s',$val['createtime']);?>
                        </span>
                    </div>
                </div>
            </div>
        </div>


         <section class="container content">
    <div class="columns">
        <div class="column three-fourths">
            <article class="article-content markdown-body">
                

<blockquote>

  <p>内容是： <?=$val['content'];?></p>

</blockquote>
            </article>

</section>

<?php $i++;?>
            <?php endforeach;?>

    <div class="three-frist">
    <a href = "<?=$page['first'];?>"> 首页</a>

    <a href = "<?=$page['prev'];?>">上一页</a>

    <a href = "<?=$page['next'];?>">下一页</a>

    <a href = "<?=$page['end'];?>">尾页</a>   
    </div>

         

			
<br />	
欢迎评论，以上只是个人见解
<br />


<form action="index.php?m=article&a=reply&aid=<?=$data[0]['aid'];?>" method="post">

            回复名 ：<input type="text" name="replyName" />
            (回复名不能为空，长度在3-10长度)
            <br />
             <script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>

            
            <input type="submit" value="回复" />
        
        </form>	


        
</body>

    <script>
        

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

    </script>

</html>