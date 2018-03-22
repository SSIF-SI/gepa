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

<script src="<?=SCRIPTS_PATH?>operatore.js"></script>
