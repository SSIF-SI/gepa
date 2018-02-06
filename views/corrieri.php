<h1>Gestione Corrieri</h1>

<button class="new btn btn-success"><i class="fa fa-plus"> </i> Nuovo corriere</button>
<table id="corrieri_view" class="table table-striped">
	<thead>
		<tr>
			<th><?=Corrieri::ID_CORRIERE?></th>
			<th><?=Corrieri::CORRIERE?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($rows as $row):?>
		<tr id="<?=$row[Corrieri::ID_CORRIERE];?>">
			<td><?=$row[Corrieri::ID_CORRIERE];?></td>
			<td class="corriere"><?=$row[Corrieri::CORRIERE];?></td>
			<td class="action-buttons">
				<button type="button" class="edit btn btn-primary"><i class="fa fa-edit"> </i> Modifica</button>
				<button type="button" class="delete btn btn-danger"><i class="fa fa-trash-alt"> </i> Elimina</button>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<script>
$(document).ready(function(){
	$(".delete").click(function(e){
		var id = $(this).parent().parent().attr("id");
		var corriere =$("#"+id+" .corriere").first().html();
		if(confirm("Sei sicuro di voler eliminare il corriere "+corriere+" ?")){
			 BootstrapDialog.alert('I want banana!');
		}
	});

	$(".edit").click(function(e){
		var id = $(this).parent().parent().attr("id");
	});

	$(".new").click(function(e){

	});
});
</script>