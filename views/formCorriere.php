<style>
.form-group label,
.form-group input
{
	width:100% !important
}
</style>
<form method="POST">
	<div class="form-group">
		<label for="<?=Corrieri::CORRIERE?>"><?=Corrieri::CORRIERE?>:</label>
		<input type="text" id="<?=Corrieri::CORRIERE?>" name="<?=Corrieri::CORRIERE?>" value="<?=$corriere[Corrieri::CORRIERE];?>" />
		<input type="hidden" id="<?=Corrieri::ID_CORRIERE?>" name="<?=Corrieri::ID_CORRIERE?>" value="<?=$corriere[Corrieri::ID_CORRIERE];?>" />
	</div>
</form>