$("#numBadge").focus();

$(document).ready(function(){
	$(document).click(function(e){
		$("#numBadge").focus();
	});
	
	var buttonClicked = $(".active").first().parent().parent().parent().parent().attr("id");
	if(buttonClicked == undefined) 
		buttonClicked = $("nav a").first().attr("id");

	$("#numBadge").keydown(function(e){
		var c = e.which || e.keyCode;//Get key code
	    switch (c) {
		   case 74://Block Ctrl+J
		      	$(this).val("");
		        e.preventDefault();     
	            e.stopPropagation();
	            return;
	        	break;
	       case 13:
			e.preventDefault();
			
			var badge = $(this).val().substring(4,10);
			if(badge.length != 6) return;

			$("#bspinner").css('visibility', 'visible');
			$.ajax({
		       type: "POST",
	           url: "?action=getUser",
	           data: {numBadge: badge}, // serializes the form's elements.
			   dataType: "json",
	           success: function(data)
	           {
	           		if(data.pruut != undefined){
	           			pruut();
	           			return;
	           		}
		            if(data.nome == undefined || data.cognome == undefined || data.idPersona == undefined){
		            	new BootstrapDialog()
					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> "Attenzione')
			            .setMessage("Utente non riconosciuto")
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .onHide(function(){
				    		$("#numBadge").focus();
				        })
				        .open();
				        $("#bspinner").css('visibility', 'hidden');
			        } else {
			        	var operatore = data.idPersona;
			        	$.ajax({
					           type: "POST",
					           url: "?action=setUser",
					           data: {operatore: operatore}, // serializes the form's elements.
							   dataType: "json",
					           success: function(data)
					           {
					        	   if(!data.errors){
					        		   $("#s_operatore").html("Operatore: <strong><em>"+data.otherData.user+"</em></strong> <a href='?logout' class='btn btn-danger'>Log Out</a>");
						                  $("#"+buttonClicked).click();
						        	} else {
					            	   new BootstrapDialog()
									 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
							            .setMessage("Errore di connessione")
							            .setType(BootstrapDialog.TYPE_DANGER)
							            .onHide(function(){
							    			$("#numBadge").focus();
							            
							            })
							            .open();
						                $("#bspinner").css('visibility', 'hidden');
			                      }
					           },		          
					           error: function(){ 
					        	   new BootstrapDialog()
								 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
						            .setMessage("Errore di connessione")
						            .setType(BootstrapDialog.TYPE_DANGER)
						            .onHide(function(){
							    			$("#numBadge").focus();
							        })
							        .open();
							        $("#bspinner").css('visibility', 'hidden');
			                      
						       }
					         });
		            }
	           },
	           error: function(){ 
	        	   new BootstrapDialog()
				 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> "Attenzione')
		            .setMessage("Errore di connessione")
		            .setType(BootstrapDialog.TYPE_DANGER)
		            .onHide(function(){
				    			$("#numBadge").focus();
		            })
		            .open();
		            $("#bspinner").css('visibility', 'hidden');
			                      
		       }
	         });
		
	
			$(this).val("");
			
		}
		
	});

	function pruut(){
		$("#bspinner").css('visibility', 'hidden');
		$("#laugh").fadeIn();
		setTimeout(function(){$("#laugh").hide();},3000);
	}
	function refreshButtons(){

		$(".cancel,.confirm").unbind();
		
		$(".cancel").click(function(e){
			$("#result").html("Passare il badge... <i id='bspinner' class='fa fa-sync fa-spin'></i>");
			$("#bspinner").css('visibility', 'hidden');
			$("#numBadge").focus();
		});

		$(".confirm").click(function(e){
			var operatore = $("#operatore").val();
			$.ajax({
		           type: "POST",
		           url: "?action=setUser",
		           data: {operatore: operatore}, // serializes the form's elements.
				   dataType: "json",
		           success: function(data)
		           {
		        	   if(!data.errors){
		        		   $("#s_operatore").html("Operatore: <strong><em>"+$("#result em").first().html()+"</em></strong> <a href='?logout' class='btn btn-danger'>Log Out</a>");
			                  $("#"+buttonClicked).click();
			        	} else {
		            	   new BootstrapDialog()
						 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
				            .setMessage("Errore di connessione")
				            .setType(BootstrapDialog.TYPE_DANGER)
				            .onHide(function(){
				    			$("#numBadge").focus();
				            
				            })
				            .open();
		               }
		           },		          
		           error: function(){ 
		        	   new BootstrapDialog()
					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
			            .setMessage("Errore di connessione")
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .onHide(function(){
				    			$("#numBadge").focus();
				        })
				        .open();
			       }
		         });
	        
		})
	}
	
});
