<html>
	<head>
		<script type="text/javascript" charset="utf-8" src="./public/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="./public/ueditor/ueditor.all.min.js"> </script>
		 <script type="text/javascript" charset="utf-8" src="./public/ueditor/lang/zh-cn/zh-cn.js"></script>
		<style>
			
		
		</style>

	</head>
	
	<body>
		
		<form action="index.php?m=article&a=editor" method="post">
			标题 ：<input type="text" name="title" value="<?=$data[0]['title'];?>" /><br />
			
			<input type="hidden" name="aid" value="<?=$data[0]['aid'];?>" />
			
			 <script id="editor" type="text/plain" style="width:1024px;height:500px;" ><?=$data[0]['article'];?></script>
			 

			
			<input type="submit" value="发表" />
		
		</form>
	
	
	</body>
	<script>
		

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

	</script>
	
</html>