<DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Test</title>
<style>
#codice{
	display:block;
	position:absolute;
	left:-99999px;
	top:-999px;
}
a{
	outline:0;
}

input::-moz-focus-inner { 
  border: 0; 
}

label{
}

select, label,input{
	font-size:1.2em;
}

select, input{
	border:1px solid #000;
	background-color:#fff;
	border-radius: 6px;
	padding:0.2em;
	margin-right:1em;
	font-weight:normal;
}

#pacchi{
	box-sizing: border-box;
	margin-top:0.3em;
}
#pacchi ul,
#pacchi ul li
{
	box-sizing: border-box;
	list-style:none;
	list-style-type:none;
	margin:0.4em 0.3em;
	padding:0.3em;
}

#pacchi ul li{
	box-sizing: border-box;
	border:2px solid #d92;
	border-radius: 3px;
	background-color: #fc7;
	padding-top:1em;
	position:relative;
}

#pacchi strong{
	background-color:white;
	padding:0.3em;
}

.destinatario{
	box-sizing: border-box;
	border:5px solid #007998;
	border-radius: 20px 0 20px 0;
	padding:0;
	margin-bottom:0.6em;
}

.destinatario h1{
	box-sizing: border-box;
	color: white;
	margin:0;
	padding-top :0 !important;
	text-align:center;
	background-color: #00a1cb;
	text-shadow: 0 1px 0 #ccc, 
               0 2px 2px #000;
    border-radius: 14px 0 0 0;
	font-size:1.5em;

}

.removeBtn{
	position:absolute;
	top:0;
	right:0.2em;
}

.removeBtn button{
	padding:0 !important;
}

section{box-sizing: border-box;}
</style>
</head>
<body>
<h1>Pacchi in entrata</h1>

<form id="pacchiForm" method="POST">
	<label for="privato">Tipo Pacco:</label>
	<select id="privato">
		<option value="1">Privato</option>
		<option value="0">Istituzionale</option>
	</select>

	<label for="destinatario">Destinatario:</label>
	<select id="destinatario">
		<option value="">--Segli--</option>
		<?php foreach($listOfPersone as $id=>$data) :?>
		<option value="<?=$id?>"><?=$data['cognome']." ".$data['nome'];?></option>
		<?php endforeach;?>
	</select>

	<label for="corriere">Corriere:</label>
	<select id="corriere">
		<option value="">--Segli--</option>
		<?php foreach($corrieri as $id=>$corriere) :?>
		<option value="<?=$id?>"><?=$corriere?></option>
		<?php endforeach;?>
	</select>

	<input type="text" id="codice" value="" />
	<button id="save" class="btn btn-primary"><i class="fa fa-save"> </i> Salva</button>
<div id="pacchi" class="row fix">
</div>
</form>
<script>
$(document).ready(function(){
	$("#codice").focus();
	$("#codice").val("");
	$( document ).keydown(function(event) {
			$("#codice").focus();
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

					if(destinatario && corriere){
						if($("#"+destinatario).length == 0){
							$("#pacchi").append('<section class="col-sm-4 col-lg-2 col-xl-1"><div class="destinatario" id="'+destinatario+'"><h1>'+destinatarioText+'</h1><ul></ul></div></section>');
						}
						
						inputData = "<input type='hidden' name='codiceEsterno["+destinatario+"][]' value=\""+codice.replace('"',"&quot;")+"\" />";
						inputData += "<input type='hidden' name='corriere["+destinatario+"][]' value='"+corriere+"'/>";
						inputData += "<input type='hidden' name='privato["+destinatario+"][]' value='"+tipoPacco+"'/>";
						
						var li = "<li id='"+idCodice+"'>"+inputData+"<div style='line-height:2em'><em>Codice: </em><strong>"+codice+"</strong><br/><em>Corriere:</em> <strong>"+corriereText+"</strong><br/><em>Tipo Pacco:</em> <strong>"+tipoPaccoText+"</strong></div><div style='text-align:right'><div class='removeBtn'><button class='btn btn-danger' onClick='removePack(\""+idCodice+"\",\""+destinatario+"\");'>X</button></div></div></li>";
						
						$("#"+destinatario+" ul").append(li);
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

		$("#pacchiForm").submit();
	});

	$("#pacchiForm").submit(function(e) {
		
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
}
</script>
</body>
</html>
