$(document).ready(function(){
	var Const = {
		waitingForBadge: false	
	};

	$(".destinatario h1").click(function(e){
		if(Const.waitingForBadge) return;
		var id = $(this).parent().attr("id");
		
		$("#"+id+" ul li").each(function(i){
			$(this).addClass("selected");
		});
		refreshCountPacchi();
	})
	
	$("section ul li").click(function(e){
		if(Const.waitingForBadge) return;
		
		$(this).toggleClass("selected");
		refreshCountPacchi();
	});

	$("#dispatch").click(function(e){
		if(Const.waitingForBadge) return;
		var pacchiDaConsegnare = $("li.selected");
		if(pacchiDaConsegnare.length == 0){
			alert("Nessun pacco selezionato");
			return;
		}
		Const.waitingForBadge = true;

		$('#dispatch, #remove').hide();
		
		$("#action").html("Passare il badge... <i class='fa fa-sync fa-spin'></i> &nbsp;<button class='cancel btn btn-danger'><i class='fa fa-times'> </i> Annulla</button>");
		refreshButtons();
		$("#codice").focus();
	});

	$("#remove").click(function(e){
		var pacchiDaEliminare = $("li.selected");
		if(pacchiDaEliminare.length == 0){
			alert("Nessun pacco selezionato");
			return;
		}
		if(confirm("Sei sicuro?")){
			var ids = [];
			$(".selected input").each(function(i){
				ids.push($(this).val());
			})
			$.ajax({
		           type: "POST",
		           url: "?action=delete",
		           data: {ids: ids}, // serializes the form's elements.
				   dataType: "json",
		           success: function(data)
		           {
		        	   if(!data.errors){
		        		   new BootstrapDialog()
						 	.setTitle('<i class="fa fa-info"> </i> Informazione')
				            .setMessage("Operazione andata a buon fine")
				            .setType(BootstrapDialog.TYPE_SUCCESS)
				            .onHide(function(dialogRef){
				            	$("#pacchiInUscita").click();
	            			})
	            			.open();	
		               } else {
		            	   new BootstrapDialog()
						 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Errore durante il salvataggio')
				            .setMessage(data.errors)
				            .setType(BootstrapDialog.TYPE_DANGER)
				            .open();
		               }
		           },		          
		           error: function(){ 
		        	   new BootstrapDialog()
					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
			            .setMessage("Errore di connessione")
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .open();
			       }
		         });
	        
		}
	});

	function refreshCountPacchi(){
		var pacchiDaConsegnare = $("li.selected").length;
		$("#countPacchi").html(pacchiDaConsegnare);
		pacchiDaConsegnare > 0 ? $("#buttonActions").show() : $("#buttonActions").hide();
		$("#codice").focus();
	}	

	function refreshButtons(){

		$(".cancel,.confirm").unbind();
		
		$(".cancel").click(function(e){
			$('#dispatch, #remove').show();
			$("#action").html("");
			Const.waitingForBadge = false;
			$("#codice").focus();
		});

		$(".confirm").click(function(e){
			var ids = [];
			$(".selected input").each(function(i){
				ids.push($(this).val());
			})
			$.ajax({
		           type: "POST",
		           url: "?action=dispatch",
		           data: {ricevente: $("#ricevente").val(), ids: ids}, // serializes the form's elements.
				   dataType: "json",
		           success: function(data)
		           {
		        	   if(!data.errors){
		        		   new BootstrapDialog()
						 	.setTitle('<i class="fa fa-info"> </i> Informazione')
				            .setMessage("Dati salvati con successo")
				            .setType(BootstrapDialog.TYPE_SUCCESS)
				            .onHide(function(dialogRef){
				            	$("#pacchiInUscita").click();
	            			})
	            			.open();	
		               } else {
		            	   new BootstrapDialog()
						 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Errore durante il salvataggio')
				            .setMessage(data.errors)
				            .setType(BootstrapDialog.TYPE_DANGER)
				            .open();
		               }
		           },		          
		           error: function(){ 
		        	   new BootstrapDialog()
					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
			            .setMessage("Errore di connessione")
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .open();
			       }
		         });
	        
		})
	}
	
	$( document ).keydown(function(e) {
		var c = e.which || e.keyCode;//Get key code
	    switch (c) {
		   case 74://Block Ctrl+J
			   e.preventDefault();     
	           e.stopPropagation();
	           $("#codice").val("").focus();
		       break;
	    }
	});
	
	$("#codice").keydown(function(e){
		var c = e.which || e.keyCode;//Get key code
	    switch (c) {
		   case 74://Block Ctrl+J
			   e.preventDefault();     
	           e.stopPropagation();
	           $(this).val("");
		       return;
		       break;
	       case 13:

		    e.preventDefault();
			
			if(Const.waitingForBadge){
				var badge = $(this).val().substring(4,10);
				if(badge.length != 6) return;

				$.ajax({
			           type: "POST",
			           url: "?action=getUser",
			           data: {numBadge: badge}, // serializes the form's elements.
					   dataType: "json",
			           success: function(data)
			           {
				            $('#dispatch, #remove').hide();

							if(!data){
								 new BootstrapDialog()
								 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
						            .setMessage("Utente non riconosciuto.")
						            .setType(BootstrapDialog.TYPE_DANGER)
						            .open();
						         return;
							}

							$("#action").html("Consegna a <strong><em>"+data.nome+" "+data.cognome+"</em></strong>&nbsp;&nbsp;<button class='confirm btn btn-success'><i class='fa fa-check'> </i> Ok</button> <button class='cancel btn btn-danger'><i class='fa fa-times'> </i> Annulla</button><input type='hidden' id='ricevente' value='"+data.idPersona+"'/>");
							$("#numBadge").blur();
							refreshButtons();
			           },
			           error: function(){ 
			        	   new BootstrapDialog()
						 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> "Attenzione')
				            .setMessage("Errore di connessione")
				            .setType(BootstrapDialog.TYPE_DANGER)
				            .open();
				       }
			         });
				
			} else {
				var codice = $(this).val();
				var idCodice = codice.replace(/[^a-z0-9]/gi, '');
				console.log(idCodice);
				$("li#"+idCodice).addClass("selected");
				refreshCountPacchi();
			}

			$(this).val("");
			
		}
	});

	$("li").removeClass("selected");

	$("#codice").focus();
});