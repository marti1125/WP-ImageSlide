jQuery(document).ready(function($) {
	buttonsClass("div.social_button");
	buttonsClass("div.accordion_button");

	$(".accordion").accordion(	{width:863, 	
							 height:410, 
							 barSize:40,  	
							 cover:false,
							 coverAlpha:0.5,	
							 shadow:false,
							 shadowAlpha:1,		
							 border:true,		
							 borderSize:1	,		
							 borderColor:"#242424",	
							 transitionTime:0.3	,		
							 autoplay:true	,	
							 autoplayTime:5	,
							 changeType:"click",
							 previousBtn:$("#border div.previous"), 
							 nextBtn:$("#border div.next") }
							); 
});
