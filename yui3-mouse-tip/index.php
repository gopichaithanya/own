<!DOCTYPE html>
<html lang="zh">
<head>
	<title> Y.Postip 基于YUI3的相对提示 </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" type="text/css" href="/demo/style.css">
	<style type="text/css">
	body.yui-skin-sam .yui-separate-console{_position:absolute; }
	.tell{display:block;padding:16px 10px;margin:5px 0 15px;background:#f4f4f4;-moz-border-radius:4px;-khtml-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;}
	.tell strong{display:block;padding-bottom:10px;}
	#demo1{border:5px solid green;background-color:#AFE685;width:200px;height:80px;}
	.postip{width:100px;height:50px;border:3px solid #333;background-color:#d4d4d4;}
	.state{padding:10px;border:3px dashed #d5d5d5; }
	.checkarea li{float:left;margin-right:10px;font:700 14px/1.6em 'Times','simsun' ;}
	.checkarea li input{margin-left:5px;}
	/*演示*/
	.yin{margin-right:14px;vertical-align:middle;}
	.tip1{padding:0 15px 0 0;margin-left:6px;background:url('img/question-small-white.png') no-repeat 100% 0;border-bottom:1px dashed #2173AF;cursor:help;}
	.tool-tip{width:276px;height:100px;background:url('img/tip_bg.gif') no-repeat;}
	.tool-tip .content{width:228px;margin:12px auto 0;position:relative;}
	.tool-tip .content span{width:13px;height:13px;display:block;cursor:pointer;position:absolute;right:-1px;top:-13px;}
	</style>
</head>
 
<body class="yui-skin-sam">
<div id="doc" class="demo">
	<div id="hd">
		<div class="page-title">
			<h1>Y.Postip 基于YUI3的相对提示</h1>
		</div>
	</div>
	<div id="bd">
		<h2>新建提示相对于绿框定位</h2>
		<div id="demo1" style="margin-bottom:1px">点我</div><br/>
		<div class="state">
			<ul class="checkarea clearfix">
				<li>水平方向(hAlign)选择(pos:{h:'*'}):</li>
				<li><label for="oleft">oleft</label><input type="radio" name="hAlign" id="oleft"/></li>
				<li><label for="left">left</label><input type="radio" name="hAlign" id="left" checked/></li>
				<li><label for="center">center</label><input type="radio" name="hAlign" id="center"/></li>
				<li><label for="right">right</label><input type="radio" name="hAlign" id="right"/></li>
				<li><label for="oright">oright</label><input type="radio" name="hAlign" id="oright"/></li>
			</ul>
			<ul class="checkarea clearfix" id="check2">
				<li>垂直方向(vAlign)选择(pos:{v:'*'}):</li>
				<li><label for="otop">otop</label><input type="radio" name="vAlign" id="otop"/></li>
				<li><label for="top">top</label><input type="radio" name="vAlign" id="top"/></li>
				<li><label for="middle">middle</label><input type="radio" name="vAlign" id="middle"/></li>
				<li><label for="bottom">bottom</label><input type="radio" name="vAlign" id="bottom"/></li>
				<li><label for="obottom">obottom</label><input type="radio" name="vAlign" id="obottom" checked/></li>
			</ul>
			<ul class="checkarea clearfix" id="check3">
				<li><label for="no">无动画:no</label><input type="radio" name="anim" id="no"/></li>
				<li><label for="fade">渐显:fade</label><input type="radio" name="anim" id="fade"/></li>
				<li><label for="expand">扩展:expand</label><input type="radio" name="anim" id="expand"/></li>
			</ul>
		</div>
		<p>&nbsp;</p>	
		<div class="tell">
			<h2>下面看看我们能用这组件做些啥！</h2>
			<div class="pos clearfix">
				<!--img src="img/aligntemp.png" alt="" class="fl"/-->
				<p><img src="img/arrow-curve-000-left.png" alt="" class="yin"/>春分这一天阳光直射<a href="#" class="tip1" id="tip1" rel="<div class='content'>赤道是地球表面的点随地球自转产生的轨迹中周长最长的圆周线，赤道半径 6378.140Km ；两极半径 6357.752Km。</div>">赤道</a>，昼夜几乎相等，其后阳光直射位置逐渐北移，开始<a href="#" class="tip1" rel="<div class='content'>这是一个成语</div>">昼长夜短</a>。</p>
			</div>
		</div>
	</div>
	<div id="ft">bbbbbb</div>
</div>
</body>
<script type="text/javascript" src="/combo?f=i/yui/3.0.0/build/yui/yui-min.js"></script>
<script type="text/javascript">
YUI({
	//Combo JS
	combine:true,
	base:'http://localhost/i/yui/3.0.0/build/', 
	root:"i/yui/3.0.0/build/",  
	comboBase:"/combo?f=", 
	charset:'utf-8',
	timeout:1000,
	loadOptional:true,
	filter: { 
	        'searchExp': "&i",  
	        'replaceStr': ",i" 
	    },
	modules:{
			'Postip':{
				fullpath:'postip.js?'+Math.random(),
				type:'js',
				requires:['node','anim']
			}
		}
	}).use('node','Postip','console',function(Y) {
		//开启控制台
		//new Y.Console().render();
		//var ft = Y.one('#ft');

		
		var radios = Y.one('.checkarea').queryAll('input');
		var radios1 = Y.one('#check2').queryAll('input');
		var radios2 = Y.one('#check3').queryAll('input');
		var len = radios.size(),pos_h,pos_v,_anim,lens=radios2.size();
		//
		
		var Demo = new Y.Postip('demo1',{pos:{h:'30',v:'-30'},content:'<div class="sb"><p>Tips<a href="#">Close</a></p></div>',anim:'fade',eventype:'click',eventout:'click'});

		
		//console.log(Y.Lang.isValue(Demo));
		Y.one('.state').queryAll('input').on('click',function(e){
			//
		
			for (var i=0;i<len;i++) {
				(function(n){
					if (radios.item(n)._node.checked){
						pos_h = radios.item(n).getAttribute('id');
						return pos_h;	
					}
				})(i);
			}
			
			for (var j=0;j<len;j++) {
				(function(n){
					if (radios1.item(n)._node.checked){
						pos_v = radios1.item(n).getAttribute('id');
						return pos_v;
					}
				})(j);
			}
			for (var k=0;k<lens;k++) {
				(function(n){
					if (radios2.item(n)._node.checked){
						_anim = radios2.item(n).getAttribute('id');
						return _anim;
					}
				})(k);
			}

			//Demo = Y.Postip('demo1',{pos:{h:pos_h,v:pos_v}})
			//debugger;
			//e.halt();
			Demo.render({pos:{h:pos_h,v:pos_v},anim:_anim});
			
		});
			
		Y.one('.sb a').on('click',function(e){e.halt();Demo.hide()});
		//传入参数
		

		var __as = Y.all('.tip1');
		 
		//例子开始////////////////////////////////////////////////////////////
		var tip1 = new Y.Postip(__as,{pos:{v:'otop',h:'10'},anim:'fade',eventype:'mouseover',eventout:'mouseover',classname:'tool-tip'});
		
		
			
		
		


		
		
	});
</script>

</html>