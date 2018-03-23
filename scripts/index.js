$(document).ready(function(){
	var Timer = {
			MAX_TIME_LEFT: 300,
			timeout: null,	
			timeLeft: this.MAX_TIME_LEFT,
			reset: function(){
				Timer.timeLeft = Timer.MAX_TIME_LEFT;
			},
			clear: function(){
				clearTimeout(Timer.timeout);
			},
			run: function (){
				Timer.timeLeft--;
				/*$("#timer").html(Timer.timeLeft);*/
				if(Timer.timeLeft <= 0){
					clearTimeout(Timer.timeout);
					location.href = "?logout";
					return;
				}
				
				Timer.timeout = setTimeout(function(){Timer.run()}, 1000);
			}
		};
		
	$(document).mousemove(function(e){
		Timer.reset();
	});
	
	$("nav a").click(function(e){
		e.preventDefault();
		var href=$(this).attr("href").replace("#","");
		$(".circleBase").removeClass("active");
		$("."+href).addClass("active");
		
		href += ".php";
		//$("#main").html("<h2>Attendere...</h2>");
		$("#main").load(BUSINESS_HTTP_PATH+href);
		Timer.clear();
		Timer.reset();
		Timer.run();
	});

	if($("#s_operatore").html().trim() != "")
		$("#pacchiInEntrata").click();
});