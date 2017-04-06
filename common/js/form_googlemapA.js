form_googlemap  = Class.create();
form_googlemap.prototype = {

	initialize: function(address,x,y){
		this.address=address;
		this.map = null;
		this.geocoder = null;
		this.marker = null;

		this.fadein_default = 30;
		this.interval;
		this.ajax_check = false;
		this.popup=true;


		//ドラッグ可能
//		this.gmarkeroptions = new Object();
//		this.gmarkeroptions.draggable = true;


		this.icon 				= new GIcon();
		this.icon.image		="assets/drug_pointer1.png";
		this.icon.shadow		="assets/drug_pointer1r.png";
		this.icon.iconSize 	= new GSize(79,63);
		this.icon.shadowSize = new GSize(113,63);
		this.icon.iconAnchor = new GPoint(39,63);


		if(x && y){
			this.y = y; //縦
			this.x = x; //横
			this.saved_flg = true;
		}else{
			//default=新宿
			this.y = 35.690067; //縦
			this.x = 139.700518; //横
			this.saved_flg = false;
		}

		this.zoomlevel = 18;

		Event.observe(window, "load", this.setListener, false);
	},

	setListener: function(){
		if($('btn_save')){
			Event.observe("btn_save", "click", form_googlemap.save_click, false);
		}
		if($('btn_del')){
			Event.observe("btn_del", "click", form_googlemap.del_click, false);
		}
		if($('btn_cancel')){
			Event.observe("btn_cancel", "click", form_googlemap.cancel_click, false);
		}

		var TFs = $A(document.getElementsByClassName('text'));
		TFs.each(function (node){
			node.TFclass = node.className;
			node.TFclass_onfocus = 'text_focus';
			node.onfocus = function() { this.className = this.TFclass_onfocus; };
			node.onblur  = function() { this.className = this.TFclass; };
		});


		//google map
		form_googlemap.draw_map();

	},

	fadein: function(e){
		Element.setOpacity(Overlay.getInstance().getElement(), 0.2);
		Overlay.setZIndex(1);
		Overlay.appear();

		//google map
		point = form_googlemap.marker.getPoint();
		$('ACTIVITY_BASIC_LAT').value = point.lat();
		$('ACTIVITY_BASIC_LNG').value = point.lng();

		//
		var x=0,y=0;

		if (window.opera) {
			x = e.clientX + window.pageXOffset;
			y = e.clientY + window.pageYOffset;
		} else if (document.all) {
			x = e.clientX + document.body.scrollLeft;
			y = e.clientY + document.body.scrollTop;
		} else if (document.layers || document.getElementById) {
			x = e.pageX;
			y = e.pageY;
		}

//		var div = document.createElement('div');
//		document.body.appendChild(div);
//		div.id = 'saving';
//		div.style.left = 150+'px';
//		div.style.top  = y-200+'px';
//		div.style.zIndex = 2;
//		div.innerHTML = '<img src="http://common.enjoy-japan.cn.localhost/assets/now_saving.gif" />';

		Element.setOpacity(Overlay.getInstance().getElement(), 0.1);
		Overlay.setZIndex(1);
		Overlay.appear();

		this.interval = setInterval(this.timer.bind(this),100);
	},

	timer: function(){
		this.fadein_default = this.fadein_default+10;
		if(this.fadein_default>=100){
			clearInterval(this.interval);
			if(!this.ajax_check) {
			document.form1.submit();
			}
//			if(!this.ajax_check)		$('form1').submit();
		}
	},

	draw_map: function(){
		if (GBrowserIsCompatible()) {
			this.map = new GMap2($("map"));
			this.map.addControl(new GLargeMapControl());

			if(this.saved_flg){
				this.default_point();
			}else if(this.address){
				this.geocoder = new GClientGeocoder();

				if (this.geocoder) {
					this.geocoder.getLatLng( this.address, this.return_address_point );
				}

			}else{
				this.default_point();
			}

		}
	},

	default_point: function(){
		point = new GLatLng(this.y, this.x);

		this.map.setCenter(point, this.zoomlevel);
		this.marker_set(point);
	},

	return_address_point: function(point){
		if (!point) {
			form_googlemap.default_point();
		} else {
			form_googlemap.map.setCenter(point, form_googlemap.zoomlevel);
			form_googlemap.marker_set(point);
		}
	},

	marker_set: function(point){
		this.marker = new GMarker(point,{draggable:true,icon:this.icon});
		this.map.addOverlay(this.marker);
	},

	save_click: function(e){
		check(e);
	},

	cancel_click: function(){

		if(form_googlemap.popup){
			if(BrowserCheck()){
				window.returnValue=false;
			}
			window.close();
		}else{
			history.back();
		}
	},

	del_click: function(e){
		if(warningDialogOpen("削除してよろしいですか？")==false){
			return;
		}

		$('del_flg').value = "1";
		form_googlemap.fadein(e);
	},

	test: function(){
		point = this.marker.getPoint();
		alert(point.lat());
		alert(point.lng());
	}

}