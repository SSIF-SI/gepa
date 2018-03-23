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

	<label for="mepaCode">MEPA:</label>
	<input id="mepaCode" type="text" value="" size="7" disabled="disabled"/>
	
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
	<button id="scan" class="btn btn-success"><i class="fa fa-spinner"> </i> Scan</button>&nbsp;&nbsp;
	<button id="save" class="btn btn-primary"><i class="fa fa-save"> </i> Salva</button>
	<h2>Pacchi totali: <span id="nPacchi">0</span></h2>
	
<div id="pacchi" class="row fix">
</div>
</form>
<script src="<?=SCRIPTS_PATH?>pacchiInEntrata.js"></script>
