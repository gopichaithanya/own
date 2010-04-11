YUI.namespace('Y.Postip');
YUI.add('Postip',function(Y){
	Postip = function(){
		this.init.apply(this,arguments);
	};
	Y.mix(Postip,{
		init:function(id,config){
			var that = this;
			that.id = id;
			that.config = config;
			that.con = (typeof that.id == 'object') ? that.id : Y.one('#'+that.id);
			//that.con = Y.one('#'+that.id);
			that.isShow = false;
			//渲染弹出框
			that.render();
			//构造弹出框
			that.buildTip();
			//绑定事件
			that.bindEvent();
			return this;
		},
		buildTip:function(){
			var that = this;
			//设置弹出框
			if(that.oTip)return;
			var tip = Y.Node.create('<div class="'+that.oTipclass+'" style="visibility:hidden;position:absolute;z-index:1000;top:0">'+that.content+'</div>');
			Y.one('body').appendChild(tip);
			that.oTip = tip;
			if(typeof that.oTip == 'object')that.oTip = that.oTip;
			return this;
		},
		buildParam:function(o){
			var that = this;
			//基本参数
			var o = (typeof o == 'undefined' || o == null)?{}:o;

			//鼠标事件类型
			that.eventype = (typeof o.eventype=='undifined' || o.eventype==null)?'mouseover':o.eventype;
			//设置Tip对齐方式
			that.pos = (typeof o.pos == 'undefined' || o.pos == null)?{}:o;
			if(o.pos){
				//如果为数值时即为自定义位置
				that.pos.hAlign = (typeof o.pos.h=='undifined' || o.pos.h==null)?'left':o.pos.h;
				that.pos.vAlign = (typeof o.pos.v=='undifined' || o.pos.v==null)?'bottom':o.pos.v;
			}
			that.oTipclass = (typeof o.classname=='undifined' || o.classname==null)?'postip':o.classname;

			//动画参数
			/*
			that.delayTime = (typeof o.delay=='undifined' || o.delay==null)?'350':o.delay;
			that.animType = (typeof o.anim=='undifined' || o.anim==null)?'no':o.anim;
			that.animSpeed = (typeof o.speed=='undifined' || o.speed==null)?'0.2':o.speed;
			*/
			that.content = o.content;
			return this;
		},
		//渲染HTML生成或找到弹出框
		render:function(o){
			var that = this;
			that.parseParam(o);
			//如果是点击事件鼠标变成手势
			if(that.eventype == 'click'){
				that.con.setStyle('cursor','pointer');
			}
			return this;
			
		},
		/**
		* 过滤参数列表
		*/
		parseParam:function(o){
			var that = this;
			if(typeof o == 'undefined' || o == null){
				var o = {};
			}
			for(var i in o){
				that.config[i] = o[i];
			}
			that.buildParam(that.config);
			return this;
		}, 
		//注册事件
		bindEvent:function(){
			var that = this;
			that.con.on(that.eventype,function(e){
				var el = e.target;
				that.posTip(el);
				if(typeof that.content == 'undefined' || that.content  == null){
					if(el.get('rel')){
						that.oTip.set('innerHTML',el.get('rel'));
					}
				}
				that.isShow = true;
				if(that.isShow == true)that.show();
			});
			that.con.on('mouseout',function(e){
				e.halt();
				that.isShow = false;
				setTimeout(function(){
					if(that.isShow == false)that.hide();
				},300)
			});
			that.oTip.on('mouseover',function(e){
				e.halt();
				that.isShow = true;
				that.show();
			});
			that.oTip.on('mouseout',function(e){
				e.halt();
				that.isShow = false;
				setTimeout(function(){
					if(that.isShow == false)that.hide();
				},200)
			});

			return this;
			
		},
		//定位Tip
		posTip:function(o){
			var	that = this
			var _left,_top;	  
			_left = that.getLeft(that.pos.hAlign,o,that.oTip);
			_top = that.getTop(that.pos.vAlign,o,that.oTip);						
			that.oTip.setStyles({
				'left':_left+'px',
				'top':_top+'px'
			});	
			return this;
		},
		//得到弹出框相对左边距
		getLeft:function(a,o,e){
			var that = this,
				cget = o.get('region'),
				eget = e.get('region');
			//如果为数值
			if(!isNaN(parseInt(Number(a)))){
				return cget[0] + Number(a);
			}else{
				switch(a){
					case 'oleft': 
						return cget[0] - eget.width;
					case 'oright':
						return cget[0] + cget.width;
					case 'center':
						return cget[0] + (cget.width - eget.width)/2;
					case 'right':
						return cget[0] + cget.width - eget.width;
					default:
						return cget[0];				
				}
			};
			return this;
		},
		//得到弹出框相对顶边距
		getTop:function(a,o,e){
			var that = this,
				cget = o.get('region'),
				eget = e.get('region');
			if(!isNaN(parseInt(Number(a)))){
				return cget[1] + Number(a);
			}else{
				switch(a){
					case 'otop': 
						return cget[1] - eget.height;
					case 'obottom':
						return cget[1] + cget.height;
					case 'middle':
						return cget[1] + (cget.height - eget.height)/2;
					case 'bottom':
						return cget[1] + cget.height - eget.height;
					default:
						return cget[1];				
				}
			}
			return this;
		},
		//控制弹出框显示
		show:function(){
			var that = this;
			if(that.oTip.getStyle('visibility') == 'visible')return;
			/*
			if(that.animType == 'no'){
				//显示
				that.oTip.setStyle('visibility','visible');			
			}else if(that.animType == 'fade'){
				that.oTip.setStyles({
					'opacity':'0',
					'visibility':'visible'
				});
				var anim1 = new Y.Anim({
					node:that.oTip,
					to:{
						opacity:1
					},
					duration:that.animSpeed
				});
				anim1.run();
			}else if(that.animType == 'expand'){
				//debugger;
				var _width = that.oTip._node.clientWidth,
					_height = that.oTip._node.clientHeight;
				that.oTip.setStyles({
					'width':'0',
					'height':'0',
					'overflow':'hidden',
					'visibility':'visible'
				});
				var animExpand = new Y.Anim({
					node:that.oTip,
					to:{
						width:_width,
						height:_height
					},
					duration:that.animSpeed
				});
				animExpand.run();
			}*/
			that.oTip.setStyle('visibility','visible');
			return this;
		
		},
		//控制弹出框隐藏
		hide:function(){
			var that = this;
			if(that.oTip.getStyle('visibility') == 'visible'){
				/*
				if (that.animType == 'no'){
					that.oTip.setStyle('visibility','hidden');	
				}else {
					var anim2 = new Y.Anim({
						node:that.oTip,
						to:{
							opacity:0
						},
						duration:that.animSpeed
					});
					anim2.on('end',function(){
						that.oTip.setStyles({
							'visibility':'hidden',
							'opacity':'1'
						});		
					});
					anim2.run();
				} */
				that.oTip.setStyle('visibility','hidden');	
				
			};
			return this;
			
		}
		
	},0,null,4);

	Y.Postip = Postip;
	
},'',{requires:['node','anim']});
