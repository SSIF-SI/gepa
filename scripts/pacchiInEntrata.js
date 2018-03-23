$(document).ready(function(){
	$("#privato").on("change",function(){
		var privato = $("#privato").val() == 1;
		if(privato){
			$("#mepaCode").attr("disabled","disabled");
			$("#mepaCode").val("");
		} else {
			$("#mepaCode").removeAttr("disabled");
			$("#mepaCode").focus();
		}
		
	});
	
	$("#destinatario").on("change",function(){
		var corriere = $("#corriere").val() != "";
		if(corriere)
			$("#scan").trigger("click");
	});

	$("#mepaCode").on("blur",function(){
		$("#codice").focus();
	});

	$("#scan").click(function(e){
		var istituzionale = $("#privato").val() == 0;
		var noMepaVal = $("#mepaCode").val() == "";
		if(istituzionale && noMepaVal){
			new BootstrapDialog()
		 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
            .setMessage('Specificare il codice mepa per pacchi istituzionali')
            .setType(BootstrapDialog.TYPE_DANGER)
            .open();
            return false;
		}

		if($("#destinatario").val()=="" || $("#corriere").val()==""){
			new BootstrapDialog()
		 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
            .setMessage('Destinatario e Corriere devono essere valorizzati')
            .setType(BootstrapDialog.TYPE_DANGER)
            .open();
            return false;
		}
		
		e.preventDefault();
		$("#codice").focus();
	});

	$("#codice").on("blur",function(e){
		$(".fa-spinner").removeClass("fa-spin");
	});

	$( document ).keydown(function(event) {
		if(event.keyCode == 13){
			event.preventDefault();
		}
	});

	
	$( "#codice" ).keydown(function(event) {
			if(event.keyCode == 13){
				event.preventDefault();
				var codice = $("#codice").val();
				var idCodice = codice.replace(/[^a-z0-9]/gi, '');
				if($("#"+idCodice).length == 0){

					var destinatario = $("#destinatario").val();
					var destinatarioText = $("#destinatario").find(":selected").text();

					var tipoPacco = $("#privato").val();
					var tipoPaccoText = $("#privato").find(":selected").text();

					var corriere = $("#corriere").val();
					var corriereText = $("#corriere").find(":selected").text();

					var mepa = $("#mepaCode").val();
					
					if(destinatario && corriere){
						if($("#"+destinatario).length == 0){
							$("#pacchi").append('<section class="col-sm-4 col-lg-2 col-xl-1"><div class="destinatario" id="'+destinatario+'"><h1>'+destinatarioText+'</h1><ul></ul></div></section>');
						}
						
						inputData = "<input type='hidden' name='codice["+destinatario+"][]' value=\""+codice.replace('"',"&quot;")+"\" />";
						inputData += "<input type='hidden' name='corriere["+destinatario+"][]' value='"+corriere+"'/>";
						inputData += "<input type='hidden' name='privato["+destinatario+"][]' value='"+tipoPacco+"'/>";
						inputData += "<input type='hidden' name='mepa["+destinatario+"][]' value=\""+mepa+"\" />";

						var codiceMepa = mepa=="" ? "" : "<br/><em>Mepa: </em><strong>"+mepa+"</strong>"; 
						var li = "<li id='"+idCodice+"'>"+inputData+"<div style='line-height:2em'><em>Codice: </em><strong>"+codice+"</strong><br/><em>Corriere:</em> <strong>"+corriereText+"</strong><br/><em>Tipo Pacco:</em> <strong>"+tipoPaccoText+"</strong>"+codiceMepa+"</div><div style='text-align:right'><div class='removeBtn'><button class='btn btn-danger' onClick='removePack(\""+idCodice+"\",\""+destinatario+"\");'>X</button></div></div></li>";
						
						$("#"+destinatario+" ul").append(li);
						countPacks();
					} else{
						 new BootstrapDialog()
						 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
				            .setMessage('Destinatario e corriere devono essere valorizzati')
				            .setType(BootstrapDialog.TYPE_DANGER)
				            .open();
						
					}
				}
				$("#codice").val("");
			}

	});

	$("#codice").on("blur",function(){$("#codice").val("")});

	$("#codice").on("focus",function(){
		$("#codice").val("");
		$(".fa-spinner").addClass("fa-spin");
	});
	
	$("#save").click(function(e){
		e.preventDefault();
		if($("#pacchi section").length == 0){
			 new BootstrapDialog()
			 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
	            .setMessage('Nessun pacco sparato')
	            .setType(BootstrapDialog.TYPE_DANGER)
	            .open();
			return;
			
		} 
		$(this).attr("disabled","disabled");
/*
		$("#pacchiForm").submit();
	});

	$("#pacchiForm").submit(function(e) {
*/		
		var url = "?action=save"; // the script where you handle the form input.

	    $.ajax({
	           type: "POST",
	           url: url,
	           data: $("#pacchiForm").serialize(), // serializes the form's elements.
			   dataType: "json",
	           success: function(data)
	           {
	               if(!data.errors){
	            	   new BootstrapDialog()
					 	.setTitle('<i class="fa fa-info"> </i>')
			            .setMessage("Dati salvati con successo")
			            .setType(BootstrapDialog.TYPE_SUCCESS)
			            .open();					
	                   $("#pacchi").html("");
	                   		$("#save").removeAttr("disabled");

		           } else {
		        	   new BootstrapDialog()
					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Errore durante il salvataggio')
			            .setMessage(data.errors)
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .open();					
	               }
	           }
	         });

	    e.preventDefault(); // avoid to execute the actual submit of the form.
	});
});


function removePack(codice,destinatario){
	$("#"+codice).remove();
	if($("#"+destinatario+" ul li").length == 0){
		$("#"+destinatario).parent().remove();
		
	}
	countPacks();
	$("#codice").focus();
}

function countPacks(){
	var pacchiTotali = $("#pacchi ul li").length;
	$("#nPacchi").html(pacchiTotali);
}