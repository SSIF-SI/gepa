<h1>Registro</h1>

<table id="registro_view" class="display" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th><?=Registro::ID_PACCO?></th>
			<th><?=Corrieri::CORRIERE?></th>
			<th><?=Registro::CODICE_ESTERNO?></th>
			<th><?=Registro::DESTINATARIO?></th>
			<th><?=Registro::DATA_ARRIVO?></th>
			<th><?=Registro::RICEVENTE?></th>
			<th><?=Registro::DATA_CONSEGNA?></th>
			<th><?=Registro::PRIVATO?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?=Registro::ID_PACCO?></th>
			<th><?=Corrieri::CORRIERE?></th>
			<th><?=Registro::CODICE_ESTERNO?></th>
			<th><?=Registro::DESTINATARIO?></th>
			<th><?=Registro::DATA_ARRIVO?></th>
			<th><?=Registro::RICEVENTE?></th>
			<th><?=Registro::DATA_CONSEGNA?></th>
			<th><?=Registro::PRIVATO?></th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($rows as $row):?>
		<tr>
			<td><?=$row[Registro::ID_PACCO];?></td>
			<td><?=$row[Corrieri::CORRIERE];?></td>
			<td><?=$row[Registro::CODICE_ESTERNO];?></td>
			<td><?=Personale::getInstance()->getNominativo($row[Registro::DESTINATARIO]);?></td>
			<td><?=Utils::convertDateFormat($row[Registro::DATA_ARRIVO],DB_DATE_FORMAT,"d/m/Y H:i");?></td>
			<td><?=Personale::getInstance()->getNominativo($row[Registro::RICEVENTE]);?></td>
			<td><?=Utils::convertDateFormat($row[Registro::DATA_CONSEGNA],DB_DATE_FORMAT,"d/m/Y H:i");?></td>
			<td><?=$row[Registro::ID_PACCO] ? "Si" : "";?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<script>
$(document).ready(function(){
	
		$("#registro_view").DataTable({
			"language": {
			    "sEmptyTable":     "Nessun dato presente nella tabella",
			    "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
			    "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
			    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
			    "sInfoPostFix":    "",
			    "sInfoThousands":  ".",
			    "sLengthMenu":     "Visualizza _MENU_ elementi",
			    "sLoadingRecords": "Caricamento...",
			    "sProcessing":     "Elaborazione...",
			    "sSearch":         "Cerca:",
			    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
			    "oPaginate": {
			        "sFirst":      "Inizio",
			        "sPrevious":   "Precedente",
			        "sNext":       "Successivo",
			        "sLast":       "Fine"
			    },
			    "oAria": {
			        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
			        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
			    }
			},
			"lengthMenu": [ 25, 50, 75, 100 ]
		});
});

</script>