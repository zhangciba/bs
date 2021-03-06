<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title>毕业设计(论文管理系统)</title>
    <meta name="keywords" content="毕业设计" />
    <meta name="description" content="论文管理系统" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="/bs/Public/lib/pintuer/pintuer.css">
	<link rel="stylesheet" href="/bs/Public/css/menu.css">
	<link rel="stylesheet" href="/bs/Public/css/jquery.datetimepicker.css">
	<style type='text/css'>
	.box li{
		list-style:none;
		width:152px;
		height:45px;
		border:1px solid #000;
		padding-left:10px;
		float:left;
	}
	.text-edit-box{
		width:110px;
		height:45px;
		line-height:45px;
		float:left;
	}
	
	.text-del{
		width:20px;
		height:45px;
		line-height:45px;
		float:left;
	}
	.text-del:hover{
		cursor:pointer;
		color:#f00;
	}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
	<script src="/bs/Public/js/jquery.datetimepicker.js"></script>
	<script src="/bs/Public/js/menu.js"></script>
	<!----IE9以下增加media query-->
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
    <script type='text/javascript'>
	$(function(){
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=new pop(mask,container,title,body);
	/***相关链接处理***/
	$('.container-popup').find('.popup-title-close').bind('click',function(e){
		popup.hide();
	});
	//取消操作
	$('.container-popup').on('click','.btn-cancel',function(){popup.hide();});
	//时间插件
	(function($){
		$('#time_xt_end,#time_kt_end').datetimepicker({
			lang:'ch',
			startDate:'+1971/05/01'//or 1986/12/08
		});
		$('#time_xt_start,#time_kt_start').datetimepicker({
			lang:'ch',
			startDate:'+1971/05/01'//or 1986/12/08
		});
	})(jQuery);
	//保存
	(function(){
		$('.btn-save-xt').click(function(){
			var error=[];
			var data=[];
			var dT=[];
			//验证合法性
			$.each(['xt_start','xt_end','kt_start','kt_end'],function(i,e){
				var xt_v = $('#time_'+e).val();
				var xt_u = (new Date(xt_v)).getTime();
				dT.push(xt_u);
				var s='';
				if(i==0||i==3)s='开始';
				else if(i==2||i==4)s='截止';
				if(isNaN(xt_u))error.push(s+'日期不合法');
				data.push({k:e,v:xt_v});
			});
			
			if(dT[0]>dT[1])error.push('选题截止日期必须大于开始日期！');
			if(dT[2]>dT[3])error.push('上报课题截止日期必须大于开始日期！');
			if(error.length){
				popup.setTitle('提示').setBody('<p>'+error.join('')+'</p>').show();
				return false;
			}
			var f=$('input[name=tonews]:checked').length?1:0;
			$.post("<?php echo U('Admin/Sys/time_handler');?>",{type:'save',f:f,data:data},function(r){
				popup.setTitle('操作结果').setBody('<p class=text-center>'+r.msg+'</p>').show();
				if(r.status==1){setTimeout(function(){
					popup.hide();
					location.reload();
				},2000);}
			});
		})
	})();
	})
	</script>
  </head>
<body>
	<!---全屏--->
	<div id='content'>
		<div class='layout admin'>
			<!--左侧菜单栏-->
			<div class='x2 left'>
				<div class='line user-info'>
					<div class='user-img'><img src='https://ss1&#46;baidu&#46;com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58' class='img-border radius-circle' width=100 height=100></div>
					<div class='user-name'><p class='text-center'><?php echo ($user); ?></p></div>
				</div>
				<!---菜单开始-->
				<div class='line menu'>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Admin/Index/index');?>"><span class='icon-logo icon-home text-big'></span>开始</a>
						</dl>
						
						
						
						<dl class='mainmenu user'>
							<dt><span class='icon-logo icon-user text-big'></span>用户管理</dt>
								<dd class='link'><a href="<?php echo U('Admin/User/account');?>">新建用户</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/User/student');?>">学生</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/User/teacher');?>">教师</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/User/admin');?>">管理员</a></dd>
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>毕业设计</dt>
							
								<dd class='link'><a href="<?php echo U('Admin/Bs/preview');?>">课题总览</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Bs/view');?>">查看课题</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Bs/history');?>">历史数据查询</a></dd>
							
						</dl>
						<dl class='mainmenu sys'>
							<dt><span class='icon-logo icon-cog text-big'></span>系统设置</dt>
								<dd class='link'><a href="<?php echo U('Admin/Sys/init');?>">初始化</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Sys/sel');?>">选项配置</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Sys/time');?>">毕设时间设置</a></dd>
						</dl>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Home/Login/logout');?>"><span class='icon-logo icon-power-off text-big'></span>退出</a>
						</dl>
					
						<dl class='mainmenu text-center'>
							<p>请使用IE8+或chrome浏览</p>毕业管理系统管理后台
						</dl>
					
				</div>
				
				<!--菜单结束-->
				</div>
			<!---右侧具体内容-->
			<div class='x10 right'>
				<div class='line'>
				<!---班级，单位，毕设类型，方式--->
					<div style='height:20px'></div>
					<h3 class='doc-h3'>毕设时间设置</h3>
					<!---选题时间--->
					<div class='panel'>
						<div class='panel-head'>毕设时间</div>
						<div class='panel-body'>
							<div class="doc-h3" style="height:50px;line-height:50px;">毕设选题时间(学生)</div>
							开始时间<input type='text' class='input input-auto' size=18 id='time_xt_start' value='<?php echo ($time["xt_start"]); ?>'>
							截止时间<input type='text' class='input input-auto' size=18 id='time_xt_end' value='<?php echo ($time["xt_end"]); ?>'>
							
							
							<div class="doc-h3" style="height:50px;line-height:50px;">课题填报时间(教师)</div>
							开始时间<input type='text' class='input input-auto' size=18 id='time_kt_start' value='<?php echo ($time["kt_start"]); ?>'>
							截止时间<input type='text' class='input input-auto' size=18 id='time_kt_end' value='<?php echo ($time["kt_end"]); ?>'>
							<div class="op">
								<input type='checkbox' name='tonews'>同时发布时间更改动态
								<button class='button bg-main btn-save-xt'>保存</button>
							</div>
						</div>
					</div>
					
					
					
					
					
					
			</div>
		
			
			
		</div>
	</div>
	</div>
  <!---footer--->
  <div id='footer'>
	<p class='text-center'>CopyRight2015毕业设计(论文)管理系统</p>
  </div>
  <!---全局遮罩层-->
  <div class='mask' style='position:fixed;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);display:none;'>
		  <!---弹出层--->
		<div class='container-popup' style='position:relative;width:300px;margin:auto;margin-top:200px;display:none'>
		<div class='popup-title' style='width:100%;height: 38px;color:#fff;padding:0 10px;line-height: 38px;position: relative;background:rgb(51,51,51);background: -webkit-gradient(linear,left top,right top,from(#000),to(#767676));border-bottom: 1px solid #d1d6dd;'>
		<span class='popup-title-text'>标题</span>
		<span class='popup-title-close icon-times' style='float:right;cursor:pointer;'></span>
		</div>
		<div class='popup-body' style='background:#fff;color:#000;min-height:100px;padding:10px'>
		</div>
		</div>
  </div>

  
  
</body>
</html>