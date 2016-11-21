<html>
	<head>
		<script type="text/javascript" charset="utf-8" src="./public/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="./public/ueditor/ueditor.all.min.js"> </script>
		 <script type="text/javascript" charset="utf-8" src="./public/ueditor/lang/zh-cn/zh-cn.js"></script>



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
	<link rel="stylesheet" href="public/editor/css/editormd.css" />
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




	</head>
	
	<body>
		

		<header class="site-header">
        <div class="container">
            <h1><a href="javascript:;"></a></h1>
            <nav class="site-header-nav" role="navigation">
                
				<?php if(empty($_SESSION['uid'])): ?>
					<a href="index.php?m=user&a=login">登陆</a>
					<a href="index.php?m=article&a=person">博主介绍</a>
				
				<?php else : ?>
				 
					<a href="index.php?m=article&a=person">博主介绍</a>
					<a href="index.php?m=article&a=add">发表博文</a>
					<a href="index.php?m=manage&a=index">管理</a>
					<a href="index.php">返回首页</a>
					<a href="index.php?m=user&a=logout">退出</a>

				<?php endif;?>
              
            </nav>
        </div>
    </header>


    <section class="banner">
    <div class="collection-head">
        <div class="container">
            <div class="collection-title">
                <h1 class="collection-header">发表博客</h1>
                <div class="collection-info">
                   
                    
                </div>
            </div>
        </div>
    </div>
</section>

















		<form action="index.php?m=article&a=insert" method="post">
			标题 ：<input type="text" name="title" width="800" /><br />
			<div id="test-editormd">
                <textarea name="content" style="display:none;">### Hello Editor.md !</textarea>
			</div>
			
			<input type="submit" value="发表" />
		
		</form>
	
	
	</body>
	<script>
		

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

	</script>
	 <script src="public/editor/jquery.min.js"></script>
        <script src="public/editor/editormd.min.js"></script>
        <script type="text/javascript">
			var testEditor;

            $(function() {
                testEditor = editormd("test-editormd", {
                    width   : "100%",
                    height  : 640,
                    syncScrolling : "single",
                    path    : "public/editor/lib/"
                });
                
                /*
                // or
                testEditor = editormd({
                    id      : "test-editormd",
                    width   : "90%",
                    height  : 640,
                    path    : "../lib/"
                });
                */
            });
        </script>
</html>