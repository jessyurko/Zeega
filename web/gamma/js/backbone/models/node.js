var Node = Backbone.Model.extend({
	
	defaults : {
		"name" : "Untitled",
		"attr" : {
			"advance": 0,
			"editorHidden":false
		}
	},
	
	/*
	url : function(){
		if(this.isNew())return Zeega.url_prefix+"routes/"+Zeega.routeID+"/nodes";
		else return Zeega.url_prefix+"routes/"+Zeega.routeID+"/nodes"+ this.id;
	},
	*/
	
	initialize : function() {
		
		if(!this.get('attr')) this.set({'attr':{'advance':0,'editorHidden':false}})
	},
	
	//update the node thumbnail
	updateThumb : function()
	{
		console.log('updating thumbnail');
		
		//kill any preexisting thumb updates
		if(this.t) clearTimeout(this.t);
		
		$('.node-thumb-'+this.id).find('.node-overlay').spin('tiny','white');
		this.set({thumb_url:0});
		
		var that=this;

		this.save({},{
		
			success: function(node,response){
				$('.node-thumb-'+that.id).find('.node-background').fadeOut('fast',function(){
				$('.node-thumb-'+that.id).css('background-image','url("'+response[0].thumb_url+'")').fadeIn('slow');
				that.set({thumb_url:response[0].thumb_url});
				//turn off spinner
				$('.node-thumb-'+that.id).find('.node-overlay').spin(false);
			});
			
			}});
		//THIS SHOULD BE CALLED ON SUCESSS 
		
		
	
	
	},
	
	noteChange:function()
	{
		console.log('changed');
		var _this = this;
		//kill any preexisting thumb updates
		if(_this.t) clearTimeout(this.t);
		_this.t = setTimeout(function(){ _this.updateThumb()}, 5000)
		
		_this.changed=true;
	},
	clearChange:function()
	{
		console.log('change cleared');
		this.changed=false;
	}

});

var NodeCollection = Backbone.Collection.extend({
	model: Node,
	url : function()
	{
		return Zeega.url_prefix+"routes/"+ Zeega.route.id +"/nodes";
	},
	
	initialize : function()
	{
		
	}
});