$(function() {
    placeProjects();
});

var currentTop=0;
var randomMovementMax=15;
var vhInPx = document.documentElement.clientHeight * 0.01;

function placeProjects(){
	$("body").find(".project").each(function(index){
		if(index==0){
			$(this).css("top",currentTop);
			$(this).css("left","calc( 50vw - "+ $(this).first("img").width()/2+"px )");

		}else{
			index++;
			if(index%2==0){
				if((index/2)%2==1){
					randomMovement = Math.round(randomMovementMax * Math.random());
					$(this).css("top",currentTop);
					$(this).css("left",(65 + randomMovement)+"vw");
				}else{
					randomMovement = Math.round(randomMovementMax * Math.random());
					$(this).css("top",currentTop);
					$(this).css("left",(0 + randomMovement)+"vw");
				}
				
			}else{
				var sign=Math.random()>0.5?1:-1;
				randomMovement = Math.round(randomMovementMax * Math.random());
				$(this).css("top",currentTop);
				$(this).css("left",(40 + sign*randomMovement)+"vw");
			}
		}
		currentTop += $(this).first("img").height();
		currentTop += (20*vhInPx)+Math.round((10*vhInPx) * Math.random());
		return;
	});
}