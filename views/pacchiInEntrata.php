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
	border-radius: 6px;
	padding:0.2em;
	margin-right:1em;
	font-weight:normal;
}

.animate
{
	transition: all 0.1s;
	-webkit-transition: all 0.1s;
}

.action-button
{
	position: relative;
	padding: 10px;
 	border-radius: 10px;
	color: #FFF;
	text-decoration: none;	
	cursor:pointer;
}

.blue
{
	border:none;
	background-color: #00a1cb;
	text-shadow: 0px 2px #2980B9;
}

.red
{
	border:none;
	background-color: #800;
	text-shadow: 0px 2px #400;
	padding:0.2em !important;
	position:relative;
	top:0;
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
	<input id="save" type="button" value="Salva" class="action-button shadow animate blue"/>

<div id="pacchi" class="row fix">
</div>
</form>
<script>
$(document).ready(function(){
	$("#codice").val("");
	$( document ).keydown(function(event) {
			$("#codice").focus();
			if(event.keyCode == 13){
				event.preventDefault();
				var codice = $("#codice").val();
				var idCodice = codice.replace(/[+#,.]/,"");
				if($("#"+idCodice).length == 0){

					var destinatario = $("#destinatario").val();
					var destinatarioText = $("#destinatario").find(":selected").text();

					var tipoPacco = $("#privato").val();
					var tipoPaccoText = $("#privato").find(":selected").text();

					var corriere = $("#corriere").val();
					var corriereText = $("#corriere").find(":selected").text();

					if(destinatario && corriere){
						if($("#"+destinatario).length == 0){
							$("#pacchi").append('<section class="col-sm-4 col-lg-2 col-xl-1"><div class="destinatario" id="'+destinatario+'"><input type="hidden" name="destinatario[]" value="'+destinatario+'" /><h1>'+destinatarioText+'</h1><ul></ul></div></section>');
						}
						
						inputData = "<input type='hidden' name='codice["+destinatario+"][]' value=\""+codice.replace('"',"&quot;")+"\" />";
						inputData += "<input type='hidden' name='corriere["+destinatario+"][]' value='"+corriere+"'/>";
						inputData += "<input type='hidden' name='privato["+destinatario+"][]' value='"+tipoPacco+"'/>";
						
						var li = "<li id='"+idCodice+"'>"+inputData+"<div style='line-height:2em'><em>Codice: </em><strong>"+codice+"</strong><br/><em>Corriere:</em> <strong>"+corriereText+"</strong><br/><em>Tipo Pacco:</em> <strong>"+tipoPaccoText+"</strong></div><div style='text-align:right'><button class='animate action-button red' onClick='removePack(\""+idCodice+"\",\""+destinatario+"\");'>Rimuovi</button></div></li>";
						
						$("#"+destinatario+" ul").append(li);
					} else alert("Destinatario e Corriere devono essere valorizzati");
				}
				$("#codice").val("");
			}

	});
	
	$("#save").click(function(e){
		if($("#pacchi section").length == 0){
			alert("Nessun pacco sparato.");
			return;
		}
		alert("OK!!");
		
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
