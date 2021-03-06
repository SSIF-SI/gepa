<style>
#numBadge{
	display:block;
	position:absolute;
	left:-99999px;
	top:-999px;
}

#bspinner{
	visibility:hidden;
}
</style>

<h1>Seleziona Operatore</h1>
<div id="cardreader"></div>
<div id="result" class="text-center" style="font-size:3em">Passare il badge... <i id='bspinner' class='fa fa-sync fa-spin'></i></div>
<input type="text" id="numBadge" autocomplete="off" />

<script>
$(document).ready(function(){
	$("#numBadge").focus();

	var buttonClicked = $(".active").first().parent().parent().parent().parent().attr("id");
	if(buttonClicked == undefined) 
		buttonClicked = $("nav a").first().attr("id");

	$("#numBadge").keydown(function(e){
		
		if(e.keyCode == 13){
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
		            if(data.nome == undefined || data.cognome == undefined || data.idPersona == undefined){
		            	new BootstrapDialog()
					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> "Attenzione')
			            .setMessage("Utente non riconosciuto")
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .onHide(function(){
				    		$("#numBadge").focus();
				        })
				        .open();
			        } else {
			            $("#result").html("<em>"+data.nome+" "+data.cognome+"</em></strong>&nbsp;&nbsp;<button class='confirm btn btn-success'><i class='fa fa-check'> </i> Ok</button> <button class='cancel btn btn-danger'><i class='fa fa-times'> </i> Annulla</button><input type='hidden' id='operatore' value='"+data.idPersona+"'/>");
						$("#numBadge").blur();
						refreshButtons();
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
		       }
	         });
		
	
			$(this).val("");
			
		}
	});

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
</script>
