<DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Test</title>
<style>
#codice, #numBadge{
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

.green
{
	border:none;
	background-color: #080;
	text-shadow: 0px 2px #400;
	padding:0.2em !important;
	position:relative;
	top:0;
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
	cursor: pointer;
}

#pacchi ul li.selected{
	border:2px solid #9d2;
	background-color: #cf7;
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
	cursor: pointer;
}

h2 button{
	font-size:0.6em;
	padding:1em;
}

section{box-sizing: border-box;}
</style>
</head>
<body>
<h1>Pacchi in Uscita</h1>
<h2>Pacchi selezionati: <span id="countPacchi">0</span>&nbsp;<span><button id="dispatch" class="action-button shadow animate blue">Consegna</button></span><span id="action"></span></h2>
<form id="pacchiForm" method="POST">
<div id="pacchi" class="row fix">
<?php foreach($pacchiInUscita as $idDestinatario => $pacchi):?>
<section class="col-sm-4 col-lg-2 col-xl-1">
	<div class="destinatario" id="<?=$idDestinatario?>">
		<h1><?=Personale::getInstance()->getNominativo($idDestinatario)?></h1>
		<ul>
		<?php foreach ($pacchi as $pacco):?>
			<li id="<?=$pacco[Registro::CODICE_ESTERNO]?>">
				<input name="id[]" value="<?=$pacco[Registro::ID_PACCO]?>" type="hidden">
				<div style="line-height:2em">
					<em>Codice: </em><strong><?=$pacco[Registro::CODICE_ESTERNO]?></strong><br>
					<em>Corriere:</em> <strong><?=$corrieri[$pacco[Registro::ID_CORRIERE]]?></strong><br>
					<em>Tipo Pacco:</em> <strong><?=$pacco[Registro::PRIVATO] ? "Privato" : "Istituzionale"?></strong>
				</div>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
</section>
<?php endforeach;?>
</div>
<input type="text" id="codice" value="" />
<input type="text" id="numBadge" value="" />
</form>
<script>
$(document).ready(function(){
	var Const = {
		waitingForBadge: false	
	};

	$("#dispatch").hide();
	
	$(".destinatario h1").click(function(e){
		if(Const.waitingForBadge) return;
		var id = $(this).parent().attr("id");
		
		$("#"+id+" ul li").each(function(i){
			$(this).addClass("selected");
		});
		refreshCountPacchi();
	})
	$("li").click(function(e){
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

		$('#dispatch').hide();
		
		$("#action").html(" - Passare il badge... <i class='fa fa-sync fa-spin'></i> &nbsp;<button id='cancel' class='action-button shadow animate red'>Annulla</button>");
		numBadge = $("#numBadge");
		numBadge.val("");
		numBadge.focus();

		refreshButtons();
		
		numBadge.keydown(function(event) {

			if(event.keyCode == 13){
				event.preventDefault();
				var badge = $(this).val().substring(4,10);
				$(this).val("");
				if(badge.length != 6) return;
				$.ajax({
			           type: "POST",
			           url: "?action=getUser",
			           data: {numBadge: badge}, // serializes the form's elements.
					   dataType: "json",
			           success: function(data)
			           {
				            $('#dispatch').hide();
							if(!data){
								alert("Utente non riconosciuto, riprovare.");
								return;
							}

							$("#action").html(" - Consegna a "+data.nome+" "+data.cognome+" <button id='confirm' class='action-button shadow animate green'>Conferma</button>&nbsp;<button id='cancel' class='action-button shadow animate red'>Annulla</button>");
							$("#numBadge").blur();
			           },
			           error: function(){ alert("Errore di connessione!")}
			         });
			}
		});

	});

	function refreshCountPacchi(){
		var pacchiDaConsegnare = $("li.selected").length;
		$("#countPacchi").html(pacchiDaConsegnare);
		pacchiDaConsegnare > 0 ? $("#dispatch").show() : $("#dispatch").hide();
	}	

	function refreshButtons(){
		$("#cancel").click(function(e){
			$('#dispatch').show();
			$("#action").html("");
			Const.waitingForBadge = false;
		});
	}
	$(document).keydown(function (e) {
		if(!Const.waitingForBadge) $("#codice").focus();
		e = e || window.event;//Get event
	    if (e.ctrlKey) {
	        var c = e.which || e.keyCode;//Get key code
	        switch (c) {
		        case 74://Block Ctrl+J
		            e.preventDefault();     
	                e.stopPropagation();
	                break;
	        }
	    }
	});

	$("#codice").keydown(function(e){
		if(e.keyCode == 13){
			e.preventDefault();
			var codice = $(this).val();
			var idCodice = codice.replace(/[\+#,\.\?]/g,"");
			$(this).val("");
			$("li#"+idCodice).addClass("selected");
			refreshCountPacchi();
		}
	});

	$("#codice").focus();
});
</script>
</body>
</html>
