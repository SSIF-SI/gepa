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

#actions{
	font-size:1.5em;
	margin:0.6em 0;
}


#dispatch{
	display:none;
}

section{box-sizing: border-box;}
</style>
</head>
<body>
<h1>Pacchi in Uscita</h1>
<h2>Pacchi selezionati: <span id="countPacchi">0</span></h2>
<div id="actions">Azioni: <button id="dispatch" class="btn btn-primary"><i class="fa fa-gift"> </i> Consegna</button></span><span id="action"></span></div>
<form id="pacchiForm" method="POST">
<div id="pacchi" class="row fix">
<?php foreach($pacchiInUscita as $idDestinatario => $pacchi):?>
<section class="col-sm-4 col-lg-2 col-xl-1">
	<div class="destinatario" id="<?=$idDestinatario?>">
		<h1><?=Personale::getInstance()->getNominativo($idDestinatario)?></h1>
		<ul>
		<?php foreach ($pacchi as $pacco):?>
			<li id="<?=preg_replace('/[^a-z0-9]/i', "", $pacco[Registro::CODICE]);?>">
				<input name="id[]" value="<?=$pacco[Registro::ID_PACCO]?>" type="hidden">
				<div style="line-height:2em">
					<em>Codice: </em><strong><?=$pacco[Registro::CODICE]?></strong><br>
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
</form>
<script src="<?=SCRIPTS_PATH?>pacchiInUscita.js"></script>