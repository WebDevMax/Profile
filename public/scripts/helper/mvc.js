;var MVC = MVC || {};
/************Namespace Constr************/
MVC.NS = function(ns_string){
	var parts = ns_string.split('.'),parent = MVC, i;
	if(parts[0] === "MVC")
	{
		parts = parts.slice(1);
	}
	
	for(i = 0; i < parts.length;i+=1)
	{
		if(typeof parent[parts[i]] === "undefined"){
			parent[parts[i]] = {};
		}
		parent = parent[parts[i]]
	}
	
	return parent;
};
/************Init View/Utilities************/
MVC.NS('View');
MVC.NS('GET');
MVC.NS('utilities.Array');
MVC.NS('utilities.Util');
/************Array Constr************/
MVC.utilities.Array = (function(app,global){
	var astr = "[object Array]", Sastr = "[object Array 2]", Constr;
	
	Constr = function(){
		return this;
	};
	
	Constr.prototype = {
		constructor: MVC.utilities.Array,
		version : '1.0',
		inArray: function(needle,haystack){
			var i = 0,
			max = haystack.length;
			for(;i < max; i += 1)
			{
				if(haystack[i] === needle)
				{
					return i;
				}
			}
			return -1;
		},
		isArray : function(a){
			return toString.call(a) === astr;
		},
		toArray: function(obj){
			for(var i = 0, a = [], len = obj.length; i < len; i+=1){
				a[i] = obj[i];
			}
			return a;
		},
		retastr : function()
		{
			return astr;
		},
		retSastr : function()
		{
			return Sastr;
		}
	};
	
	return Constr;
}(MVC,this));
/************Util Constr************/
MVC.utilities.Util = (function(app,global){
	
	Constr = function(){
		return this;
	};
	
	Constr.prototype = {
		constructor: MVC.utilities.Util,
		version : '1.0',
		init: function(){
			//JS initialization goes here
		},
	};
	
	return Constr;
}(MVC,this));
/************GET Constr************/
MVC.GET = (function(app,global){
	var Constr;
	
	Constr = function(){
		//constructor
	};
	
	Constr.prototype = {
		
	};
	
	return {
		getEdit : function(i){
			//test purposes
			//$('[name="edit"]').on('click',function(e){
				//e.preventDefault();
			//});
		}
	}
}(MVC,this));

$(document).ready(function(){
	/***** FB ******/
	window.fbAsyncInit = function() {
    FB.init({
      appId      : 'my-app-id',
      xfbml      : true,
      version    : 'v2.6'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   /***** FB ******/
	var Util = new MVC.utilities.Util();
	Util.init();
});